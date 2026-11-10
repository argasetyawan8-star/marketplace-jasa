<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

class OtpDeliveryService
{
    /**
     * Dispatch an OTP through the requested channel.
     *
     * Phone delivery uses a generic HTTP gateway adapter so the project does
     * not depend on a provider that the project owner has not selected yet.
     */
    public function send(string $channel, string $destination, string $otp): void
    {
        $message = "Kode verifikasi ProKerja kamu adalah {$otp}.\n\n"
            . 'Kode berlaku selama ' . (int) config('otp.lifetime_minutes', 5) . " menit.\n"
            . 'Jangan berikan kode ini kepada siapa pun.';

        if ($channel === 'email') {
            $this->sendEmail($destination, $message);

            return;
        }

        if ($channel === 'phone') {
            $this->sendPhone($destination, $message);

            return;
        }

        throw new RuntimeException('Kanal pengiriman OTP tidak didukung.');
    }

    private function sendEmail(string $email, string $message): void
    {
        if (! (bool) config('otp.email.enabled', true)) {
            throw new RuntimeException('Pengiriman OTP email sedang dinonaktifkan.');
        }

        $mailer = (string) config('mail.default');

        // Never report an OTP as delivered when Laravel is only writing it to a log.
        $fallbackMailers = $mailer === 'failover'
            ? (array) config('mail.mailers.failover.mailers', [])
            : [];

        if (
            in_array($mailer, ['log', 'array'], true) ||
            count(array_intersect($fallbackMailers, ['log', 'array'])) > 0
        ) {
            throw new RuntimeException(
                'MAIL_MAILER masih menggunakan driver log/array atau fallback ke log. Konfigurasikan SMTP terlebih dahulu.'
            );
        }

        Mail::raw($message, function ($mail) use ($email): void {
            $mail->to($email)->subject('Kode Verifikasi ProKerja');
        });
    }

    private function sendPhone(string $phone, string $message): void
    {
        $driver = (string) config('otp.phone.driver', '');

        if ($driver !== 'http') {
            throw new RuntimeException(
                'Provider OTP nomor HP belum dikonfigurasi. Pilih provider SMS/WhatsApp dan isi konfigurasi HTTP API.'
            );
        }

        $url = trim((string) config('otp.phone.http.url', ''));

        if ($url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new RuntimeException('URL API provider OTP nomor HP belum valid.');
        }

        $headers = [];
        $token = (string) config('otp.phone.http.token', '');
        $tokenHeader = trim((string) config('otp.phone.http.token_header', 'Authorization'));
        $tokenPrefix = (string) config('otp.phone.http.token_prefix', 'Bearer ');

        if ($token !== '' && $tokenHeader !== '') {
            $headers[$tokenHeader] = $tokenPrefix . $token;
        }

        $phoneField = trim((string) config('otp.phone.http.phone_field', 'to'));
        $messageField = trim((string) config('otp.phone.http.message_field', 'message'));

        if ($phoneField === '' || $messageField === '') {
            throw new RuntimeException('Nama field nomor HP dan pesan pada API provider wajib diisi.');
        }

        $payload = [
            $phoneField => $phone,
            $messageField => $message,
        ];

        $request = Http::acceptJson()
            ->timeout((int) config('otp.phone.http.timeout', 15))
            ->withHeaders($headers);

        $response = config('otp.phone.http.body_format', 'json') === 'form'
            ? $request->asForm()->post($url, $payload)
            : $request->asJson()->post($url, $payload);

        $response->throw();
    }
}
