<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Services\OtpDeliveryService;
use Throwable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }


    /**
     * Handle an incoming OTP login request.
     *
     * Flow:
     * identifier
     *      ↓
     * detect email / phone
     *      ↓
     * find account
     *      ↓
     * generate OTP
     *      ↓
     * store OTP challenge in session
     *      ↓
     * redirect to OTP verification
     */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validate identifier
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [
                'identifier' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ],
            [
                'identifier.required' =>
                    'Email atau nomor HP wajib diisi.',

                'identifier.string' =>
                    'Format identitas login tidak valid.',

                'identifier.max' =>
                    'Email atau nomor HP terlalu panjang.',
            ]
        );

        $validator->validate();


        /*
        |--------------------------------------------------------------------------
        | Normalize input
        |--------------------------------------------------------------------------
        */

        $identifier =
            trim(
                (string) $request->input('identifier')
            );


        $isEmail =
            filter_var(
                $identifier,
                FILTER_VALIDATE_EMAIL
            ) !== false;


        $channel = $isEmail
            ? 'email'
            : 'phone';


        /*
        |--------------------------------------------------------------------------
        | Normalize phone number
        |--------------------------------------------------------------------------
        |
        | Format yang didukung:
        |
        | 081234567890
        | +6281234567890
        | 6281234567890
        |
        */

        $normalizedPhone = null;

        if ($channel === 'phone') {

            $normalizedPhone =
                preg_replace(
                    '/[^0-9+]/',
                    '',
                    $identifier
                );


            if (
                str_starts_with(
                    $normalizedPhone,
                    '08'
                )
            ) {
                $normalizedPhone =
                    '+62' .
                    substr(
                        $normalizedPhone,
                        1
                    );
            }


            if (
                str_starts_with(
                    $normalizedPhone,
                    '62'
                )
            ) {
                $normalizedPhone =
                    '+' .
                    $normalizedPhone;
            }


            if (
                !preg_match(
                    '/^\+62[0-9]{9,13}$/',
                    $normalizedPhone
                )
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'identifier' =>
                            'Nomor HP Indonesia yang dimasukkan tidak valid.',
                    ]);

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Find account
        |--------------------------------------------------------------------------
        */

        $user = null;


        if ($channel === 'email') {

            $user =
                User::query()
                    ->whereRaw(
                        'LOWER(email) = ?',
                        [
                            mb_strtolower(
                                $identifier
                            ),
                        ]
                    )
                    ->first();

        } else {

            /*
            |--------------------------------------------------------------------------
            | Phone column compatibility
            |--------------------------------------------------------------------------
            |
            | Kita cek terlebih dahulu supaya controller tidak
            | langsung error jika kolom phone belum tersedia.
            |
            */

            if (
                !Schema::hasColumn(
                    'users',
                    'phone'
                )
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'identifier' =>
                            'Login menggunakan nomor HP belum tersedia pada akun ProKerja. Silakan gunakan email.',
                    ]);

            }


            $user =
                User::query()
                    ->where(
                        'phone',
                        $normalizedPhone
                    )
                    ->first();


            /*
            |--------------------------------------------------------------------------
            | Fallback untuk format nomor lama
            |--------------------------------------------------------------------------
            |
            | Beberapa data mungkin masih tersimpan sebagai 08...
            |
            */

            if (!$user) {

                $localPhone =
                    '0' .
                    substr(
                        $normalizedPhone,
                        3
                    );


                $user =
                    User::query()
                        ->where(
                            'phone',
                            $localPhone
                        )
                        ->first();

            }


            /*
            |--------------------------------------------------------------------------
            | Fallback untuk format 62...
            |--------------------------------------------------------------------------
            */

            if (!$user) {

                $withoutPlus =
                    ltrim(
                        $normalizedPhone,
                        '+'
                    );


                $user =
                    User::query()
                        ->where(
                            'phone',
                            $withoutPlus
                        )
                        ->first();

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Account not found
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return back()
                ->withInput()
                ->withErrors([
                    'identifier' =>
                        'Akun dengan email atau nomor HP tersebut belum terdaftar di ProKerja.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Generate OTP
        |--------------------------------------------------------------------------
        */

        $otp =
            (string) random_int(
                100000,
                999999
            );


        /*
        |--------------------------------------------------------------------------
        | Store OTP challenge
        |--------------------------------------------------------------------------
        |
        | OTP tidak disimpan dalam bentuk plain text.
        |
        */

        $request->session()->put([
            'prokerja_otp_user_id' =>
                $user->id,

            'prokerja_otp_identifier' =>
                $identifier,

            'prokerja_otp_channel' =>
                $channel,

            'prokerja_otp_phone' =>
                $normalizedPhone,

            'prokerja_otp_email' =>
                $channel === 'email' ? $user->email : null,

            'prokerja_otp_hash' =>
                Hash::make($otp),

            'prokerja_otp_expires_at' =>
                now()->addMinutes((int) config('otp.lifetime_minutes', 5))->timestamp,

            'prokerja_otp_attempts' =>
                0,

            'prokerja_otp_last_sent_at' =>
                now()->timestamp,

            'prokerja_otp_purpose' =>
                'login',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Send OTP through the centralized delivery service
        |--------------------------------------------------------------------------
        */

        $destination = $channel === 'email'
            ? (string) $user->email
            : (string) $normalizedPhone;

        try {
            app(OtpDeliveryService::class)->send(
                $channel,
                $destination,
                $otp
            );
        } catch (Throwable $exception) {
            Log::warning('ProKerja OTP dispatch failed.', [
                'channel' => $channel,
                'exception' => $exception::class,
            ]);

            $request->session()->forget([
                'prokerja_otp_user_id',
                'prokerja_otp_identifier',
                'prokerja_otp_channel',
                'prokerja_otp_phone',
                'prokerja_otp_email',
                'prokerja_otp_hash',
                'prokerja_otp_expires_at',
                'prokerja_otp_attempts',
                'prokerja_otp_last_sent_at',
                'prokerja_otp_purpose',
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'identifier' => $channel === 'email'
                        ? 'OTP email belum dapat dikirim. Periksa konfigurasi SMTP ProKerja.'
                        : 'OTP nomor HP belum dapat dikirim. Provider SMS/WhatsApp belum dikonfigurasi dengan benar.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent the OTP step from being tied to old login state
        |--------------------------------------------------------------------------
        */

        $request->session()->forget([
            'login_email',
            'login_password',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect to OTP verification
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('otp.verify')
            ->with(
                'status',
                'Kode verifikasi telah dikirim.'
            );
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(
        Request $request
    ): RedirectResponse {

        Auth::guard('web')->logout();

        $request
            ->session()
            ->invalidate();

        $request
            ->session()
            ->regenerateToken();

        return redirect('/');
    }
}
