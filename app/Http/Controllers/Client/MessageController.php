<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Service;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Daftar percakapan client.
     *
     * 1 conversation = 1 client + 1 freelancer.
     */
    public function index(): View
    {
        $conversations = Conversation::query()
            ->where('client_id', Auth::id())
            ->with([
                'freelancerProfile.user',
                'service',
                'job',
                'jobProposal',
            ])
            ->withCount('messages')
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->get();

        return view(
            'client.messages.index',
            compact('conversations')
        );
    }

    /**
     * Detail conversation.
     */
    public function show(
        Conversation $conversation
    ): View {
        abort_unless(
            (int) $conversation->client_id === (int) Auth::id(),
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
            'offers.freelancerProfile.user',
            'order.items',
        ]);

        /**
         * Tandai pesan freelancer sebagai sudah dibaca.
         */
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        /**
         * Reload messages agar status read terbaru
         * ikut terbawa ke view.
         */
        $conversation->load('messages.sender');

        return view(
            'client.messages.show',
            compact('conversation')
        );
    }

    /**
     * Kirim:
     * - text
     * - image
     * - file
     * - voice note
     *
     * Text TIDAK wajib diisi jika ada attachment.
     */
    public function store(
        Request $request,
        Conversation $conversation
    ): RedirectResponse {
        abort_unless(
            (int) $conversation->client_id === (int) Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | BASIC INPUT
        |--------------------------------------------------------------------------
        */

        $text = trim(
            (string) $request->input('message', '')
        );

        $hasAttachment = $request->hasFile('attachment');

        $hasVoiceNote = $request->hasFile('voice_note');

        /*
        |--------------------------------------------------------------------------
        | JANGAN KIRIM ATTACHMENT + VOICE BERSAMAAN
        |--------------------------------------------------------------------------
        */

        if ($hasAttachment && $hasVoiceNote) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kirim foto/file atau voice note secara terpisah.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | BATAS TEXT
        |--------------------------------------------------------------------------
        */

        if (mb_strlen($text) > 5000) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pesan maksimal 5000 karakter.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TIDAK BOLEH BENAR-BENAR KOSONG
        |--------------------------------------------------------------------------
        |
        | Pesan boleh kosong selama:
        | - ada attachment biasa
        | - atau ada voice note
        |
        */

        if (
            $text === '' &&
            !$hasAttachment &&
            !$hasVoiceNote
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Tulis pesan atau pilih file untuk dikirim.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | DEFAULT MESSAGE DATA
        |--------------------------------------------------------------------------
        */

        $type = 'text';

        $attachmentPath = null;
        $attachmentName = null;
        $attachmentMime = null;
        $attachmentSize = null;

        /*
        |--------------------------------------------------------------------------
        | REGULAR ATTACHMENT
        |--------------------------------------------------------------------------
        */

        if ($hasAttachment) {
            $file = $request->file('attachment');

            if (
                !$file ||
                !$file->isValid()
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'File tidak valid.'
                    );
            }

            /*
            | Maksimal 20 MB.
            */
            if (
                $file->getSize() >
                20 * 1024 * 1024
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'File maksimal 20 MB.'
                    );
            }

            $mime = strtolower(
                (string) $file->getMimeType()
            );

            $extension = strtolower(
                (string) $file->getClientOriginalExtension()
            );

            /*
            |--------------------------------------------------------------------------
            | IMAGE
            |--------------------------------------------------------------------------
            */

            $allowedImages = [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
            ];

            /*
            |--------------------------------------------------------------------------
            | DOCUMENT / FILE
            |--------------------------------------------------------------------------
            */

            $allowedFiles = [
                'application/pdf',

                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',

                'text/plain',

                'application/zip',
                'application/x-zip-compressed',

                'application/x-rar-compressed',

                'application/octet-stream',
            ];

            $allowedFileExtensions = [
                'pdf',
                'doc',
                'docx',
                'xls',
                'xlsx',
                'ppt',
                'pptx',
                'txt',
                'zip',
                'rar',
            ];

            /*
            |--------------------------------------------------------------------------
            | TENTUKAN TYPE ATTACHMENT
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $mime,
                    $allowedImages,
                    true
                )
            ) {
                $type = 'image';
            } elseif (
                in_array(
                    $mime,
                    $allowedFiles,
                    true
                )
            ) {
                $type = 'file';
            } elseif (
                in_array(
                    $extension,
                    $allowedFileExtensions,
                    true
                )
            ) {
                /*
                | Fallback jika PHP mengembalikan MIME
                | application/octet-stream.
                */
                $type = 'file';
            } else {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Format file tidak didukung.'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN ATTACHMENT
            |--------------------------------------------------------------------------
            */

            $attachmentPath = $file->store(
                'messages/files',
                'public'
            );

            $attachmentName =
                $file->getClientOriginalName();

            $attachmentMime = $mime;

            $attachmentSize =
                $file->getSize();
        }

        /*
        |--------------------------------------------------------------------------
        | VOICE NOTE
        |--------------------------------------------------------------------------
        */

        if ($hasVoiceNote) {
            $voice = $request->file('voice_note');

            /*
            | Pastikan file benar-benar diterima PHP.
            */
            if (
                !$voice ||
                !$voice->isValid()
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Voice note tidak valid atau gagal diupload.'
                    );
            }

            /*
            | Maksimal 10 MB.
            */
            if (
                $voice->getSize() >
                10 * 1024 * 1024
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Voice note maksimal 10 MB.'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | MIME + EXTENSION
            |--------------------------------------------------------------------------
            |
            | MediaRecorder Chromium dapat menghasilkan:
            |
            | audio/webm
            | video/webm
            | audio/ogg
            | application/ogg
            | audio/mp4
            | audio/x-m4a
            | audio/wav
            | audio/x-wav
            | application/octet-stream
            |
            | Karena itu kita jangan hanya percaya MIME.
            |--------------------------------------------------------------------------
            */

            $voiceMime = strtolower(
                (string) $voice->getMimeType()
            );

            $voiceExtension = strtolower(
                (string) $voice->getClientOriginalExtension()
            );

            /*
            |--------------------------------------------------------------------------
            | MIME VOICE YANG DITERIMA
            |--------------------------------------------------------------------------
            */

            $allowedVoiceMimes = [
                'audio/webm',
                'video/webm',

                'audio/ogg',
                'application/ogg',

                'audio/mpeg',
                'audio/mp3',

                'audio/mp4',
                'audio/x-m4a',

                'audio/wav',
                'audio/x-wav',

                'application/octet-stream',
            ];

            /*
            |--------------------------------------------------------------------------
            | EXTENSION VOICE YANG DITERIMA
            |--------------------------------------------------------------------------
            */

            $allowedVoiceExtensions = [
                'webm',
                'ogg',
                'oga',
                'mp3',
                'mpeg',
                'mp4',
                'm4a',
                'wav',
            ];

            /*
            |--------------------------------------------------------------------------
            | VALIDASI VOICE
            |--------------------------------------------------------------------------
            |
            | Diterima jika:
            |
            | 1. MIME memang audio/webm dsb.
            | ATAU
            |
            | 2. Extension menunjukkan file audio.
            |
            | Ini penting untuk Chromium + PHP/Laragon.
            |--------------------------------------------------------------------------
            */

            $isVoiceMimeAllowed = in_array(
                $voiceMime,
                $allowedVoiceMimes,
                true
            );

            $isVoiceExtensionAllowed = in_array(
                $voiceExtension,
                $allowedVoiceExtensions,
                true
            );

            /*
            | Jika MIME diawali audio/, otomatis anggap audio.
            */
            $isAudioMime = str_starts_with(
                $voiceMime,
                'audio/'
            );

            if (
                !$isVoiceMimeAllowed &&
                !$isVoiceExtensionAllowed &&
                !$isAudioMime
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Format voice note tidak didukung. Silakan gunakan voice note dari browser.'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | TYPE
            |--------------------------------------------------------------------------
            */

            $type = 'voice';

            /*
            |--------------------------------------------------------------------------
            | SIMPAN VOICE NOTE
            |--------------------------------------------------------------------------
            */

            $attachmentPath = $voice->store(
                'messages/files',
                'public'
            );

            $attachmentName =
                $voice->getClientOriginalName();

            if (
                !$attachmentName
            ) {
                $attachmentName =
                    'voice-note.' .
                    ($voiceExtension ?: 'webm');
            }

            $attachmentMime = $voiceMime;

            $attachmentSize =
                $voice->getSize();

            /*
            | Voice note tidak memerlukan text.
            */
            $text = '';
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE MESSAGE
        |--------------------------------------------------------------------------
        |
        | message TIDAK pernah NULL.
        |
        | Attachment-only:
        | message = ''
        |
        */

        $message = Message::create([
            'conversation_id' =>
                $conversation->id,

            'sender_id' =>
                Auth::id(),

            'message' =>
                $text,

            'type' =>
                $type,

            'attachment_path' =>
                $attachmentPath,

            'attachment_name' =>
                $attachmentName,

            'attachment_mime' =>
                $attachmentMime,

            'attachment_size' =>
                $attachmentSize,

            'is_read' =>
                false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE CONVERSATION
        |--------------------------------------------------------------------------
        */

        $conversation->update([
            'last_message_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION
        |--------------------------------------------------------------------------
        */

        $conversation->loadMissing(
            'freelancerProfile.user'
        );

        $freelancer =
            $conversation
                ->freelancerProfile
                ?->user;

        if ($freelancer) {

            /*
            | Preview notification.
            */

            if ($type === 'image') {

                $preview =
                    'Pembeli mengirim foto.';

            } elseif ($type === 'file') {

                $preview =
                    'Pembeli mengirim file' .
                    (
                        $attachmentName
                            ? ': ' . $attachmentName
                            : '.'
                    );

            } elseif ($type === 'voice') {

                $preview =
                    'Pembeli mengirim voice note.';

            } else {

                $preview = $text;

                $preview = trim(
                    preg_replace(
                        '/\s+/',
                        ' ',
                        $preview
                    )
                );

                if (
                    mb_strlen($preview) > 120
                ) {
                    $preview =
                        mb_substr(
                            $preview,
                            0,
                            117
                        ) . '...';
                }
            }

            /*
            | Kirim notifikasi ke freelancer.
            */
            app(
                NotificationService::class
            )->send(
                recipient: $freelancer,

                event:
                    NotificationService::MESSAGE_RECEIVED,

                title:
                    'Pesan baru dari pembeli',

                message:
                    $preview,

                actionUrl:
                    route(
                        'freelancer.messages.show',
                        $conversation
                    ),

                priority:
                    'action',

                actor:
                    Auth::user(),

                relatedType:
                    'conversation',

                relatedId:
                    $conversation->id,

                extra: [
                    'message_id' =>
                        $message->id,

                    'conversation_id' =>
                        $conversation->id,
                ],

                dedupeKey:
                    'message_received:' .
                    $message->id,
            );
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            match ($type) {
                'image' =>
                    'Foto berhasil dikirim.',

                'file' =>
                    'File berhasil dikirim.',

                'voice' =>
                    'Voice note berhasil dikirim.',

                default =>
                    'Pesan berhasil dikirim.',
            }
        );
    }

    /**
     * Mulai conversation dari halaman jasa.
     *
     * 1 client + 1 freelancer = 1 conversation.
     */
    public function start(
        Service $service
    ): RedirectResponse {
        abort_unless(
            $service->status === 'published',
            404
        );

        $freelancerProfile =
            $service->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            404
        );

        abort_unless(
            (int) $freelancerProfile->user_id !==
                (int) Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | CARI CONVERSATION EXISTING
        |--------------------------------------------------------------------------
        |
        | Service sengaja tidak dijadikan syarat.
        |
        */

        $conversation =
            Conversation::query()
                ->where(
                    'client_id',
                    Auth::id()
                )
                ->where(
                    'freelancer_profile_id',
                    $freelancerProfile->id
                )
                ->orderByDesc(
                    'last_message_at'
                )
                ->orderByDesc(
                    'updated_at'
                )
                ->first();

        /*
        |--------------------------------------------------------------------------
        | BUAT CONVERSATION BARU
        |--------------------------------------------------------------------------
        */

        if (!$conversation) {

            $conversation =
                Conversation::create([
                    'client_id' =>
                        Auth::id(),

                    'freelancer_profile_id' =>
                        $freelancerProfile->id,

                    'service_id' =>
                        $service->id,

                    'job_id' =>
                        null,

                    'job_proposal_id' =>
                        null,

                    'status' =>
                        'active',

                    'last_message_at' =>
                        now(),
                ]);

            /*
            |--------------------------------------------------------------------------
            | PESAN PEMBUKA OTOMATIS
            |--------------------------------------------------------------------------
            */

            $message =
                Message::create([
                    'conversation_id' =>
                        $conversation->id,

                    'sender_id' =>
                        Auth::id(),

                    'message' =>
                        "Halo Kak 👋\n\n" .
                        "Saya tertarik dengan jasa " .
                        "\"{$service->title}\".\n\n" .
                        "Saya ingin berdiskusi terlebih dahulu " .
                        "mengenai kebutuhan, detail pekerjaan, " .
                        "dan harga yang sesuai.\n\n" .
                        "Terima kasih!",

                    'type' =>
                        'text',

                    'attachment_path' =>
                        null,

                    'attachment_name' =>
                        null,

                    'attachment_mime' =>
                        null,

                    'attachment_size' =>
                        null,

                    'is_read' =>
                        false,
                ]);

            /*
            |--------------------------------------------------------------------------
            | UPDATE LAST MESSAGE
            |--------------------------------------------------------------------------
            */

            $conversation->update([
                'last_message_at' =>
                    now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | NOTIFIKASI FREELANCER
            |--------------------------------------------------------------------------
            */

            $freelancer =
                $freelancerProfile->user;

            if ($freelancer) {

                app(
                    NotificationService::class
                )->send(
                    recipient: $freelancer,

                    event:
                        NotificationService::MESSAGE_RECEIVED,

                    title:
                        'Pesan baru dari pembeli',

                    message:
                        'Pembeli tertarik dengan jasa "' .
                        $service->title .
                        '" dan mengirim pesan baru.',

                    actionUrl:
                        route(
                            'freelancer.messages.show',
                            $conversation
                        ),

                    priority:
                        'action',

                    actor:
                        Auth::user(),

                    relatedType:
                        'conversation',

                    relatedId:
                        $conversation->id,

                    extra: [
                        'message_id' =>
                            $message->id,

                        'conversation_id' =>
                            $conversation->id,

                        'service_id' =>
                            $service->id,
                    ],

                    dedupeKey:
                        'message_received:' .
                        $message->id,
                );
            }

        } else {

            /*
            |--------------------------------------------------------------------------
            | CONVERSATION SUDAH ADA
            |--------------------------------------------------------------------------
            |
            | Service terakhir yang dibahas dijadikan konteks.
            |
            */

            if (
                (int) $conversation->service_id !==
                (int) $service->id
            ) {
                $conversation->update([
                    'service_id' =>
                        $service->id,
                ]);
            }
        }

        return redirect()->route(
            'client.messages.show',
            $conversation
        );
    }
}