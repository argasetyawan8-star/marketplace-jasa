<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ServiceModerationController extends Controller
{
    /**
     * Freelancer mengajukan service untuk diperiksa Admin.
     */
    public function submitReview(Service $service)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        abort_unless(
            $service->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        if ($service->status === 'published') {
            return back()->with(
                'info',
                'Jasa ini sudah dipublikasikan di marketplace.'
            );
        }

        if ($service->status === 'pending') {
            return back()->with(
                'info',
                'Jasa ini sedang menunggu pemeriksaan Admin.'
            );
        }

        if (! in_array(
            $service->status,
            ['draft', 'rejected'],
            true
        )) {
            throw ValidationException::withMessages([
                'status' =>
                    'Jasa dengan status saat ini tidak dapat diajukan untuk review.',
            ]);
        }

        DB::transaction(function () use ($service) {
            $service->update([
                'status' => 'pending',
                'rejection_reason' => null,
                'submitted_at' => now(),
                'reviewed_at' => null,
                'reviewed_by' => null,
            ]);
        });

        return redirect()
            ->route(
                'freelancer.services.show',
                $service
            )
            ->with(
                'success',
                'Jasa berhasil diajukan untuk diperiksa Admin.'
            );
    }
}