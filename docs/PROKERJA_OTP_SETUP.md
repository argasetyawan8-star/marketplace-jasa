# ProKerja OTP Setup

## 1. Email OTP (SMTP)

The OTP sender now uses one service for login, registration, and resend. It deliberately refuses to use Laravel's `log` or `array` mailer so an OTP is not falsely reported as delivered when it was only written to a log.

Copy the SMTP settings into your local `.env` and replace the placeholders:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-gmail-app-password
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="ProKerja"

OTP_EMAIL_ENABLED=true
OTP_LIFETIME_MINUTES=5
OTP_RESEND_COOLDOWN_SECONDS=45
OTP_MAX_ATTEMPTS=5
```

For Gmail, use an App Password rather than your normal account password. The Gmail account must have the required two-step verification/App Password eligibility. Another SMTP provider can be used by changing the host, port, username, password, and sender address.

After editing `.env`, run:

```bash
php artisan config:clear
php artisan cache:clear
```

## 2. Phone OTP (SMS or WhatsApp)

Phone delivery is intentionally not marked as active until a real provider is selected and configured. The project contains a generic HTTP API adapter. It sends a POST request containing a phone field and a message field. Configure the field names and authorization header to match the selected provider's current API documentation.

Example configuration shape:

```env
OTP_PHONE_DRIVER=http
OTP_PHONE_API_URL=https://your-provider.example/api/send
OTP_PHONE_API_TOKEN=your-provider-api-token
OTP_PHONE_API_TOKEN_HEADER=Authorization
OTP_PHONE_API_TOKEN_PREFIX="Bearer "
OTP_PHONE_API_BODY_FORMAT=json
OTP_PHONE_API_PHONE_FIELD=to
OTP_PHONE_API_MESSAGE_FIELD=message
OTP_PHONE_API_TIMEOUT=15
```

Use `OTP_PHONE_API_BODY_FORMAT=form` when the provider expects form-encoded data. Some providers use a different endpoint, authorization format, or request schema; match all values to that provider's official API. Do not paste provider secrets into source code or commit the `.env` file.

If `OTP_PHONE_DRIVER` is empty or the API settings are invalid, phone OTP requests fail with a clear message instead of writing the OTP to `laravel.log`.

## 3. Security behavior

- OTP values are generated with `random_int()` and stored in the session as a password hash, not plaintext.
- The default OTP lifetime is 5 minutes.
- The default resend cooldown is 45 seconds.
- The default maximum number of verification attempts is 5 per challenge.
- Login, registration, verification, and resend endpoints have IP-level throttling.
- The previous challenge is replaced only after the new OTP provider request succeeds.
- OTP values are never written to application logs by the OTP delivery implementation.

## 4. Apply and verify

Run:

```bash
php artisan config:clear
php artisan route:list --path=login
php artisan route:list --path=verify-otp
php artisan test --filter=OtpDeliveryServiceTest
```

Then test with an email address you can access: request login/register OTP, confirm the email arrives, enter the code once, wait for the expiry/cooldown behavior if needed, and verify resend. Phone delivery requires the selected provider credentials and a real reachable phone number.
