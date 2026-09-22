<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ServiceModerationController extends Controller
{
    /**
     * Daftar service yang perlu dimoderasi.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $status = $request->input('status', 'pending');

        $allowedStatuses = [
            'draft',
            'pending',
            'published',
            'rejected',
            'archived',
        ];

        $services = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
                'subcategory',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'title',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhereHas(
                            'freelancerProfile',
                            function ($profileQuery) use ($search) {
                                $profileQuery->where(
                                    'username',
                                    'like',
                                    '%' . $search . '%'
                                )->orWhereHas(
                                    'user',
                                    function ($userQuery) use ($search) {
                                        $userQuery
                                            ->where(
                                                'name',
                                                'like',
                                                '%' . $search . '%'
                                            )
                                            ->orWhere(
                                                'email',
                                                'like',
                                                '%' . $search . '%'
                                            );
                                    }
                                );
                            }
                        )
                        ->orWhereHas(
                            'category',
                            function ($categoryQuery) use ($search) {
                                $categoryQuery->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                );
                            }
                        );
                });
            })
            ->when(
                in_array($status, $allowedStatuses, true),
                fn ($query) => $query->where(
                    'status',
                    $status
                )
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'all' => Service::count(),

            'pending' => Service::where(
                'status',
                'pending'
            )->count(),

            'published' => Service::where(
                'status',
                'published'
            )->count(),

            'rejected' => Service::where(
                'status',
                'rejected'
            )->count(),

            'draft' => Service::where(
                'status',
                'draft'
            )->count(),
        ];

        return view(
            'admin.service-moderation.index',
            compact(
                'services',
                'search',
                'status',
                'counts'
            )
        );
    }

    /**
     * Detail service.
     */
    public function show(Service $service)
    {
        $service->load([
            'freelancerProfile.user',
            'category',
            'subcategory',
            'reviewer',
        ]);

        return view(
            'admin.service-moderation.show',
            compact('service')
        );
    }

    /**
     * Publish service.
     */
    public function publish(Service $service)
    {
        $reviewedAt = null;

        DB::transaction(function () use (
            $service,
            &$reviewedAt
        ) {
            $lockedService = Service::query()
                ->whereKey($service->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedService->status === 'published') {
                return;
            }

            if ($lockedService->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' =>
                        'Jasa hanya dapat dipublikasikan ketika berstatus pending.',
                ]);
            }

            $reviewedAt = now();

            $lockedService->update([
                'status' => 'published',
                'rejection_reason' => null,
                'reviewed_at' => $reviewedAt,
                'reviewed_by' => Auth::id(),
            ]);
        });

        /*
         * Notifikasi dikirim setelah transaksi database berhasil.
         */
        $service->load([
            'freelancerProfile.user',
            'category',
            'subcategory',
        ]);

        $freelancerUser = $service->freelancerProfile?->user;

        if ($freelancerUser) {
            NotificationService::send(
                recipient: $freelancerUser,
                event: NotificationService::SERVICE_APPROVED,
                title: 'Jasa berhasil disetujui',
                message: 'Jasa "' . $service->title . '" telah disetujui Admin dan sudah dipublikasikan di marketplace.',
                actionUrl: route(
                    'freelancer.services.show',
                    $service
                ),
                priority: NotificationService::PRIORITY_INFO,
                actor: Auth::user(),
                relatedType: 'service',
                relatedId: $service->id,
                extra: [
                    'service_id' => $service->id,
                    'status' => 'published',
                ],
                dedupeKey:
                    'service_approved:freelancer:' .
                    $freelancerUser->id .
                    ':' .
                    $service->id .
                    ':' .
                    ($reviewedAt?->timestamp ?? time()),
            );
        }

        return redirect()
            ->route(
                'admin.service-moderation.show',
                $service
            )
            ->with(
                'success',
                'Jasa berhasil dipublikasikan ke marketplace.'
            );
    }

    /**
     * Reject service.
     */
    public function reject(
        Request $request,
        Service $service
    ) {
        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ]);

        $reviewedAt = null;

        DB::transaction(function () use (
            $validated,
            $service,
            &$reviewedAt
        ) {
            $lockedService = Service::query()
                ->whereKey($service->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedService->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' =>
                        'Jasa hanya dapat ditolak ketika berstatus pending.',
                ]);
            }

            $reviewedAt = now();

            $lockedService->update([
                'status' => 'rejected',
                'rejection_reason' =>
                    $validated['rejection_reason'],
                'reviewed_at' => $reviewedAt,
                'reviewed_by' => Auth::id(),
            ]);
        });

        /*
         * Notifikasi dikirim setelah transaksi database berhasil.
         */
        $service->load([
            'freelancerProfile.user',
            'category',
            'subcategory',
        ]);

        $freelancerUser = $service->freelancerProfile?->user;

        if ($freelancerUser) {
            NotificationService::send(
                recipient: $freelancerUser,
                event: NotificationService::SERVICE_REJECTED,
                title: 'Jasa belum disetujui',
                message:
                    'Jasa "' .
                    $service->title .
                    '" ditolak oleh Admin. Alasan: ' .
                    $validated['rejection_reason'],
                actionUrl: route(
                    'freelancer.services.show',
                    $service
                ),
                priority: NotificationService::PRIORITY_ACTION,
                actor: Auth::user(),
                relatedType: 'service',
                relatedId: $service->id,
                extra: [
                    'service_id' => $service->id,
                    'status' => 'rejected',
                    'rejection_reason' =>
                        $validated['rejection_reason'],
                ],
                dedupeKey:
                    'service_rejected:freelancer:' .
                    $freelancerUser->id .
                    ':' .
                    $service->id .
                    ':' .
                    ($reviewedAt?->timestamp ?? time()),
            );
        }

        return redirect()
            ->route(
                'admin.service-moderation.show',
                $service
            )
            ->with(
                'success',
                'Jasa berhasil ditolak dan alasan sudah dikirim ke Freelancer.'
            );
    }
}
