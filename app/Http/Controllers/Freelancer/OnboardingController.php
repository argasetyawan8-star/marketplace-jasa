<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerVerification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OnboardingController extends Controller
{
    /**
     * Tampilkan halaman onboarding freelancer.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Role Guard
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'freelancer') {
            return redirect()->route('freelancer.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Existing Freelancer Profile
        |--------------------------------------------------------------------------
        */

        $freelancerProfile = $user->freelancerProfile;

        /*
        |--------------------------------------------------------------------------
        | Existing Verification
        |--------------------------------------------------------------------------
        */

        $verification = null;

        if ($freelancerProfile) {
            $verification = FreelancerVerification::query()
                ->where(
                    'freelancer_profile_id',
                    $freelancerProfile->id
                )
                ->latest('id')
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Session Data
        |--------------------------------------------------------------------------
        */

        $onboarding = session(
            'prokerja_freelancer_onboarding',
            []
        );

        /*
        |--------------------------------------------------------------------------
        | DATABASE IS SOURCE OF TRUTH
        |--------------------------------------------------------------------------
        */

        $status = $verification?->status;

        if (!$verification) {
            session()->forget(
                'prokerja_freelancer_status'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Current Step
        |--------------------------------------------------------------------------
        */

        $savedStep = (int) session(
            'prokerja_freelancer_onboarding_step',
            1
        );

        $requestedStep = (int) $request->query(
            'step',
            $savedStep
        );

        $step = max(
            1,
            min($requestedStep, 5)
        );

        /*
        |--------------------------------------------------------------------------
        | Pending = Step 5 + Locked
        |--------------------------------------------------------------------------
        */

        if ($status === 'pending') {
            $step = 5;
        }

        /*
        |--------------------------------------------------------------------------
        | Rejected
        |--------------------------------------------------------------------------
        |
        | Setelah ditolak, user tetap boleh memperbaiki
        | data onboarding dan mengirim ulang.
        |
        */

        if ($status === 'rejected') {
            $step = max(
                1,
                min($step, 5)
            );
        }

        return view(
            'freelancer.onboarding',
            compact(
                'onboarding',
                'status',
                'step',
                'verification',
                'freelancerProfile'
            )
        );
    }

    /**
     * Simpan setiap langkah onboarding.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Role Guard
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'freelancer') {
            return redirect()->route('freelancer.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Determine Current Step
        |--------------------------------------------------------------------------
        */

        $step = (int) $request->input(
            'step',
            1
        );

        if ($step < 1 || $step > 5) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Existing Profile
        |--------------------------------------------------------------------------
        */

        $freelancerProfile = $user->freelancerProfile;

        /*
        |--------------------------------------------------------------------------
        | Existing Verification
        |--------------------------------------------------------------------------
        */

        $existingVerification = null;

        if ($freelancerProfile) {
            $existingVerification = FreelancerVerification::query()
                ->where(
                    'freelancer_profile_id',
                    $freelancerProfile->id
                )
                ->latest('id')
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        |
        | Jika status DB pending, user tidak boleh mengubah
        | data onboarding sampai Admin selesai melakukan review.
        |
        */

        if ($existingVerification?->status === 'pending') {
            return redirect()
                ->route('freelancer.onboarding')
                ->with(
                    'status',
                    'pending'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Existing Session Data
        |--------------------------------------------------------------------------
        */

        $onboarding = session(
            'prokerja_freelancer_onboarding',
            []
        );

        /*
        |--------------------------------------------------------------------------
        | STEP 1 - PROFIL FREELANCER
        |--------------------------------------------------------------------------
        */

        if ($step === 1) {
            $data = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],

                'username' => [
                    'required',
                    'string',
                    'max:100',

                    Rule::unique(
                        'freelancer_profiles',
                        'username'
                    )->ignore(
                        $freelancerProfile?->id
                    ),
                ],

                'headline' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'location' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Freelancer Profile if needed
            |--------------------------------------------------------------------------
            */

            if (!$freelancerProfile) {
                $freelancerProfile = $user
                    ->freelancerProfile()
                    ->make();

                $freelancerProfile->user_id = $user->id;
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan Profile
            |--------------------------------------------------------------------------
            */

            $freelancerProfile->username =
                $data['username'];

            $freelancerProfile->headline =
                $data['headline'];

            $freelancerProfile->location =
                $data['location'];

            /*
            |--------------------------------------------------------------------------
            | Belum diverifikasi sampai Admin approve
            |--------------------------------------------------------------------------
            */

            $freelancerProfile->is_verified = false;

            $freelancerProfile->save();

            /*
            |--------------------------------------------------------------------------
            | Simpan User Name
            |--------------------------------------------------------------------------
            */

            $user->name = $data['name'];
            $user->save();

            /*
            |--------------------------------------------------------------------------
            | Session
            |--------------------------------------------------------------------------
            */

            $onboarding = array_merge(
                $onboarding,
                $data
            );

            session([
                'prokerja_freelancer_onboarding' =>
                    $onboarding,

                'prokerja_freelancer_onboarding_step' =>
                    2,

                'prokerja_freelancer_status' =>
                    null,
            ]);

            return redirect()->route(
                'freelancer.onboarding',
                [
                    'step' => 2,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 2 - IDENTITAS
        |--------------------------------------------------------------------------
        */

        if ($step === 2) {
            $rules = [
                'identity_type' => [
                    'required',
                    Rule::in([
                        'KTP',
                    ]),
                ],

                'identity_number' => [
                    'required',
                    'string',
                    'min:8',
                    'max:30',
                ],
            ];

            /*
            |--------------------------------------------------------------------------
            | KTP wajib jika belum pernah upload
            |--------------------------------------------------------------------------
            */

            $hasExistingDocument = filled(
                data_get(
                    $onboarding,
                    'identity_document'
                )
            );

            if (!$hasExistingDocument) {
                $rules['identity_document'] = [
                    'required',
                    'file',
                    'mimes:jpg,jpeg,png',
                    'max:4096',
                ];
            } else {
                $rules['identity_document'] = [
                    'nullable',
                    'file',
                    'mimes:jpg,jpeg,png',
                    'max:4096',
                ];
            }

            $data = $request->validate(
                $rules
            );

            /*
            |--------------------------------------------------------------------------
            | Profile harus tersedia
            |--------------------------------------------------------------------------
            */

            if (!$freelancerProfile) {
                $freelancerProfile = $user
                    ->freelancerProfile()
                    ->make();

                $freelancerProfile->user_id =
                    $user->id;

                $freelancerProfile->is_verified =
                    false;

                $freelancerProfile->save();
            }

            /*
            |--------------------------------------------------------------------------
            | Merge Identity Data
            |--------------------------------------------------------------------------
            */

            $onboarding = array_merge(
                $onboarding,
                [
                    'identity_type' =>
                        $data['identity_type'],

                    'identity_number' =>
                        $data['identity_number'],
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Upload KTP
            |--------------------------------------------------------------------------
            |
            | PUBLIC:
            | freelancer/onboarding/*
            |
            | PRIVATE:
            | verifications/{profile_id}/*
            |
            */

            if (
                $request->hasFile(
                    'identity_document'
                )
            ) {
                $file = $request->file(
                    'identity_document'
                );

                $filename =
                    (string) Str::uuid()
                    . '.'
                    . $file->extension();

                $publicPath = null;
                $privatePath = null;

                try {
                    $publicPath = $file->storeAs(
                        'freelancer/onboarding',
                        $filename,
                        'public'
                    );

                    $privatePath = $file->storeAs(
                        'verifications/' .
                            $freelancerProfile->id,
                        $filename,
                        'local'
                    );
                } catch (\Throwable $e) {
                    if ($publicPath) {
                        Storage::disk('public')
                            ->delete(
                                $publicPath
                            );
                    }

                    if ($privatePath) {
                        Storage::disk('local')
                            ->delete(
                                $privatePath
                            );
                    }

                    throw $e;
                }

                /*
                |--------------------------------------------------------------------------
                | Delete Previous Document
                |--------------------------------------------------------------------------
                */

                $oldPublicPath = data_get(
                    $onboarding,
                    'identity_document'
                );

                $oldPrivatePath = data_get(
                    $onboarding,
                    'identity_document_private'
                );

                if (
                    $oldPublicPath &&
                    $oldPublicPath !== $publicPath
                ) {
                    Storage::disk('public')
                        ->delete(
                            $oldPublicPath
                        );
                }

                if (
                    $oldPrivatePath &&
                    $oldPrivatePath !== $privatePath
                ) {
                    Storage::disk('local')
                        ->delete(
                            $oldPrivatePath
                        );
                }

                /*
                |--------------------------------------------------------------------------
                | Save Document Paths
                |--------------------------------------------------------------------------
                */

                $onboarding['identity_document'] =
                    $publicPath;

                $onboarding['identity_document_private'] =
                    $privatePath;
            }

            session([
                'prokerja_freelancer_onboarding' =>
                    $onboarding,

                'prokerja_freelancer_onboarding_step' =>
                    3,
            ]);

            return redirect()->route(
                'freelancer.onboarding',
                [
                    'step' => 3,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 3 - KONTAK
        |--------------------------------------------------------------------------
        */

        if ($step === 3) {
            $data = $request->validate([
                'phone' => [
                    'required',
                    'string',
                    'max:30',
                ],

                'city' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'address' => [
                    'required',
                    'string',
                    'max:1000',
                ],
            ]);

            /*
            |--------------------------------------------------------------------------
            | Nomor HP disimpan di User
            |--------------------------------------------------------------------------
            */

            $user->phone = $data['phone'];
            $user->save();

            $onboarding = array_merge(
                $onboarding,
                $data
            );

            session([
                'prokerja_freelancer_onboarding' =>
                    $onboarding,

                'prokerja_freelancer_onboarding_step' =>
                    4,
            ]);

            return redirect()->route(
                'freelancer.onboarding',
                [
                    'step' => 4,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 4 - REKENING BANK
        |--------------------------------------------------------------------------
        */

        if ($step === 4) {
            $data = $request->validate([
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

            $onboarding = array_merge(
                $onboarding,
                $data
            );

            session([
                'prokerja_freelancer_onboarding' =>
                    $onboarding,

                'prokerja_freelancer_onboarding_step' =>
                    5,
            ]);

            return redirect()->route(
                'freelancer.onboarding',
                [
                    'step' => 5,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 5 - PORTFOLIO + SUBMIT
        |--------------------------------------------------------------------------
        */

        if ($step === 5) {
            $data = $request->validate([
                'portfolio_url' => [
                    'required',
                    'url',
                    'max:500',
                ],

                'portfolio_description' => [
                    'required',
                    'string',
                    'max:3000',
                ],
            ]);

            $onboarding = array_merge(
                $onboarding,
                $data
            );

            /*
            |--------------------------------------------------------------------------
            | Ensure Profile
            |--------------------------------------------------------------------------
            */

            if (!$freelancerProfile) {
                $freelancerProfile = $user
                    ->freelancerProfile()
                    ->make();

                $freelancerProfile->user_id =
                    $user->id;

                $freelancerProfile->is_verified =
                    false;

                $freelancerProfile->save();
            }

            /*
            |--------------------------------------------------------------------------
            | Ensure all required onboarding data exists
            |--------------------------------------------------------------------------
            */

            $finalValidator = Validator::make(
                $onboarding,
                [
                    'name' => [
                        'required',
                        'string',
                        'min:3',
                        'max:255',
                    ],

                    'username' => [
                        'required',
                        'string',
                        'max:100',
                    ],

                    'headline' => [
                        'required',
                        'string',
                        'max:255',
                    ],

                    'location' => [
                        'required',
                        'string',
                        'max:255',
                    ],

                    'identity_type' => [
                        'required',
                        Rule::in([
                            'KTP',
                        ]),
                    ],

                    'identity_number' => [
                        'required',
                        'string',
                        'min:8',
                        'max:30',
                    ],

                    'identity_document' => [
                        'required',
                        'string',
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

                    'portfolio_url' => [
                        'required',
                        'url',
                        'max:500',
                    ],

                    'portfolio_description' => [
                        'required',
                        'string',
                        'max:3000',
                    ],
                ]
            );

            if ($finalValidator->fails()) {
                return redirect()
                    ->route(
                        'freelancer.onboarding',
                        [
                            'step' => 5,
                        ]
                    )
                    ->withErrors(
                        $finalValidator
                    )
                    ->withInput();
            }

            /*
            |--------------------------------------------------------------------------
            | PRIVATE KTP PATH
            |--------------------------------------------------------------------------
            */

            $privateDocumentPath = data_get(
                $onboarding,
                'identity_document_private'
            );

            $publicDocumentPath = data_get(
                $onboarding,
                'identity_document'
            );

            /*
            |--------------------------------------------------------------------------
            | Migrate old public document to private
            |--------------------------------------------------------------------------
            */

            if (
                !$privateDocumentPath &&
                $publicDocumentPath &&
                Storage::disk('public')
                    ->exists(
                        $publicDocumentPath
                    )
            ) {
                $filename = basename(
                    $publicDocumentPath
                );

                $privateDocumentPath =
                    'verifications/' .
                    $freelancerProfile->id .
                    '/' .
                    $filename;

                Storage::disk('local')->put(
                    $privateDocumentPath,
                    Storage::disk('public')->get(
                        $publicDocumentPath
                    )
                );

                $onboarding[
                    'identity_document_private'
                ] = $privateDocumentPath;
            }

            /*
            |--------------------------------------------------------------------------
            | KTP harus benar-benar tersedia
            |--------------------------------------------------------------------------
            */

            if (
                !$privateDocumentPath ||
                !Storage::disk('local')
                    ->exists(
                        $privateDocumentPath
                    )
            ) {
                return redirect()
                    ->route(
                        'freelancer.onboarding',
                        [
                            'step' => 2,
                        ]
                    )
                    ->withErrors([
                        'identity_document' =>
                            'Dokumen KTP belum tersedia. Silakan upload kembali KTP kamu.',
                    ])
                    ->withInput([
                        'identity_type' =>
                            data_get(
                                $onboarding,
                                'identity_type'
                            ),

                        'identity_number' =>
                            data_get(
                                $onboarding,
                                'identity_number'
                            ),
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | FINAL DATABASE SUBMISSION
            |--------------------------------------------------------------------------
            |
            | Data disimpan menjadi status "pending".
            |
            | Setelah transaction berhasil commit,
            | barulah notifikasi dikirim ke Admin.
            |
            */

            $verification = DB::transaction(
                function () use (
                    $user,
                    $freelancerProfile,
                    $onboarding,
                    $privateDocumentPath
                ) {
                    /*
                    |--------------------------------------------------------------------------
                    | Update Profile
                    |--------------------------------------------------------------------------
                    */

                    $freelancerProfile->username =
                        data_get(
                            $onboarding,
                            'username'
                        );

                    $freelancerProfile->headline =
                        data_get(
                            $onboarding,
                            'headline'
                        );

                    $freelancerProfile->location =
                        data_get(
                            $onboarding,
                            'location'
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Tetap false sampai Admin approve
                    |--------------------------------------------------------------------------
                    */

                    $freelancerProfile->is_verified =
                        false;

                    $freelancerProfile->save();

                    /*
                    |--------------------------------------------------------------------------
                    | Update User
                    |--------------------------------------------------------------------------
                    */

                    $user->name =
                        data_get(
                            $onboarding,
                            'name'
                        );

                    if (
                        data_get(
                            $onboarding,
                            'phone'
                        )
                    ) {
                        $user->phone =
                            data_get(
                                $onboarding,
                                'phone'
                            );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Role tetap client sampai Admin approve
                    |--------------------------------------------------------------------------
                    */

                    $user->save();

                    /*
                    |--------------------------------------------------------------------------
                    | Freelancer Verification
                    |--------------------------------------------------------------------------
                    */

                    $verification =
                        FreelancerVerification::firstOrNew([
                            'freelancer_profile_id' =>
                                $freelancerProfile->id,
                        ]);

                    $verification->full_name =
                        data_get(
                            $onboarding,
                            'name'
                        );

                    $verification->identity_type =
                        data_get(
                            $onboarding,
                            'identity_type'
                        );

                    $verification->identity_number =
                        data_get(
                            $onboarding,
                            'identity_number'
                        );

                    $verification->identity_document_path =
                        $privateDocumentPath;

                    $verification->bank_name =
                        data_get(
                            $onboarding,
                            'bank_name'
                        );

                    $verification->bank_account_name =
                        data_get(
                            $onboarding,
                            'bank_account_name'
                        );

                    $verification->bank_account_number =
                        data_get(
                            $onboarding,
                            'bank_account_number'
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Set Pending
                    |--------------------------------------------------------------------------
                    */

                    $verification->status =
                        'pending';

                    $verification->rejection_reason =
                        null;

                    $verification->submitted_at =
                        now();

                    $verification->reviewed_at =
                        null;

                    $verification->reviewed_by =
                        null;

                    $verification->save();

                    return $verification->fresh();
                }
            );

            /*
            |--------------------------------------------------------------------------
            | NOTIFICATION: KYC SUBMITTED
            |--------------------------------------------------------------------------
            |
            | Pengajuan baru dikirim ke seluruh Admin.
            |
            | Notifikasi baru dikirim SETELAH transaction
            | berhasil commit agar tidak ada notifikasi
            | untuk data yang gagal tersimpan.
            |
            */

            $admins = User::query()
                ->where(
                    'role',
                    'admin'
                )
                ->get();

            foreach ($admins as $admin) {
                app(NotificationService::class)->send(
                    recipient: $admin,

                    event:
                        NotificationService::KYC_SUBMITTED,

                    title:
                        'Pengajuan Freelancer Baru',

                    message:
                        'Ada pengajuan verifikasi freelancer baru dari ' .
                        ($verification->full_name ?? 'freelancer') .
                        '. Silakan periksa data identitas dan rekening.',

                    actionUrl:
                        route(
                            'admin.verifications.show',
                            $verification
                        ),

                    priority:
                        NotificationService::PRIORITY_CRITICAL,

                    actor:
                        $user,

                    relatedType:
                        'freelancer_verification',

                    relatedId:
                        $verification->id,

                    extra: [
                        /*
                        |--------------------------------------------------------------------------
                        | Digunakan untuk badge/menu admin
                        |--------------------------------------------------------------------------
                        */

                        'menu' =>
                            'verifications',

                        'module' =>
                            'freelancer_verification',

                        'verification_id' =>
                            $verification->id,

                        'freelancer_profile_id' =>
                            $verification->freelancer_profile_id,

                        'status' =>
                            $verification->status,

                        'submitted_at' =>
                            $verification->submitted_at
                                ?->toISOString(),

                        'freelancer_user_id' =>
                            $user->id,
                    ],

                    /*
                    |--------------------------------------------------------------------------
                    | Dedupe per submission
                    |--------------------------------------------------------------------------
                    |
                    | Setiap resubmit mempunyai submitted_at baru,
                    | sehingga Admin tetap menerima notifikasi baru.
                    |
                    */

                    dedupeKey:
                        'kyc_submitted:admin:' .
                        $admin->id .
                        ':verification:' .
                        $verification->id .
                        ':submitted:' .
                        (
                            $verification->submitted_at
                                ?->timestamp
                            ?? now()->timestamp
                        )
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Save Final Session State
            |--------------------------------------------------------------------------
            */

            session([
                'prokerja_freelancer_onboarding' =>
                    $onboarding,

                'prokerja_freelancer_onboarding_step' =>
                    5,

                'prokerja_freelancer_status' =>
                    'pending',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Redirect to Review
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'freelancer.onboarding'
                )
                ->with(
                    'status',
                    'pending'
                )
                ->with(
                    'success',
                    'Pengajuan freelancer berhasil dikirim dan sedang menunggu review admin.'
                );
        }

        abort(404);
    }
}
