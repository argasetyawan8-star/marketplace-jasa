<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MessageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Percakapan
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $freelancerProfile = auth()->user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $query = Conversation::query()
            ->with([
                'client',
                'service',
                'job',
                'jobProposal',
            ])
            ->where(
                'freelancer_profile_id',
                $freelancerProfile->id
            )
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at');

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        $filter = $request->string('filter')->toString();

        if ($filter === 'unread') {
            $query->whereHas('messages', function ($messageQuery) {
                $messageQuery
                    ->where('sender_id', '!=', auth()->id())
                    ->where('is_read', false);
            });
        }

        $conversations = $query->get();

        /*
        |--------------------------------------------------------------------------
        | Unread Count
        |--------------------------------------------------------------------------
        */

        $unreadCount = Message::query()
            ->whereHas('conversation', function ($conversationQuery) use ($freelancerProfile) {
                $conversationQuery->where(
                    'freelancer_profile_id',
                    $freelancerProfile->id
                );
            })
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->count();

        return view('freelancer.messages.index', [
            'conversations' => $conversations,
            'unreadCount' => $unreadCount,
            'filter' => $filter,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Percakapan
    |--------------------------------------------------------------------------
    */

    public function show(Conversation $conversation): View
    {
        $freelancerProfile = auth()->user()->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $conversation->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        $conversation->load([
            'client',
            'freelancerProfile.user',
            'service',
            'job',
            'job.category',
            'job.subcategory',
            'jobProposal.selectedExperience',
            'jobProposal.portfolios',
            'messages.sender',
            'offers.client',
            'order.items',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Tandai pesan masuk sebagai sudah dibaca
        |--------------------------------------------------------------------------
        */

        Message::query()
            ->where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return view('freelancer.messages.show', [
            'conversation' => $conversation,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Kirim Pesan
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        Conversation $conversation
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $freelancerProfile = auth()->user()->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $conversation->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        |
        | message boleh kosong jika user mengirim:
        | - voice note
        | - gambar
        | - file
        |
        */

        $validated = $request->validate([
            'message' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'type' => [
                'nullable',
                'string',
                'in:text,image,file,voice,voice_note,audio',
            ],

            'attachment' => [
                'nullable',
                'file',
                'max:10240',
            ],

            'image' => [
                'nullable',
                'image',
                'max:10240',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Ambil Isi Pesan
        |--------------------------------------------------------------------------
        */

        $text = trim(
            (string) ($validated['message'] ?? '')
        );

        /*
        |--------------------------------------------------------------------------
        | Ambil File Upload
        |--------------------------------------------------------------------------
        |
        | Voice recorder menggunakan:
        | name="attachment"
        |
        | Upload gambar menggunakan:
        | name="image"
        |
        */

        $uploadedFile = null;

        if ($request->hasFile('attachment')) {
            $uploadedFile = $request->file('attachment');
        } elseif ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan Ada Pesan atau Attachment
        |--------------------------------------------------------------------------
        */

        if ($text === '' && !$uploadedFile) {
            return back()
                ->withInput()
                ->withErrors([
                    'message' => 'Pesan atau lampiran wajib diisi.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Default Message Type
        |--------------------------------------------------------------------------
        */

        $messageType = 'text';

        $attachmentPath = null;
        $attachmentName = null;
        $attachmentMime = null;
        $attachmentSize = null;

        /*
        |--------------------------------------------------------------------------
        | Proses Attachment
        |--------------------------------------------------------------------------
        */

        if ($uploadedFile) {
            $attachmentMime = $uploadedFile->getMimeType();
            $attachmentSize = $uploadedFile->getSize();
            $attachmentName = $uploadedFile->getClientOriginalName();

            /*
            |--------------------------------------------------------------------------
            | Tentukan Jenis File
            |--------------------------------------------------------------------------
            */

            $requestedType = $validated['type'] ?? null;

            /*
            |--------------------------------------------------------------------------
            | Voice
            |--------------------------------------------------------------------------
            |
            | MediaRecorder dari browser bisa menghasilkan:
            |
            | audio/webm
            | audio/ogg
            | audio/wav
            | video/webm
            |
            | Karena recorder kita sudah mengirim:
            | type=voice_note
            |
            | maka type tersebut kita jadikan penentu utama.
            |
            */

            $isVoice = in_array(
                $requestedType,
                [
                    'voice',
                    'voice_note',
                    'audio',
                ],
                true
            );

            /*
            |--------------------------------------------------------------------------
            | Jika MIME terdeteksi audio
            |--------------------------------------------------------------------------
            */

            if (
                $isVoice ||
                ($attachmentMime &&
                    str_starts_with(
                        strtolower($attachmentMime),
                        'audio/'
                    ))
            ) {
                $messageType = 'voice';

                $attachmentPath = $uploadedFile->store(
                    'messages/voice',
                    'public'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Image
            |--------------------------------------------------------------------------
            */

            elseif (
                $requestedType === 'image' ||
                (
                    $attachmentMime &&
                    str_starts_with(
                        strtolower($attachmentMime),
                        'image/'
                    )
                )
            ) {
                $messageType = 'image';

                $attachmentPath = $uploadedFile->store(
                    'messages/images',
                    'public'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | File
            |--------------------------------------------------------------------------
            */

            else {
                $messageType = 'file';

                $attachmentPath = $uploadedFile->store(
                    'messages/files',
                    'public'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Pastikan File Berhasil Disimpan
            |--------------------------------------------------------------------------
            */

            if (!$attachmentPath) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'message' => 'File gagal disimpan. Silakan coba lagi.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Buat Message
        |--------------------------------------------------------------------------
        |
        | PENTING:
        | Kolom messages.message di database kamu NOT NULL.
        |
        | Jadi ketika voice/image/file dikirim tanpa teks,
        | kita simpan string kosong ''.
        |
        | JANGAN gunakan null di sini.
        |
        */

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),

            'message' => $text,

            'type' => $messageType,

            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,

            'is_read' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Waktu Percakapan
        |--------------------------------------------------------------------------
        */

        $conversation->update([
            'last_message_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notification ke Client
        |--------------------------------------------------------------------------
        */

        $conversation->loadMissing('client');

        $client = $conversation->client;

        if ($client) {
            /*
            |--------------------------------------------------------------------------
            | Notification Preview
            |--------------------------------------------------------------------------
            */

            if ($messageType === 'voice') {
                $preview = '🎙️ Voice note';
            } elseif ($messageType === 'image') {
                $preview = '🖼️ Mengirim gambar';
            } elseif ($messageType === 'file') {
                $preview = '📎 Mengirim lampiran';
            } else {
                $preview = trim(
                    preg_replace(
                        '/\s+/',
                        ' ',
                        (string) $message->message
                    )
                );

                if (mb_strlen($preview) > 120) {
                    $preview = mb_substr(
                        $preview,
                        0,
                        117
                    ) . '...';
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Kirim Notification
            |--------------------------------------------------------------------------
            */

            app(NotificationService::class)->send(
                recipient: $client,

                event: NotificationService::MESSAGE_RECEIVED,

                title: 'Pesan baru dari freelancer',

                message: $preview,

                actionUrl: route(
                    'client.messages.show',
                    $conversation
                ),

                priority: 'action',

                actor: auth()->user(),

                relatedType: 'conversation',

                relatedId: $conversation->id,

                extra: [
                    'message_id' => $message->id,
                    'conversation_id' => $conversation->id,
                ],

                dedupeKey: 'message_received:' . $message->id,
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        $successMessage = match ($messageType) {
            'voice' => 'Voice note berhasil dikirim.',
            'image' => 'Gambar berhasil dikirim.',
            'file' => 'Lampiran berhasil dikirim.',
            default => 'Pesan berhasil dikirim.',
        };

        /*
        |--------------------------------------------------------------------------
        | Kembali ke Chat
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'freelancer.messages.show',
                $conversation
            )
            ->with(
                'success',
                $successMessage
            );
    }
}
