<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use App\Services\NotificationService;
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

        /*
         * Notifikasi ke seluruh Admin.
         * Dikirim setelah transaksi database berhasil agar
         * notifikasi tidak mengganggu proses submit service.
         */
        $admins = User::query()
            ->where('role', 'admin')
            ->get();

        foreach ($admins as $admin) {
            NotificationService::send(
                recipient: $admin,
                event: NotificationService::SERVICE_SUBMITTED,
                title: 'Service baru perlu diperiksa',
                message: 'Freelancer mengajukan jasa baru untuk diperiksa dan dimoderasi.',
                actionUrl: null,
                priority: NotificationService::PRIORITY_ACTION,
                actor: Auth::user(),
                relatedType: 'service',
                relatedId: $service->id,
                extra: [
                    'service_id' => $service->id,
                    'freelancer_profile_id' => $freelancerProfile->id,
                    'status' => $service->status,
                ],
                dedupeKey: 'service_submitted:admin:' . $admin->id . ':' . $service->id,
            );
        }

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
