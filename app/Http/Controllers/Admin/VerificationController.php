<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreelancerVerification;
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