<?php

namespace App\Services;

use App\Models\Refund;
use App\Models\User;
use App\Notifications\JasainNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class NotificationService
{
    /*
    |--------------------------------------------------------------------------
    | PRIORITIES
    |--------------------------------------------------------------------------
    */

    public const PRIORITY_CRITICAL = 'critical';
    public const PRIORITY_ACTION = 'action';
    public const PRIORITY_INFO = 'info';
    public const PRIORITY_NORMAL = 'normal';

    /*
    |--------------------------------------------------------------------------
    | CORE EVENT TYPES
    |--------------------------------------------------------------------------
    |
    | Semua event bisnis penting JASAIN dikumpulkan di satu tempat.
    | Controller/module cukup memanggil service ini.
    |
    */

    public const ACCOUNT_VERIFIED = 'account.verified';

    public const OFFER_RECEIVED = 'offer.received';
    public const OFFER_UPDATED = 'offer.updated';
    public const OFFER_ACCEPTED = 'offer.accepted';
    public const OFFER_REJECTED = 'offer.rejected';

    public const ORDER_CREATED = 'order.created';
    public const ORDER_READY = 'order.ready';
    public const ORDER_STARTED = 'order.started';
    public const ORDER_DEADLINE = 'order.deadline';
    public const ORDER_COMPLETED = 'order.completed';

    public const PAYMENT_SUCCESS = 'payment.success';
    public const PAYMENT_FAILED = 'payment.failed';
    public const PAYMENT_CANCELLED = 'payment.cancelled';
    public const PAYMENT_REFUND_PENDING = 'payment.refund_pending';
    public const PAYMENT_REFUND_PROCESSING = 'payment.refund_processing';
    public const PAYMENT_REFUNDED = 'payment.refunded';
    public const PAYMENT_REFUND_REJECTED = 'payment.refund_rejected';

    public const DELIVERY_SENT = 'delivery.sent';
    public const DELIVERY_APPROVED = 'delivery.approved';

    public const REVISION_REQUESTED = 'revision.requested';
    public const REVISION_SENT = 'revision.sent';

    public const CANCELLATION_SUBMITTED = 'cancellation.submitted';
    public const CANCELLATION_APPROVED = 'cancellation.approved';
    public const CANCELLATION_REJECTED = 'cancellation.rejected';
    public const CANCELLATION_MEDIATION = 'cancellation.mediation';
    public const CANCELLATION_MEDIATION_APPROVED = 'cancellation.mediation_approved';
    public const CANCELLATION_MEDIATION_REJECTED = 'cancellation.mediation_rejected';

    public const DISPUTE_OPENED = 'dispute.opened';
    public const DISPUTE_RESPONSE = 'dispute.response';
    public const DISPUTE_UNDER_REVIEW = 'dispute.under_review';
    public const DISPUTE_RESOLVED = 'dispute.resolved';
    public const DISPUTE_CLOSED = 'dispute.closed';

    public const WALLET_CREDITED = 'wallet.credited';
    public const COMMISSION_DEDUCTED = 'commission.deducted';

    public const WITHDRAWAL_SUBMITTED = 'withdrawal.submitted';
    public const WITHDRAWAL_PROCESSING = 'withdrawal.processing';
    public const WITHDRAWAL_COMPLETED = 'withdrawal.completed';
    public const WITHDRAWAL_REJECTED = 'withdrawal.rejected';

    public const KYC_SUBMITTED = 'kyc.submitted';
    public const KYC_REVIEWING = 'kyc.reviewing';
    public const KYC_APPROVED = 'kyc.approved';
    public const KYC_REJECTED = 'kyc.rejected';

    public const SERVICE_SUBMITTED = 'service.submitted';
    public const SERVICE_APPROVED = 'service.approved';
    public const SERVICE_REJECTED = 'service.rejected';
    public const SERVICE_REVISION = 'service.revision';

    public const REVIEW_WINDOW_OPEN = 'review.window_open';
    public const REVIEW_RECEIVED = 'review.received';

    public const INVOICE_AVAILABLE = 'invoice.available';

    public const MESSAGE_RECEIVED = 'message.received';

    /*
    |--------------------------------------------------------------------------
    | SEND GENERIC NOTIFICATION
    |--------------------------------------------------------------------------
    */

    public function send(
        User $recipient,
        string $event,
        string $title,
        string $message,
        ?string $actionUrl = null,
        string $priority = self::PRIORITY_NORMAL,
        ?User $actor = null,
        ?string $relatedType = null,
        int|string|null $relatedId = null,
        array $extra = [],
        ?string $dedupeKey = null
    ): void {
        if ($recipient->exists === false) {
            return;
        }

        $allowedPriorities = [
            self::PRIORITY_CRITICAL,
            self::PRIORITY_ACTION,
            self::PRIORITY_INFO,
            self::PRIORITY_NORMAL,
        ];

        if (! in_array($priority, $allowedPriorities, true)) {
            $priority = self::PRIORITY_NORMAL;
        }

        /*
        | Prevent accidental duplicate notifications for the exact same
        | business event when a controller is retried.
        */
        if ($dedupeKey !== null && $this->alreadySent($recipient, $dedupeKey)) {
            return;
        }

        $payload = array_merge([
            'event' => $event,
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl,
            'priority' => $priority,
            'actor_id' => $actor?->id,
            'actor_name' => $actor?->name,
            'related_type' => $relatedType,
            'related_id' => $relatedId,
            'dedupe_key' => $dedupeKey,
            'icon' => $this->iconFor($event),
        ], $extra);

        try {
            $recipient->notify(
                new JasainNotification($payload)
            );
        } catch (Throwable $e) {
            /*
            | Notification failure should not break the main business flow.
            | We log it so the error remains visible during development/QA.
            */
            Log::error('JASAIN notification failed.', [
                'recipient_id' => $recipient->id,
                'event' => $event,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MESSAGE
    |--------------------------------------------------------------------------
    */

    public function messageReceived(
        User $recipient,
        User $sender,
        Model $conversation,
        Model $message,
        ?string $actionUrl = null
    ): void {
        if ($recipient->id === $sender->id) {
            return;
        }

        $content = (string) (
            $message->message
            ?? $message->body
            ?? $message->content
            ?? ''
        );

        $preview = Str::limit(
            trim(strip_tags($content)),
            110
        );

        $roleLabel = match ($sender->role ?? null) {
            'client' => 'Client',
            'freelancer' => 'Freelancer',
            'admin' => 'Admin',
            default => 'Pengguna',
        };

        $this->send(
            recipient: $recipient,
            event: self::MESSAGE_RECEIVED,
            title: "Pesan baru dari {$sender->name}",
            message: $preview !== ''
                ? "{$roleLabel}: {$preview}"
                : "Kamu menerima pesan baru dari {$sender->name}.",
            actionUrl: $actionUrl,
            priority: self::PRIORITY_ACTION,
            actor: $sender,
            relatedType: 'conversation',
            relatedId: $conversation->getKey(),
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REFUND
    |--------------------------------------------------------------------------
    */

    public function refundStatusChanged(
        Refund $refund,
        string $status
    ): void {
        $refund->loadMissing([
            'order.client',
            'order.freelancerProfile.user',
        ]);

        $order = $refund->order;

        if (! $order) {
            return;
        }

        $client = $order->client;
        $freelancer = $order->freelancerProfile?->user;

        $amount = 'Rp ' . number_format(
            (float) $refund->amount,
            0,
            ',',
            '.'
        );

        $orderNumber = $order->order_number ?? ('#' . $order->id);

        $config = match ($status) {
            'pending' => [
                'event' => self::PAYMENT_REFUND_PENDING,
                'title' => 'Refund sedang diproses',
                'message' => "Refund {$amount} untuk order {$orderNumber} sudah dibuat dan menunggu diproses.",
                'priority' => self::PRIORITY_ACTION,
            ],

            'processing' => [
                'event' => self::PAYMENT_REFUND_PROCESSING,
                'title' => 'Refund mulai diproses',
                'message' => "Refund {$amount} untuk order {$orderNumber} sedang diproses oleh admin.",
                'priority' => self::PRIORITY_ACTION,
            ],

            'refunded' => [
                'event' => self::PAYMENT_REFUNDED,
                'title' => 'Refund berhasil',
                'message' => "Refund {$amount} untuk order {$orderNumber} telah selesai diproses.",
                'priority' => self::PRIORITY_CRITICAL,
            ],

            'rejected' => [
                'event' => self::PAYMENT_REFUND_REJECTED,
                'title' => 'Refund ditolak',
                'message' => "Refund untuk order {$orderNumber} ditolak. Silakan cek detail refund untuk informasi lebih lanjut.",
                'priority' => self::PRIORITY_CRITICAL,
            ],

            default => null,
        };

        if ($config === null) {
            return;
        }

        $clientUrl = $order->id
            ? route('client.orders.show', $order)
            : route('notifications.index');

        if ($client) {
            $this->send(
                recipient: $client,
                event: $config['event'],
                title: $config['title'],
                message: $config['message'],
                actionUrl: $clientUrl,
                priority: $config['priority'],
                actor: auth()->user(),
                relatedType: 'refund',
                relatedId: $refund->id,
                extra: [
                    'amount' => (float) $refund->amount,
                    'refund_number' => $refund->refund_number,
                    'order_id' => $order->id,
                    'order_number' => $orderNumber,
                    'refund_status' => $status,
                ],
                dedupeKey: "refund:{$refund->id}:{$status}:client",
            );
        }

        /*
        | Freelancer perlu tahu kalau refund sudah berdampak pada order,
        | terutama untuk status refunded/rejected.
        */
        if ($freelancer && $status !== 'pending') {
            $this->send(
                recipient: $freelancer,
                event: $config['event'],
                title: $config['title'],
                message: "Order {$orderNumber}: {$config['message']}",
                actionUrl: route('freelancer.orders.show', $order),
                priority: $config['priority'],
                actor: auth()->user(),
                relatedType: 'refund',
                relatedId: $refund->id,
                extra: [
                    'amount' => (float) $refund->amount,
                    'refund_number' => $refund->refund_number,
                    'order_id' => $order->id,
                    'order_number' => $orderNumber,
                    'refund_status' => $status,
                ],
                dedupeKey: "refund:{$refund->id}:{$status}:freelancer",
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    private function alreadySent(
        User $recipient,
        string $dedupeKey
    ): bool {
        return $recipient
            ->notifications()
            ->where('data->dedupe_key', $dedupeKey)
            ->exists();
    }

    private function iconFor(string $event): string
    {
        return match (true) {
            Str::startsWith($event, 'message.') => 'bi-chat-dots',
            Str::startsWith($event, 'payment.') => 'bi-credit-card',
            Str::startsWith($event, 'delivery.') => 'bi-file-earmark-check',
            Str::startsWith($event, 'revision.') => 'bi-arrow-repeat',
            Str::startsWith($event, 'cancellation.') => 'bi-x-circle',
            Str::startsWith($event, 'dispute.') => 'bi-shield-exclamation',
            Str::startsWith($event, 'refund.') => 'bi-arrow-counterclockwise',
            Str::startsWith($event, 'withdrawal.') => 'bi-wallet2',
            Str::startsWith($event, 'wallet.') => 'bi-wallet',
            Str::startsWith($event, 'kyc.') => 'bi-person-vcard',
            Str::startsWith($event, 'service.') => 'bi-briefcase',
            Str::startsWith($event, 'review.') => 'bi-star',
            Str::startsWith($event, 'invoice.') => 'bi-receipt',
            Str::startsWith($event, 'offer.') => 'bi-file-earmark-text',
            Str::startsWith($event, 'order.') => 'bi-bag-check',
            default => 'bi-bell',
        };
    }
}
