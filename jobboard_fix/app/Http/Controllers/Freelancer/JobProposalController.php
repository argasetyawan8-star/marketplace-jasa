<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobProposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobProposalController extends Controller
{
    public function store(Request $request, Job $job): RedirectResponse
    {
        abort_unless($job->status === 'open', 404);

        $freelancerProfile = auth()->user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $validated = $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'delivery_days' => ['required', 'integer', 'min:1', 'max:3650'],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
        ]);

        $alreadyExists = JobProposal::query()
            ->where('job_id', $job->id)
            ->where('freelancer_profile_id', $freelancerProfile->id)
            ->exists();

        if ($alreadyExists) {
            return back()->with('error', 'Kamu sudah mengirim proposal untuk job ini.');
        }

        JobProposal::create([
            'job_id' => $job->id,
            'freelancer_profile_id' => $freelancerProfile->id,
            'price' => $validated['price'],
            'delivery_days' => $validated['delivery_days'],
            'message' => $validated['message'],
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Proposal berhasil dikirim ke client.');
    }
}
