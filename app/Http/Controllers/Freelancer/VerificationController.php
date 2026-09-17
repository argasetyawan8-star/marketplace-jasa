<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    /**
     * Menampilkan halaman verifikasi freelancer.
     */
    public function index()
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $verification = FreelancerVerification::where(
            'freelancer_profile_id',
            $freelancerProfile->id
        )->first();

        return view(
            'freelancer.verification.index',
            compact(
                'freelancerProfile',
                'verification'
            )
        );
    }

    /**
     * Menyimpan pengajuan verifikasi.
     */
    public function store(Request $request)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $verification = FreelancerVerification::where(
            'freelancer_profile_id',
            $freelancerProfile->id
        )->first();

        /*
         * Freelancer yang sudah verified tidak perlu
         * melakukan pengajuan ulang.
         */
        if ($verification?->status === 'verified') {
            return back()->with(
                'info',
                'Akun freelancer kamu sudah terverifikasi.'
            );
        }

        /*
         * Pengajuan yang sedang direview tidak bisa
         * dikirim ulang sampai Admin selesai memprosesnya.
         */
        if ($verification?->status === 'pending') {
            return back()->with(
                'info',
                'Pengajuan verifikasi kamu masih sedang ditinjau Admin.'
            );
        }

        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'identity_type' => [
                'required',
                'in:KTP',
            ],

            'identity_number' => [
                'required',
                'string',
                'min:8',
                'max:30',
            ],

            'identity_document' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:4096',
            ],

            'bank_name' => [
                'required',
                'string',
                'max:100',
            ],

            'bank_account_name' => [
                'required',
                'string',
                'max:255',
            ],

            'bank_account_number' => [
                'required',
                'string',
                'min:5',
                'max:50',
            ],
        ]);

        $oldDocumentPath = $verification?->identity_document_path;
        $newDocumentPath = null;

        try {
            /*
             * Simpan dokumen ke local/private storage.
             *
             * File tidak disimpan di storage/app/public,
             * sehingga tidak dapat diakses langsung melalui URL publik.
             */
            $newDocumentPath = $request
                ->file('identity_document')
                ->storeAs(
                    'verifications/' . $freelancerProfile->id,
                    Str::uuid() .
                        '.' .
                        $request
                            ->file('identity_document')
                            ->getClientOriginalExtension(),
                    'local'
                );

            DB::transaction(function () use (
                $freelancerProfile,
                $validated,
                $verification,
                $newDocumentPath
            ) {
                $data = [
                    'freelancer_profile_id' =>
                        $freelancerProfile->id,

                    'full_name' =>
                        $validated['full_name'],

                    'identity_type' =>
                        $validated['identity_type'],

                    'identity_number' =>
                        $validated['identity_number'],

                    'identity_document_path' =>
                        $newDocumentPath,

                    'bank_name' =>
                        $validated['bank_name'],

                    'bank_account_name' =>
                        $validated['bank_account_name'],

                    'bank_account_number' =>
                        $validated['bank_account_number'],

                    'status' => 'pending',

                    'rejection_reason' => null,

                    'submitted_at' => now(),

                    'reviewed_at' => null,

                    'reviewed_by' => null,
                ];

                if ($verification) {
                    $verification->update($data);
                } else {
                    FreelancerVerification::create($data);
                }

                /*
                 * Set kembali menjadi belum verified
                 * selama menunggu review Admin.
                 */
                $freelancerProfile->update([
                    'is_verified' => false,
                ]);
            });

            /*
             * Hapus dokumen lama setelah data baru berhasil
             * tersimpan ke database.
             */
            if (
                $oldDocumentPath &&
                $oldDocumentPath !== $newDocumentPath
            ) {
                Storage::disk('local')->delete(
                    $oldDocumentPath
                );
            }

            return redirect()
                ->route('freelancer.verification.index')
                ->with(
                    'success',
                    'Dokumen verifikasi berhasil dikirim dan sedang menunggu pemeriksaan Admin.'
                );
        } catch (\Throwable $e) {
            /*
             * Kalau database gagal, file baru yang sudah
             * tersimpan ikut dibersihkan.
             */
            if ($newDocumentPath) {
                Storage::disk('local')->delete(
                    $newDocumentPath
                );
            }

            throw $e;
        }
    }
}