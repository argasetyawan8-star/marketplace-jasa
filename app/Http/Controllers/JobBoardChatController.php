<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\FreelancerProfile;
use App\Models\Job;
use App\Models\JobProposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobBoardChatController extends Controller
{
    public function start(
        Request $request,
        Job $job,
        JobProposal $proposal
    ): RedirectResponse {
        $user = $request->user();

        abort_unless(
            $proposal->job_id === $job->id,
            404
        );

        $freelancerProfile = FreelancerProfile::query()
            ->findOrFail(
                $proposal->freelancer_profile_id
            );

        /*
         * CLIENT
         */
        if ($user->role === 'client') {
    /*
     * Client yang login boleh menghubungi
     * freelancer yang mengajukan proposal.
     */
    // Tidak perlu membatasi client_id berdasarkan pemilik Job.
}

        /*
         * FREELANCER
         */
        elseif ($user->role === 'freelancer') {
            $profile = FreelancerProfile::query()
                ->where('user_id', $user->id)
                ->firstOrFail();

            abort_unless(
                $profile->id === $freelancerProfile->id,
                403
            );
        }

        else {
            abort(403);
        }

        /*
         * Cari conversation lama berdasarkan
         * Client + Freelancer.
         *
         * service_id sengaja tidak digunakan.
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
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->first();

        /*
         * Kalau belum pernah chat,
         * buat conversation baru.
         */
        if (!$conversation) {
            $conversation = Conversation::create([
                'client_id' => $job->client_id,
                'freelancer_profile_id' =>
                    $freelancerProfile->id,
                'service_id' => null,
                'job_id' => $job->id,
                'job_proposal_id' => $proposal->id,
                'status' => 'active',
                'last_message_at' => now(),
            ]);
        } else {
            /*
             * Conversation lama dipakai kembali.
             * Kita hanya memperbarui konteks Job Board.
             */
            $conversation->update([
                'job_id' => $job->id,
                'job_proposal_id' => $proposal->id,
            ]);
        }

        /*
         * Arahkan ke halaman Message utama JASAIN.
         */
        if ($user->role === 'freelancer') {
            return redirect()->route(
                'freelancer.messages.show',
                $conversation
            );
        }

        return redirect()->route(
            'client.messages.show',
            $conversation
        );
    }
}