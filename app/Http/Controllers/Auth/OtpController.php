<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Services\OtpDeliveryService;
use Throwable;

class OtpController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW OTP
    |--------------------------------------------------------------------------
    */

    public function show(Request $request)
    {
        $purpose = session('prokerja_otp_purpose');

        if (!in_array($purpose, ['login', 'register'], true)) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'identifier' => 'Sesi OTP tidak ditemukan. Silakan mulai kembali.',
                ]);
        }

        return view('auth.verify-otp', [
            'identifier' => session('prokerja_otp_identifier', ''),
            'channel' => session('prokerja_otp_channel', 'email'),
            'cooldown' => (int) config('otp.cooldown_seconds', 45),
            'lifetime' => (int) config('otp.lifetime_minutes', 5),
            'purpose' => $purpose,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP
    |--------------------------------------------------------------------------
    */

    public function verify(Request $request)
    {
        $purpose = session('prokerja_otp_purpose');

        if (!in_array($purpose, ['login', 'register'], true)) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'identifier' => 'Sesi OTP tidak valid.',
                ]);
        }

        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | OTP EXPIRATION
        |--------------------------------------------------------------------------
        */

        $expiresAt = session('prokerja_otp_expires_at');

        if (!$expiresAt) {
            return back()->withErrors([
                'otp' => 'Waktu OTP tidak ditemukan. Silakan kirim ulang OTP.',
            ]);
        }

        try {
            /*
             * Bisa menerima:
             * - integer timestamp
             * - Carbon
             * - DateTime
             * - string tanggal
             */

            if (is_numeric($expiresAt)) {
                $expiresTimestamp = (int) $expiresAt;
            } else {
                $expiresTimestamp = Carbon::parse(
                    $expiresAt
                )->timestamp;
            }

            $nowTimestamp = now()->timestamp;

            if ($nowTimestamp >= $expiresTimestamp) {
                return back()->withErrors([
                    'otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang OTP.',
                ]);
            }
        } catch (\Throwable $e) {
            return back()->withErrors([
                'otp' => 'Waktu OTP tidak valid. Silakan kirim ulang OTP.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ATTEMPT LIMIT
        |--------------------------------------------------------------------------
        */

        $attempts = (int) session(
            'prokerja_otp_attempts',
            0
        );

        if ($attempts >= (int) config('otp.max_attempts', 5)) {
            return back()->withErrors([
                'otp' => 'Terlalu banyak percobaan. Silakan kirim ulang OTP.',
            ]);
        }

        session()->put(
            'prokerja_otp_attempts',
            $attempts + 1
        );

        /*
        |--------------------------------------------------------------------------
        | CHECK HASH
        |--------------------------------------------------------------------------
        */

        $otpHash = session('prokerja_otp_hash');

        if (
            !$otpHash ||
            !Hash::check(
                (string) $request->input('otp'),
                $otpHash
            )
        ) {
            return back()->withErrors([
                'otp' => 'Kode OTP yang kamu masukkan salah.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | OTP VALID
        |--------------------------------------------------------------------------
        */

        if ($purpose === 'login') {
            return $this->completeLogin();
        }

        return $this->completeRegistration();
    }

    /*
    |--------------------------------------------------------------------------
    | RESEND OTP
    |--------------------------------------------------------------------------
    */

    public function resend(Request $request)
    {
        $purpose = session('prokerja_otp_purpose');

        if (!in_array($purpose, ['login', 'register'], true)) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'identifier' => 'Sesi OTP tidak valid.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | COOLDOWN
        |--------------------------------------------------------------------------
        */

        $lastSentAt = session(
            'prokerja_otp_last_sent_at'
        );

        if ($lastSentAt) {
            try {
                if (is_numeric($lastSentAt)) {
                    $lastTimestamp = (int) $lastSentAt;
                } else {
                    $lastTimestamp = Carbon::parse(
                        $lastSentAt
                    )->timestamp;
                }

                $elapsed =
                    now()->timestamp - $lastTimestamp;

                if ($elapsed < 0) {
                    $elapsed = 0;
                }

                $cooldown = (int) config('otp.cooldown_seconds', 45);

                if ($elapsed < $cooldown) {
                    $remaining = $cooldown - $elapsed;

                    return back()->withErrors([
                        'otp' =>
                            "Silakan tunggu {$remaining} detik sebelum meminta OTP baru.",
                    ]);
                }
            } catch (\Throwable $e) {
                /*
                 * Abaikan timestamp lama yang tidak valid.
                 */
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Generate and dispatch a replacement OTP
        |--------------------------------------------------------------------------
        */

        $channel = (string) session('prokerja_otp_channel', '');
        $destination = $channel === 'email'
            ? (string) session('prokerja_otp_email', '')
            : (string) session('prokerja_otp_phone', '');

        if (! in_array($channel, ['email', 'phone'], true) || $destination === '') {
            return back()->withErrors([
                'otp' => 'Alamat tujuan OTP tidak ditemukan. Silakan mulai proses login atau daftar kembali.',
            ]);
        }

        $otp = (string) random_int(100000, 999999);

        try {
            app(OtpDeliveryService::class)->send(
                $channel,
                $destination,
                $otp
            );
        } catch (Throwable $exception) {
            Log::warning('ProKerja OTP resend failed.', [
                'channel' => $channel,
                'exception' => $exception::class,
            ]);

            return back()->withErrors([
                'otp' => $channel === 'email'
                    ? 'OTP email belum dapat dikirim. Periksa konfigurasi SMTP.'
                    : 'OTP nomor HP belum dapat dikirim. Periksa konfigurasi provider SMS/WhatsApp.',
            ]);
        }

        // Replace the previous challenge only after the provider accepted the send request.
        session([
            'prokerja_otp_hash' => Hash::make($otp),
            'prokerja_otp_expires_at' => now()->timestamp
                + ((int) config('otp.lifetime_minutes', 5) * 60),
            'prokerja_otp_attempts' => 0,
            'prokerja_otp_last_sent_at' => now()->timestamp,
        ]);

        return back()->with(
            'success',
            'Kode OTP baru berhasil dikirim.'
        );
    }

        /*
    |--------------------------------------------------------------------------
    | COMPLETE LOGIN
    |--------------------------------------------------------------------------
    */

    protected function completeLogin()
    {
        $userId = session(
            'prokerja_otp_user_id'
        );

        if (!$userId) {
            $this->clearOtpSession();

            return redirect()
                ->route('login')
                ->withErrors([
                    'identifier' =>
                        'Sesi login OTP sudah tidak valid.',
                ]);
        }

        $user = User::find($userId);

        if (!$user) {
            $this->clearOtpSession();

            return redirect()
                ->route('login')
                ->withErrors([
                    'identifier' =>
                        'Akun tidak ditemukan.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ACCOUNT STATUS
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn(
                'users',
                'status'
            )
        ) {
            $blockedStatuses = [
                'blocked',
                'suspended',
                'inactive',
                'disabled',
            ];

            if (
                in_array(
                    $user->status,
                    $blockedStatuses,
                    true
                )
            ) {
                $this->clearOtpSession();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'identifier' =>
                            'Akun kamu tidak dapat digunakan untuk login.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FREELANCER INTENT
        |--------------------------------------------------------------------------
        */

        $freelancerIntent = (bool) session(
            'prokerja_register_as_freelancer',
            false
        );

        /*
        |--------------------------------------------------------------------------
        | LOGIN
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        request()->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            $this->clearOtpSession();

            session()->forget(
                'prokerja_register_as_freelancer'
            );

            return redirect()
                ->route('admin.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | EXISTING FREELANCER
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'freelancer') {

            $this->clearOtpSession();

            session()->forget(
                'prokerja_register_as_freelancer'
            );

            return redirect()
                ->route('freelancer.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | FREELANCER ONBOARDING
        |--------------------------------------------------------------------------
        */

        if ($freelancerIntent) {

            $this->clearOtpSession();

            session()->forget(
                'prokerja_register_as_freelancer'
            );

            return redirect()
                ->route('freelancer.onboarding')
                ->with(
                    'info',
                    'Login berhasil. Silakan lanjutkan pendaftaran freelancer kamu.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CLIENT
        |--------------------------------------------------------------------------
        */

        $this->clearOtpSession();

        return redirect()
            ->route('client.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | COMPLETE REGISTRATION
    |--------------------------------------------------------------------------
    */

    protected function completeRegistration()
    {
        $name = trim(
            (string) session(
                'prokerja_otp_name'
            )
        );

        $identifier = trim(
            (string) session(
                'prokerja_otp_identifier'
            )
        );

        $email = session(
            'prokerja_otp_email'
        );

        $phone = session(
            'prokerja_otp_phone'
        );

        if (
            $name === '' ||
            $identifier === ''
        ) {

            $this->clearOtpSession();

            return redirect()
                ->route('register')
                ->withErrors([
                    'identifier' =>
                        'Data pendaftaran sudah tidak valid.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | DUPLICATE EMAIL
        |--------------------------------------------------------------------------
        */

        if (
            $email &&
            Schema::hasColumn(
                'users',
                'email'
            )
        ) {

            $existingEmail =
                User::query()
                    ->where(
                        'email',
                        $email
                    )
                    ->first();

            if ($existingEmail) {

                $this->clearOtpSession();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'identifier' =>
                            'Email tersebut sudah terdaftar.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DUPLICATE PHONE
        |--------------------------------------------------------------------------
        */

        if (
            $phone &&
            Schema::hasColumn(
                'users',
                'phone'
            )
        ) {

            $existingPhone =
                User::query()
                    ->where(
                        'phone',
                        $phone
                    )
                    ->first();

            if ($existingPhone) {

                $this->clearOtpSession();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'identifier' =>
                            'Nomor telepon tersebut sudah terdaftar.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FREELANCER INTENT
        |--------------------------------------------------------------------------
        */

        $freelancerIntent =
            (bool) session(
                'prokerja_register_as_freelancer',
                false
            );

        /*
        |--------------------------------------------------------------------------
        | CREATE USER
        |--------------------------------------------------------------------------
        */

        $user = new User();

        $user->name = $name;

        if (
            $email &&
            Schema::hasColumn(
                'users',
                'email'
            )
        ) {
            $user->email = $email;
        }

        if (
            $phone &&
            Schema::hasColumn(
                'users',
                'phone'
            )
        ) {
            $user->phone = $phone;
        }

        if (
            Schema::hasColumn(
                'users',
                'password'
            )
        ) {
            $user->password =
                Hash::make(
                    bin2hex(
                        random_bytes(32)
                    )
                );
        }

        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn(
                'users',
                'role'
            )
        ) {
            $user->role = 'client';
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn(
                'users',
                'status'
            )
        ) {
            $user->status = 'active';
        }

        /*
        |--------------------------------------------------------------------------
        | EMAIL VERIFIED
        |--------------------------------------------------------------------------
        */

        if (
            $email &&
            Schema::hasColumn(
                'users',
                'email_verified_at'
            )
        ) {
            $user->email_verified_at =
                now();
        }

        /*
        |--------------------------------------------------------------------------
        | PHONE VERIFIED
        |--------------------------------------------------------------------------
        */

        if (
            $phone &&
            Schema::hasColumn(
                'users',
                'phone_verified_at'
            )
        ) {
            $user->phone_verified_at =
                now();
        }

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | REGISTERED EVENT
        |--------------------------------------------------------------------------
        */

        event(
            new Registered($user)
        );

        /*
        |--------------------------------------------------------------------------
        | LOGIN AUTOMATIC
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        request()
            ->session()
            ->regenerate();

        /*
        |--------------------------------------------------------------------------
        | CLEAR OTP
        |--------------------------------------------------------------------------
        */

        $this->clearOtpSession();

        /*
        |--------------------------------------------------------------------------
        | FREELANCER ONBOARDING
        |--------------------------------------------------------------------------
        */

        if ($freelancerIntent) {

            session()->forget(
                'prokerja_register_as_freelancer'
            );

            return redirect()
                ->route(
                    'freelancer.onboarding'
                )
                ->with(
                    'success',
                    'Akun berhasil dibuat. Silakan lengkapi pendaftaran freelancer kamu.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CLIENT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'client.dashboard'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAR SESSION
    |--------------------------------------------------------------------------
    */

    protected function clearOtpSession(): void
    {
        session()->forget([
            'prokerja_otp_purpose',
            'prokerja_otp_user_id',
            'prokerja_otp_identifier',
            'prokerja_otp_channel',
            'prokerja_otp_phone',
            'prokerja_otp_email',
            'prokerja_otp_hash',
            'prokerja_otp_expires_at',
            'prokerja_otp_attempts',
            'prokerja_otp_last_sent_at',
            'prokerja_otp_name',
        ]);
    }
}
