<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Daftar percakapan freelancer.
     */
    public function index(): View
    {
        $freelancerProfile = auth()->user()
            ->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $conversations = Conversation::query()
            ->with([
                'client',
                'service',
            ])
            ->withCount([
                'messages as unread_messages_count' => function ($query) {
                    $query
                        ->where('sender_id', '!=', auth()->id())
                        ->where('is_read', false);
                },
            ])
            ->where(
                'freelancer_profile_id',
                $freelancerProfile->id
            )
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->get();

        return view(
            'freelancer.messages.index',
            compact('conversations')
        );
    }

    /**
     * Membuka percakapan.
     */
    public function show(Conversation $conversation): View
    {
        $freelancerProfile = auth()->user()
            ->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $conversation->freelancer_profile_id ===
                $freelancerProfile->id,
            403
        );

        $conversation->load([
            'client',
            'freelancerProfile.user',
            'service',
            'messages.sender',
            'offers.client',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Tandai pesan dari client sebagai sudah dibaca.
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

        return view(
            'freelancer.messages.show',
            compact('conversation')
        );
    }

    /**
     * Mengirim pesan freelancer.
     */
    public function store(
        Request $request,
        Conversation $conversation
    ): RedirectResponse {
        $freelancerProfile = auth()->user()
            ->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $conversation->freelancer_profile_id ===
                $freelancerProfile->id,
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
            'sender_id' => auth()->id(),
            'message' => $validated['message'],
            'type' => 'text',
            'is_read' => false,
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        return redirect()
            ->route(
                'freelancer.messages.show',
                $conversation
            )
            ->with('success', 'Pesan berhasil dikirim.');
    }
}