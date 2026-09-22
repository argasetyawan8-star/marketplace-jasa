<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreelancerVerification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class VerificationController extends Controller
{
    /**
     * Menampilkan seluruh pengajuan verifikasi freelancer.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $allowedStatuses = [
            'pending',
            'verified',
            'rejected',
        ];

        $verifications = FreelancerVerification::query()
            ->with([
                'freelancerProfile.user',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'full_name',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhereHas(
                            'freelancerProfile.user',
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
            'all' => FreelancerVerification::count(),

            'pending' => FreelancerVerification::where(
                'status',
                'pending'
            )->count(),

            'verified' => FreelancerVerification::where(
                'status',
                'verified'
            )->count(),

            'rejected' => FreelancerVerification::where(
                'status',
                'rejected'
            )->count(),
        ];

        return view(
            'admin.verifications.index',
            compact(
                'verifications',
                'search',
                'status',
                'counts'
            )
        );
    }

    /**
     * Menampilkan detail pengajuan verifikasi.
     */
    public function show(
        FreelancerVerification $verification
    ) {
        $verification->load([
            'freelancerProfile.user',
            'reviewer',
        ]);

        /**
         * ----------------------------------------------------------------------
         * NOTIFICATION: KYC REVIEWING
         * ----------------------------------------------------------------------
         *
         * Status database tetap "pending".
         *
         * Ketika Admin pertama kali membuka pengajuan yang masih pending,
         * Freelancer diberi tahu bahwa pengajuannya sedang diperiksa.
         *
         * Dedupe memastikan notifikasi reviewing tidak dikirim berulang
         * setiap kali halaman dibuka.
         */
        $freelancer = $verification->freelancerProfile?->user;

        if (
            $freelancer &&
            $verification->status === 'pending'
        ) {
            app(NotificationService::class)->send(
                recipient: $freelancer,
                event: NotificationService::KYC_REVIEWING,
                title: 'Verifikasi KYC sedang diperiksa',
                message:
                    'Pengajuan verifikasi KYC kamu sedang diperiksa oleh Admin. Tunggu hasil pemeriksaannya.',
                actionUrl: route(
                    'freelancer.verification.index'
                ),
                priority: 'info',
                actor: Auth::user(),
                relatedType: 'freelancer_verification',
                relatedId: $verification->id,
                extra: [
                    'verification_id' =>
                        $verification->id,

                    'freelancer_profile_id' =>
                        $verification->freelancer_profile_id,

                    'status' =>
                        $verification->status,

                    'reviewed_by' =>
                        Auth::id(),
                ],
                dedupeKey:
                    'kyc_reviewing:freelancer:' .
                    $freelancer->id .
                    ':' .
                    $verification->id
            );
        }

        return view(
            'admin.verifications.show',
            compact('verification')
        );
    }

    /**
     * Menampilkan dokumen identitas secara private.
     */
    public function document(
        FreelancerVerification $verification
    ) {
        abort_unless(
            $verification->identity_document_path,
            404
        );

        $disk = Storage::disk('local');

        abort_unless(
            $disk->exists(
                $verification->identity_document_path
            ),
            404
        );

        $path = $disk->path(
            $verification->identity_document_path
        );

        return response()->file($path, [
            'Cache-Control' => 'private, no-store',
            'Pragma' => 'no-cache',
        ]);
    }

    /**
     * Menyetujui verifikasi freelancer.
     */
    public function approve(
        FreelancerVerification $verification
    ) {
        DB::transaction(function () use (
            $verification
        ) {
            $lockedVerification =
                FreelancerVerification::query()
                    ->whereKey($verification->id)
                    ->lockForUpdate()
                    ->firstOrFail();

            if (
                $lockedVerification->status === 'verified'
            ) {
                return;
            }

            if (
                $lockedVerification->status !== 'pending'
            ) {
                throw ValidationException::withMessages([
                    'status' =>
                        'Pengajuan verifikasi ini sudah diproses sebelumnya.',
                ]);
            }

            $freelancerProfile =
                $lockedVerification
                    ->freelancerProfile()
                    ->lockForUpdate()
                    ->firstOrFail();

            $lockedVerification->update([
                'status' => 'verified',

                'rejection_reason' => null,

                'reviewed_at' => now(),

                'reviewed_by' => Auth::id(),
            ]);

            $freelancerProfile->update([
                'is_verified' => true,
            ]);
        });

        /**
         * ----------------------------------------------------------------------
         * NOTIFICATION: KYC APPROVED
         * ----------------------------------------------------------------------
         *
         * Kirim setelah transaction berhasil commit.
         */
        $verification->loadMissing([
            'freelancerProfile.user',
        ]);

        $freelancer = $verification->freelancerProfile?->user;

        if ($freelancer) {
            app(NotificationService::class)->send(
                recipient: $freelancer,
                event: NotificationService::KYC_APPROVED,
                title: 'Verifikasi KYC berhasil',
                message:
                    'Pengajuan verifikasi KYC kamu telah disetujui. Akun freelancer kamu sekarang sudah terverifikasi.',
                actionUrl: route(
                    'freelancer.verification.index'
                ),
                priority: 'critical',
                actor: Auth::user(),
                relatedType: 'freelancer_verification',
                relatedId: $verification->id,
                extra: [
                    'verification_id' =>
                        $verification->id,

                    'freelancer_profile_id' =>
                        $verification->freelancer_profile_id,

                    'status' =>
                        'verified',

                    'reviewed_by' =>
                        Auth::id(),

                    'reviewed_at' =>
                        $verification->reviewed_at?->toISOString(),
                ],
                dedupeKey:
                    'kyc_approved:freelancer:' .
                    $freelancer->id .
                    ':' .
                    $verification->id
            );
        }

        return redirect()
            ->route(
                'admin.verifications.show',
                $verification
            )
            ->with(
                'success',
                'Freelancer berhasil diverifikasi.'
            );
    }

    /**
     * Menolak pengajuan verifikasi freelancer.
     */
    public function reject(
        Request $request,
        FreelancerVerification $verification
    ) {
        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $verification
        ) {
            $lockedVerification =
                FreelancerVerification::query()
                    ->whereKey($verification->id)
                    ->lockForUpdate()
                    ->firstOrFail();

            if (
                $lockedVerification->status !== 'pending'
            ) {
                throw ValidationException::withMessages([
                    'status' =>
                        'Pengajuan verifikasi ini sudah diproses sebelumnya.',
                ]);
            }

            $freelancerProfile =
                $lockedVerification
                    ->freelancerProfile()
                    ->lockForUpdate()
                    ->firstOrFail();

            $lockedVerification->update([
                'status' => 'rejected',

                'rejection_reason' =>
                    $validated['rejection_reason'],

                'reviewed_at' => now(),

                'reviewed_by' => Auth::id(),
            ]);

            $freelancerProfile->update([
                'is_verified' => false,
            ]);
        });

        /**
         * ----------------------------------------------------------------------
         * NOTIFICATION: KYC REJECTED
         * ----------------------------------------------------------------------
         *
         * Kirim setelah transaction berhasil commit.
         */
        $verification->loadMissing([
            'freelancerProfile.user',
        ]);

        $freelancer = $verification->freelancerProfile?->user;

        if ($freelancer) {
            app(NotificationService::class)->send(
                recipient: $freelancer,
                event: NotificationService::KYC_REJECTED,
                title: 'Verifikasi KYC ditolak',
                message:
                    'Pengajuan verifikasi KYC kamu ditolak oleh Admin.',

                actionUrl: route(
                    'freelancer.verification.index'
                ),

                priority: 'action',

                actor: Auth::user(),

                relatedType: 'freelancer_verification',

                relatedId: $verification->id,

                extra: [
                    'verification_id' =>
                        $verification->id,

                    'freelancer_profile_id' =>
                        $verification->freelancer_profile_id,

                    'status' =>
                        'rejected',

                    'rejection_reason' =>
                        $verification->rejection_reason,

                    'reviewed_by' =>
                        Auth::id(),

                    'reviewed_at' =>
                        $verification->reviewed_at?->toISOString(),
                ],

                dedupeKey:
                    'kyc_rejected:freelancer:' .
                    $freelancer->id .
                    ':' .
                    $verification->id
            );
        }

        return redirect()
            ->route(
                'admin.verifications.show',
                $verification
            )
            ->with(
                'success',
                'Pengajuan verifikasi berhasil ditolak.'
            );
    }
}
