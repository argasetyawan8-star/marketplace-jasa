<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerProfile;
use App\Models\Job;
use App\Models\JobProposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JobProposalController extends Controller
{
    public function store(Request $request, Job $job): RedirectResponse
    {
        abort_unless(
            $job->status === 'open',
            404
        );

        $user = $request->user();

        abort_unless(
            $user->role === 'freelancer',
            403
        );

        $profile = FreelancerProfile::query()
            ->where('user_id', $user->id)
            ->firstOrFail();

        $existingProposal = JobProposal::query()
            ->where('job_id', $job->id)
            ->where('freelancer_profile_id', $profile->id)
            ->exists();

        if ($existingProposal) {
            return back()->with(
                'error',
                'Kamu sudah mengirim tawaran untuk pekerjaan ini.'
            );
        }

        $validated = $request->validate([
            'display_name' => [
                'required',
                'string',
                'max:100',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'relevant_info' => [
                'required',
                'string',
                'min:100',
                'max:5000',
            ],

            'portfolio_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'selected_experience_id' => [
                'nullable',
                'integer',
                'exists:freelancer_experiences,id',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'delivery_days' => [
                'required',
                'integer',
                'min:1',
            ],

            'portfolios' => [
                'nullable',
                'array',
                'max:10',
            ],

            'portfolios.*' => [
                'file',
                'max:25600',
                'mimes:jpg,jpeg,png,webp,pdf,doc,docx',
            ],
        ], [
            'relevant_info.min' =>
                'Informasi yang relevan minimal 100 karakter.',

            'portfolios.max' =>
                'Maksimal 10 file portofolio.',

            'portfolios.*.max' =>
                'Setiap file portofolio maksimal 25 MB.',
        ]);

        if (!empty($validated['selected_experience_id'])) {
            $experienceBelongsToFreelancer = $profile->experiences()
                ->whereKey($validated['selected_experience_id'])
                ->exists();

            if (!$experienceBelongsToFreelancer) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'selected_experience_id' =>
                            'Pengalaman yang dipilih tidak valid.',
                    ]);
            }
        }

        DB::beginTransaction();

        try {
            $proposal = JobProposal::create([
                'job_id' => $job->id,
                'freelancer_profile_id' => $profile->id,
                'display_name' => $validated['display_name'],
                'phone' => $validated['phone'],
                'message' => $validated['relevant_info'],
                'relevant_info' => $validated['relevant_info'],
                'portfolio_url' => $validated['portfolio_url'] ?? null,
                'selected_experience_id' =>
                    $validated['selected_experience_id'] ?? null,
                'price' => $validated['price'],
                'delivery_days' => $validated['delivery_days'],
                'status' => 'pending',
            ]);

            if ($request->hasFile('portfolios')) {
                foreach ($request->file('portfolios') as $file) {
                    $path = $file->store(
                        'job-proposals/' . $proposal->id,
                        'public'
                    );

                    $proposal->portfolios()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('freelancer.jobs.show', $job)
                ->with(
                    'success',
                    'Tawaran pekerjaan berhasil dikirim ke client.'
                );
        } catch (\Throwable $e) {
    DB::rollBack();

    return back()
        ->withInput()
        ->with(
            'error',
            'ERROR: ' . $e->getMessage()
        );
}
    }
}