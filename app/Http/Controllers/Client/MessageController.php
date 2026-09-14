<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Menampilkan daftar percakapan client.
     */
    public function index()
    {
        $conversations = Conversation::query()
            ->where('client_id', Auth::id())
            ->with([
                'freelancerProfile.user',
                'service',
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
     * Menampilkan detail percakapan.
     */
    public function show(Conversation $conversation)
    {
        abort_unless(
            $conversation->client_id === Auth::id(),
            403
        );

        $conversation->load([
            'client',
            'freelancerProfile.user',
            'service',
            'messages.sender',
            'offers.freelancerProfile.user',
        ]);

        // Tandai pesan dari freelancer sebagai sudah dibaca.
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return view(
            'client.messages.show',
            compact('conversation')
        );
    }


    /**
     * Mengirim pesan dari client.
     */
    public function store(
        Request $request,
        Conversation $conversation
    ) {
        abort_unless(
            $conversation->client_id === Auth::id(),
            403
        );

        $validated = $request->validate([
            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'message' => $validated['message'],
            'type' => 'text',
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        return back()->with(
            'success',
            'Pesan berhasil dikirim.'
        );
    }


    /**
     * Memulai percakapan dari halaman jasa.
     */
    public function start(Service $service)
    {
        abort_unless(
            $service->status === 'published',
            404
        );

        $freelancerProfile = $service->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            404
        );

        abort_unless(
            $freelancerProfile->user_id !== Auth::id(),
            403
        );

        $conversation = Conversation::query()
            ->where('client_id', Auth::id())
            ->where(
                'freelancer_profile_id',
                $freelancerProfile->id
            )
            ->where(
                'service_id',
                $service->id
            )
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'client_id' => Auth::id(),
                'freelancer_profile_id' => $freelancerProfile->id,
                'service_id' => $service->id,
                'status' => 'active',
                'last_message_at' => now(),
            ]);

            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'message' => "Halo Kak 👋\n\n"
                    . "Saya tertarik dengan jasa \"{$service->title}\".\n\n"
                    . "Saya ingin berdiskusi terlebih dahulu mengenai kebutuhan, "
                    . "detail pekerjaan, dan harga yang sesuai.\n\n"
                    . "Terima kasih!",
                'type' => 'text',
            ]);

            $conversation->update([
                'last_message_at' => now(),
            ]);
        }

        return redirect()->route(
            'client.messages.show',
            $conversation
        );
    }
}
