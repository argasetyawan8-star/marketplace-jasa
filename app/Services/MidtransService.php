<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    /**
     * Membuat Snap transaction token.
     */
    public function createSnapToken(Order $order): string
    {
        $order->load([
            'client',
            'items',
            'freelancerProfile.user',
        ]);

        $itemDetails = [];

        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => (string) $item->service_id,
                'price' => (int) $item->unit_price,
                'quantity' => (int) $item->quantity,
                'name' => mb_substr($item->service_title, 0, 50),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Platform Fee
        |--------------------------------------------------------------------------
        |
        | Midtrans harus menerima total yang sama dengan total order.
        | Karena biaya platform dicatat terpisah di order, kita tambahkan
        | sebagai item tersendiri agar detail transaksi lengkap.
        |
        */

        if ((float) $order->platform_fee > 0) {
            $itemDetails[] = [
                'id' => 'PLATFORM-FEE',
                'price' => (int) $order->platform_fee,
                'quantity' => 1,
                'name' => 'Biaya platform',
            ];
        }

        $customerName = $order->client?->name ?? 'Customer';

        $nameParts = preg_split('/\s+/', trim($customerName));

        $firstName = $nameParts[0] ?? 'Customer';

        $lastName = count($nameParts) > 1
            ? implode(' ', array_slice($nameParts, 1))
            : '';

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],

            'item_details' => $itemDetails,

            'customer_details' => [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $order->client?->email,
            ],

            'credit_card' => [
                'secure' => true,
            ],
        ];

        return Snap::getSnapToken($params);
    }
}