<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Job;
use App\Models\JobProposal;
use App\Models\Message;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OfferController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SERVICE MARKETPLACE
    |--------------------------------------------------------------------------
    */

    /**
     * Form membuat penawaran dari percakapan jasa.
     */
    public function createService(
        Conversation $conversation
    ): View {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Pastikan conversation milik freelancer yang sedang login
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $conversation->freelancer_profile_id ===
                $freelancerProfile->id,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Percakapan harus berasal dari jasa
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $conversation->service_id,
            404
        );

        $conversation->load([
            'client',
            'service',
            'service.category',
            'service.subcategory',
            'offers',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pastikan jasa memang milik freelancer yang login
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $conversation->service?->freelancer_profile_id ===
                $freelancerProfile->id,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Jangan membuat penawaran baru jika masih ada quotation aktif
        |--------------------------------------------------------------------------
        */

        $hasActiveOffer = Offer::query()
            ->where(
                'conversation_id',
                $conversation->id
            )
            ->whereIn(
                'status',
                ['sent', 'accepted']
            )
            ->where(function ($query) {
                $query
                    ->whereNull('expires_at')
                    ->orWhere(
                        'expires_at',
                        '>',
                        now()
                    );
            })
            ->exists();

        return view(
            'freelancer.offers.service-create',
            compact(
                'conversation',
                'freelancerProfile',
                'hasActiveOffer'
            )
        );
    }

    /**
     * Simpan penawaran dari percakapan jasa.
     */
    public function storeService(
        Request $request,
        Conversation $conversation
    ): RedirectResponse {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Ownership conversation
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $conversation->freelancer_profile_id ===
                $freelancerProfile->id,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Conversation harus memiliki jasa
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $conversation->service_id,
            404
        );

        $conversation->load([
            'client',
            'service',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Jasa harus milik freelancer yang login
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $conversation->service?->freelancer_profile_id ===
                $freelancerProfile->id,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Jasa harus tersedia di marketplace
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $conversation->service?->status === 'published',
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:10000',
            ],

            'price' => [
                'required',
                'numeric',
                'min:1',
            ],

            'delivery_days' => [
                'required',
                'integer',
                'min:1',
                'max:365',
            ],

            'revision_count' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:now',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pastikan tidak ada quotation aktif
        |--------------------------------------------------------------------------
        */

        $hasActiveOffer = Offer::query()
            ->where(
                'conversation_id',
                $conversation->id
            )
            ->whereIn(
                'status',
                ['sent', 'accepted']
            )
            ->where(function ($query) {
                $query
                    ->whereNull('expires_at')
                    ->orWhere(
                        'expires_at',
                        '>',
                        now()
                    );
            })
            ->exists();

        if ($hasActiveOffer) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Masih ada quotation aktif pada percakapan ini.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Buat offer
        |--------------------------------------------------------------------------
        */

        $offer = Offer::create([
            'conversation_id' =>
                $conversation->id,

            'client_id' =>
                $conversation->client_id,

            'freelancer_profile_id' =>
                $freelancerProfile->id,

            'service_id' =>
                $conversation->service_id,

            'job_id' =>
                null,

            'job_proposal_id' =>
                null,

            'title' =>
                $validated['title'],

            'description' =>
                $validated['description'] ?? null,

            'price' =>
                $validated['price'],

            'delivery_days' =>
                $validated['delivery_days'],

            'revision_count' =>
                $validated['revision_count'],

            'status' =>
                'sent',

            'expires_at' =>
                $validated['expires_at'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Masukkan quotation ke timeline chat
        |--------------------------------------------------------------------------
        */

        Message::create([
            'conversation_id' =>
                $conversation->id,

            'sender_id' =>
                Auth::id(),

            'message' =>
                'Freelancer mengirim quotation baru: ' .
                $offer->title,

            'type' =>
                'offer',

            'is_read' =>
                false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update conversation
        |--------------------------------------------------------------------------
        */

        $conversation->update([
            'last_message_at' =>
                now(),
        ]);

        return redirect()
            ->route(
                'freelancer.messages.show',
                $conversation
            )
            ->with(
                'success',
                'Quotation berhasil dikirim kepada client.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | JOB BOARD
    |--------------------------------------------------------------------------
    */

    /**
     * Form membuat quotation Job Board.
     */
    public function createJob(
        Job $job,
        JobProposal $proposal
    ): View {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Proposal harus milik job
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $proposal->job_id === $job->id,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Proposal harus milik freelancer login
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $proposal->freelancer_profile_id ===
                $freelancerProfile->id,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Status proposal
        |--------------------------------------------------------------------------
        */

        abort_unless(
            in_array(
                $proposal->status,
                ['pending', 'accepted'],
                true
            ),
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Status job
        |--------------------------------------------------------------------------
        */

        abort_unless(
            in_array(
                $job->status,
                ['open', 'in_review'],
                true
            ),
            404
        );

        $proposal->load([
            'job.category',
            'job.subcategory',
            'selectedExperience',
            'portfolios',
            'freelancerProfile.user',
        ]);

        return view(
            'freelancer.offers.create',
            compact(
                'job',
                'proposal'
            )
        );
    }

    /**
     * Simpan quotation Job Board.
     */
    public function storeJob(
        Request $request,
        Job $job,
        JobProposal $proposal
    ): RedirectResponse {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Proposal harus milik job
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $proposal->job_id === $job->id,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Proposal harus milik freelancer login
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $proposal->freelancer_profile_id ===
                $freelancerProfile->id,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Status proposal
        |--------------------------------------------------------------------------
        */

        abort_unless(
            in_array(
                $proposal->status,
                ['pending', 'accepted'],
                true
            ),
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Status job
        |--------------------------------------------------------------------------
        */

        abort_unless(
            in_array(
                $job->status,
                ['open', 'in_review'],
                true
            ),
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:10000',
            ],

            'price' => [
                'required',
                'numeric',
                'min:1',
            ],

            'delivery_days' => [
                'required',
                'integer',
                'min:1',
                'max:365',
            ],

            'revision_count' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:now',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Cari conversation utama
        |--------------------------------------------------------------------------
        */

        $conversation = Conversation::query()
            ->where(
                'client_id',
                $job->client_id
            )
            ->where(
                'freelancer_profile_id',
                $freelancerProfile->id
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Buat conversation jika belum ada
        |--------------------------------------------------------------------------
        */

        if (! $conversation) {

            $conversation = Conversation::create([
                'client_id' =>
                    $job->client_id,

                'freelancer_profile_id' =>
                    $freelancerProfile->id,

                'service_id' =>
                    null,

                'job_id' =>
                    $job->id,

                'job_proposal_id' =>
                    $proposal->id,

                'status' =>
                    'active',

                'last_message_at' =>
                    now(),
            ]);

        } else {

            $conversation->update([
                'job_id' =>
                    $job->id,

                'job_proposal_id' =>
                    $proposal->id,

                'last_message_at' =>
                    now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek quotation aktif
        |--------------------------------------------------------------------------
        */

        $hasActiveOffer = Offer::query()
            ->where(
                'conversation_id',
                $conversation->id
            )
            ->whereIn(
                'status',
                ['sent', 'accepted']
            )
            ->where(function ($query) {
                $query
                    ->whereNull('expires_at')
                    ->orWhere(
                        'expires_at',
                        '>',
                        now()
                    );
            })
            ->exists();

        if ($hasActiveOffer) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Masih ada quotation aktif pada percakapan ini.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Buat quotation Job Board
        |--------------------------------------------------------------------------
        */

        $offer = Offer::create([
            'conversation_id' =>
                $conversation->id,

            'client_id' =>
                $job->client_id,

            'freelancer_profile_id' =>
                $freelancerProfile->id,

            'service_id' =>
                null,

            'job_id' =>
                $job->id,

            'job_proposal_id' =>
                $proposal->id,

            'title' =>
                $validated['title'],

            'description' =>
                $validated['description'] ?? null,

            'price' =>
                $validated['price'],

            'delivery_days' =>
                $validated['delivery_days'],

            'revision_count' =>
                $validated['revision_count'],

            'status' =>
                'sent',

            'expires_at' =>
                $validated['expires_at'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Message quotation
        |--------------------------------------------------------------------------
        */

        Message::create([
            'conversation_id' =>
                $conversation->id,

            'sender_id' =>
                Auth::id(),

            'message' =>
                'Freelancer mengirim quotation baru: ' .
                $offer->title,

            'type' =>
                'offer',

            'is_read' =>
                false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update conversation
        |--------------------------------------------------------------------------
        */

        $conversation->update([
            'last_message_at' =>
                now(),
        ]);

        return redirect()
            ->route(
                'freelancer.messages.show',
                $conversation
            )
            ->with(
                'success',
                'Quotation berhasil dikirim kepada client.'
            );
    }
}