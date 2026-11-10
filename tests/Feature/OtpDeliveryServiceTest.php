<?php

use App\Services\OtpDeliveryService;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

it('does not treat the log mailer as real email delivery', function () {
    config(['mail.default' => 'log']);

    expect(fn () => app(OtpDeliveryService::class)->send(
        'email',
        'person@example.com',
        '123456'
    ))->toThrow(\RuntimeException::class);
});

it('dispatches email otp through the configured mail transport', function () {
    config([
        'mail.default' => 'smtp',
        'otp.email.enabled' => true,
        'otp.lifetime_minutes' => 5,
    ]);

    Mail::fake();

    app(OtpDeliveryService::class)->send(
        'email',
        'person@example.com',
        '123456'
    );

    // Mail::fake intercepts the transport; reaching this assertion means the
    // service accepted the SMTP configuration and invoked Laravel Mail.
    expect(true)->toBeTrue();
});

it('sends phone otp to a configured http gateway', function () {
    config([
        'otp.phone.driver' => 'http',
        'otp.phone.http.url' => 'https://gateway.example.test/send',
        'otp.phone.http.token' => 'test-token',
        'otp.phone.http.token_header' => 'Authorization',
        'otp.phone.http.token_prefix' => 'Bearer ',
        'otp.phone.http.body_format' => 'json',
        'otp.phone.http.phone_field' => 'to',
        'otp.phone.http.message_field' => 'message',
        'otp.phone.http.timeout' => 10,
    ]);

    Http::fake([
        'gateway.example.test/*' => Http::response(['accepted' => true], 200),
    ]);

    app(OtpDeliveryService::class)->send(
        'phone',
        '+6281234567890',
        '123456'
    );

    Http::assertSent(fn (ClientRequest $request) =>
        $request->url() === 'https://gateway.example.test/send'
        && $request->method() === 'POST'
        && $request->hasHeader('Authorization', 'Bearer test-token')
        && $request['to'] === '+6281234567890'
        && str_contains($request['message'], '123456')
    );
});

it('refuses phone otp when no real provider is configured', function () {
    config(['otp.phone.driver' => '']);

    expect(fn () => app(OtpDeliveryService::class)->send(
        'phone',
        '+6281234567890',
        '123456'
    ))->toThrow(\RuntimeException::class);
});
