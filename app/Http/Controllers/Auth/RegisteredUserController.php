<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use App\Services\OtpDeliveryService;
use Throwable;

class RegisteredUserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Normal Register
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Freelancer intent
        |--------------------------------------------------------------------------
        |
        | /register?freelancer=1
        |
        | digunakan ketika guest datang dari tombol
        | "Daftar sebagai Freelancer".
        |
        */

        $freelancerIntent = $request->boolean('freelancer');

        if ($freelancerIntent) {
            session([
                'prokerja_register_as_freelancer' => true,
            ]);
        } else {
            session()->forget(
                'prokerja_register_as_freelancer'
            );
        }

        return view(
            'auth.register',
            [
                'freelancerIntent' => $freelancerIntent,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Freelancer Register
    |--------------------------------------------------------------------------
    */

    
public function createFreelancer(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | User sudah login
    |--------------------------------------------------------------------------
    |
    | Tidak membuat akun kedua.
    | Langsung masuk ke onboarding freelancer.
    |
    */

    if (auth()->check()) {
        return redirect()->route(
            'freelancer.onboarding'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | User belum login
    |--------------------------------------------------------------------------
    |
    | Tandai bahwa proses register ini adalah
    | pendaftaran freelancer.
    |
    | OTP yang sudah kamu punya tetap dipakai.
    |
    */

    session()->put(
        'prokerja_register_as_freelancer',
        true
    );

    return view(
        'auth.register',
        [
            'freelancerIntent' => true,
        ]
    );
}



    /*
    |--------------------------------------------------------------------------
    | Process Register
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
            ],

            'identifier' => [
                'required',
                'string',
                'max:255',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Identifier
        |--------------------------------------------------------------------------
        */

        $identifier = trim(
            $validated['identifier']
        );


        $isEmail = filter_var(
            $identifier,
            FILTER_VALIDATE_EMAIL
        );


        $email = null;
        $phone = null;
        $channel = null;


        /*
        |--------------------------------------------------------------------------
        | Email
        |--------------------------------------------------------------------------
        */

        if ($isEmail) {

            $email = strtolower(
                $identifier
            );

            $channel = 'email';

        } else {

            /*
            |--------------------------------------------------------------------------
            | Phone
            |--------------------------------------------------------------------------
            */

            $phone = $this->normalizePhone(
                $identifier
            );

            if (!$phone) {
                throw ValidationException::withMessages([
                    'identifier' =>
                        'Masukkan email yang valid atau nomor telepon Indonesia yang valid.',
                ]);
            }

            $channel = 'phone';
        }


        /*
        |--------------------------------------------------------------------------
        | Database columns
        |--------------------------------------------------------------------------
        */

        $usersHasEmail = Schema::hasColumn(
            'users',
            'email'
        );

        $usersHasPhone = Schema::hasColumn(
            'users',
            'phone'
        );


        /*
        |--------------------------------------------------------------------------
        | Phone column wajib tersedia
        |--------------------------------------------------------------------------
        */

        if (
            $channel === 'phone' &&
            !$usersHasPhone
        ) {
            throw ValidationException::withMessages([
                'identifier' =>
                    'Kolom nomor telepon belum tersedia pada tabel users.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Check duplicate email
        |--------------------------------------------------------------------------
        */

        if (
            $channel === 'email' &&
            $usersHasEmail
        ) {

            $exists = \App\Models\User::query()
                ->where('email', $email)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'identifier' =>
                        'Email tersebut sudah terdaftar. Silakan masuk.',
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Check duplicate phone
        |--------------------------------------------------------------------------
        */

        if (
            $channel === 'phone' &&
            $usersHasPhone
        ) {

            $exists = \App\Models\User::query()
                ->where('phone', $phone)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'identifier' =>
                        'Nomor telepon tersebut sudah terdaftar. Silakan masuk.',
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Generate OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(
            100000,
            999999
        );


        /*
        |--------------------------------------------------------------------------
        | Freelancer intent
        |--------------------------------------------------------------------------
        */

        $freelancerIntent = session(
            'prokerja_register_as_freelancer',
            false
        );


        /*
        |--------------------------------------------------------------------------
        | Send OTP through the centralized delivery service
        |--------------------------------------------------------------------------
        */

        $destination = $channel === 'email'
            ? (string) $email
            : (string) $phone;

        try {
            app(OtpDeliveryService::class)->send(
                $channel,
                $destination,
                $otp
            );
        } catch (Throwable $exception) {
            report($exception);

            throw ValidationException::withMessages([
                'identifier' => $channel === 'email'
                    ? 'OTP email belum dapat dikirim. Periksa konfigurasi SMTP ProKerja.'
                    : 'OTP nomor HP belum dapat dikirim. Provider SMS/WhatsApp belum dikonfigurasi dengan benar.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Store OTP registration challenge
        |--------------------------------------------------------------------------
        */

        session([
            'prokerja_otp_purpose' =>
                'register',

            'prokerja_otp_name' =>
                $validated['name'],

            'prokerja_otp_identifier' =>
                $identifier,

            'prokerja_otp_channel' =>
                $channel,

            'prokerja_otp_email' =>
                $email,

            'prokerja_otp_phone' =>
                $phone,

            'prokerja_otp_hash' =>
                Hash::make($otp),

            'prokerja_otp_expires_at' =>
                now()->addMinutes((int) config('otp.lifetime_minutes', 5))->timestamp,

            'prokerja_otp_attempts' =>
                0,

            'prokerja_otp_last_sent_at' =>
                now()->timestamp,

            'prokerja_register_as_freelancer' =>
                (bool) $freelancerIntent,
        ]);


        return redirect()
            ->route('otp.verify');
    }


    /*
    |--------------------------------------------------------------------------
    | Normalize Indonesia Phone
    |--------------------------------------------------------------------------
    */

    protected function normalizePhone(
        string $phone
    ): ?string {

        $phone = preg_replace(
            '/[\s\-\(\)]/',
            '',
            $phone
        );


        /*
        |--------------------------------------------------------------------------
        | 08xxxxxxxxxx
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $phone,
                '08'
            )
        ) {

            $normalized = '+62' . substr($phone, 1);

            return preg_match('/^\+628[0-9]{8,12}$/', $normalized)
                ? $normalized
                : null;
        }


        /*
        |--------------------------------------------------------------------------
        | 628xxxxxxxxx
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $phone,
                '62'
            )
        ) {

            $normalized = '+' . $phone;

            return preg_match('/^\+628[0-9]{8,12}$/', $normalized)
                ? $normalized
                : null;
        }


        /*
        |--------------------------------------------------------------------------
        | +628xxxxxxxxx
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with($phone, '+62') &&
            preg_match('/^\+628[0-9]{8,12}$/', $phone)
        ) {
            return $phone;
        }


        /*
        |--------------------------------------------------------------------------
        | 8xxxxxxxxx
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $phone,
                '8'
            )
        ) {

            $normalized = '+62' . $phone;

            return preg_match('/^\+628[0-9]{8,12}$/', $normalized)
                ? $normalized
                : null;
        }


        return null;
    }


}
