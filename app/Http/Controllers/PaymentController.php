<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PaymentController extends Controller
{
    public function token(
        Request $request,
        Order $order,
        MidtransService $midtransService
    ) {
        abort_unless($order->client_id === Auth::id(), 403);

        if ($order->status !== 'pending_payment') {
            return response()->json([
                'message' => 'Order ini tidak dapat dibayar.',
            ], 422);
        }

        $payment = $order->payment;

        if (!$payment) {
            return response()->json([
                'message' => 'Data pembayaran tidak ditemukan.',
            ], 404);
        }

        if ($payment->status !== 'pending') {
            return response()->json([
                'message' => 'Pembayaran ini sudah diproses.',
            ], 422);
        }

        try {
            $token = $midtransService->createSnapToken($order);

            $payment->update([
                'transaction_id' => $order->order_number,
            ]);

            return response()->json([
                'token' => $token,
            ]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Gagal membuat token pembayaran.',
            ], 500);
        }
    }
}