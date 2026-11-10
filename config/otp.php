<?php

return [
    'lifetime_minutes' => (int) env('OTP_LIFETIME_MINUTES', 5),
    'cooldown_seconds' => (int) env('OTP_RESEND_COOLDOWN_SECONDS', 45),
    'max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 5),

    'email' => [
        'enabled' => (bool) env('OTP_EMAIL_ENABLED', true),
    ],

    'phone' => [
        // Set to "http" after choosing an SMS/WhatsApp API provider.
        'driver' => env('OTP_PHONE_DRIVER', ''),

        'http' => [
            'url' => env('OTP_PHONE_API_URL', ''),
            'token' => env('OTP_PHONE_API_TOKEN', ''),
            'token_header' => env('OTP_PHONE_API_TOKEN_HEADER', 'Authorization'),
            'token_prefix' => env('OTP_PHONE_API_TOKEN_PREFIX', 'Bearer '),
            'body_format' => env('OTP_PHONE_API_BODY_FORMAT', 'json'),
            'phone_field' => env('OTP_PHONE_API_PHONE_FIELD', 'to'),
            'message_field' => env('OTP_PHONE_API_MESSAGE_FIELD', 'message'),
            'timeout' => (int) env('OTP_PHONE_API_TIMEOUT', 15),
        ],
    ],
];
