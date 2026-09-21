<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Refund;
use Illuminate\Support\Str;

class RefundService
{
    public function createPending(
        Order $order,
        string $sourceType,
        int $sourceId,
        ?string $reason = null
    ): ?Refund {
        $payment = $order->payment;

        if (! $payment) {
            return null;
        }

        if (
            ! in_array(
                $payment->status,
                [
                    'refund_pending',
                    'paid',
                ],
                true
            )
        ) {
            return null;
        }

        $existing = Refund::query()
            ->where('order_id', $order->id)
            ->whereIn('status', [
                'pending',
                'processing',
            ])
            ->latest('id')
            ->first();

        if ($existing) {
            return $existing;
        }

        return Refund::create([
            'refund_number' => $this->generateNumber(),
            'order_id' => $order->id,
            'payment_id' => $payment->id,
            'source_type' => $sourceType,
            'source_id' => $sourceId,
            'amount' => $order->total,
            'reason' => $reason,
            'status' => 'pending',
        ]);
    }

    private function generateNumber(): string
    {
        do {
            $number =
                'RFD-' .
                now()->format('YmdHis') .
                '-' .
                random_int(100, 999);
        } while (
            Refund::where(
                'refund_number',
                $number
            )->exists()
        );

        return $number;
    }
}