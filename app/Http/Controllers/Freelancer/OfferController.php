<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function create(Conversation $conversation)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $conversation->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        $conversation->load([
            'client',
            'service',
        ]);

        return view('freelancer.messages.offer-create', compact(
            'conversation'
        ));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $conversation->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:1'],
            'delivery_days' => ['required', 'integer', 'min:1', 'max:365'],
            'revision_count' => ['required', 'integer', 'min:0', 'max:100'],
            'expires_at' => ['nullable', 'date'],
        ]);

        $offer = Offer::create([
            'conversation_id' => $conversation->id,
            'client_id' => $conversation->client_id,
            'freelancer_profile_id' => $freelancerProfile->id,
            'service_id' => $conversation->service_id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'delivery_days' => $validated['delivery_days'],
            'revision_count' => $validated['revision_count'],
            'status' => 'sent',
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'message' => "Saya mengirimkan penawaran \"{$offer->title}\" dengan nilai Rp "
                . number_format($offer->price, 0, ',', '.')
                . ". Silakan diperiksa dan disetujui apabila sudah sesuai.",
            'type' => 'offer',
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        return redirect()
            ->route('freelancer.messages.show', $conversation)
            ->with('success', 'Penawaran berhasil dikirim.');
    }
}