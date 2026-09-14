<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Daftar order milik client.
     */
    public function index(): View
    {
        $orders = Order::query()
            ->with([
                'items.service',
                'freelancerProfile.user',
            ])
            ->where('client_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('client.orders.index', compact('orders'));
    }

    /**
     * Detail order.
     */
    public function show(Order $order): View
    {
        abort_unless(
            $order->client_id === auth()->id(),
            403
        );

        $order->load([
            'items.service',
            'freelancerProfile.user',
        ]);

        return view('client.orders.show', compact('order'));
    }

    /**
     * Halaman checkout.
     */
    public function checkout(Order $order): View
    {
        abort_unless(
            $order->client_id === auth()->id(),
            403
        );

        $order->load([
            'items.service',
            'freelancerProfile.user',
        ]);

        return view('client.orders.checkout', compact('order'));
    }

    /**
     * Membuat order baru dari service.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],

            'requirements' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        /**
         * Ambil service yang hanya boleh dipesan
         * jika statusnya published.
         */
        $service = Service::query()
            ->with('freelancerProfile.user')
            ->where('id', $validated['service_id'])
            ->where('status', 'published')
            ->firstOrFail();

        /**
         * Pastikan service memiliki freelancer.
         */
        if (! $service->freelancerProfile) {
            abort(404);
        }

        /**
         * Pastikan freelancer sedang tersedia.
         */
        if (! $service->freelancerProfile->is_available) {
            return back()->with(
                'error',
                'Freelancer sedang tidak tersedia untuk menerima order.'
            );
        }

        /**
         * Harga jasa.
         */
        $subtotal = (float) $service->starting_price;

        /**
         * Sementara menggunakan 10% untuk development.
         *
         * Nanti kita pindahkan ke pengaturan marketplace
         * supaya Admin bisa mengubahnya.
         */
        $platformFeeRate = 0.10;

        $platformFee = round(
            $subtotal * $platformFeeRate,
            2
        );

        $total = $subtotal;

        $freelancerAmount = $total - $platformFee;

        /**
         * Simpan order + item dalam satu transaction.
         */
        $order = DB::transaction(function () use (
            $service,
            $validated,
            $subtotal,
            $platformFee,
            $total,
            $freelancerAmount
        ) {
            $orderNumber = 'ORD-'
                . now()->format('YmdHis')
                . '-'
                . random_int(100, 999);

            $order = Order::create([
                'client_id' => auth()->id(),

                'freelancer_profile_id' =>
                    $service->freelancer_profile_id,

                'order_number' => $orderNumber,

                'status' => 'pending_payment',

                'subtotal' => $subtotal,

                'platform_fee' => $platformFee,

                'total' => $total,

                'freelancer_amount' => $freelancerAmount,

                'requirements' =>
                    $validated['requirements'] ?? null,

                'delivery_days' =>
                    $service->delivery_days,

                'due_at' =>
                    now()->addDays($service->delivery_days),
            ]);

            $order->items()->create([
                'service_id' => $service->id,

                'service_title' => $service->title,

                'quantity' => 1,

                'unit_price' => $subtotal,

                'subtotal' => $subtotal,

                'delivery_days' =>
                    $service->delivery_days,

                'requirements' =>
                    $validated['requirements'] ?? null,
            ]);

            return $order;
        });

        return redirect()
            ->route(
                'client.orders.checkout',
                $order
            )
            ->with(
                'success',
                'Order berhasil dibuat. Silakan lanjut ke checkout.'
            );
    }
}