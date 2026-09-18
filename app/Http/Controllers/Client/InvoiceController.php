<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Menampilkan invoice dan detail transaksi milik Client.
     */
    public function show(Order $order)
    {
        abort_unless(
            $order->client_id === Auth::id(),
            403
        );

        $order->load([
            'client',
            'freelancerProfile.user',
            'items',
            'payment',
            'commission',
        ]);

        $invoiceNumber = 'INV-' . $order->order_number;

        $paymentStatus = match ($order->payment?->status) {
            'paid' => [
                'label' => 'Lunas',
                'class' => 'border-[#CDE7D7] bg-[#EAF7EF] text-[#168A4D]',
                'icon' => 'bi-check-circle-fill',
            ],

            'pending' => [
                'label' => 'Menunggu pembayaran',
                'class' => 'border-[#F2DDB5] bg-[#FFF9EA] text-[#9A6800]',
                'icon' => 'bi-hourglass-split',
            ],

            'failed' => [
                'label' => 'Pembayaran gagal',
                'class' => 'border-[#F0D5D5] bg-[#FFF6F6] text-[#B84E4E]',
                'icon' => 'bi-x-circle-fill',
            ],

            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'border-[#F0D5D5] bg-[#FFF6F6] text-[#B84E4E]',
                'icon' => 'bi-x-circle-fill',
            ],

            default => [
                'label' => ucfirst(
                    $order->payment?->status ?? 'Belum ada pembayaran'
                ),
                'class' => 'border-[#E1E7E3] bg-[#F7F9F8] text-[#66766E]',
                'icon' => 'bi-info-circle',
            ],
        };

        $orderStatus = match ($order->status) {
            'pending_payment' => 'Menunggu pembayaran',
            'paid' => 'Pembayaran diterima',
            'in_progress' => 'Sedang dikerjakan',
            'delivered' => 'Menunggu pemeriksaan',
            'revision' => 'Dalam revisi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst(
                str_replace('_', ' ', $order->status)
            ),
        };

        return view(
            'client.orders.invoice',
            compact(
                'order',
                'invoiceNumber',
                'paymentStatus',
                'orderStatus'
            )
        );
    }
}