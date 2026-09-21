<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RefundController extends Controller
{
    private const STATUSES = [
        'pending',
        'processing',
        'refunded',
        'rejected',
    ];

    public function index(Request $request): View
    {
        $query = Refund::query()
            ->with([
                'order.client',
                'order.freelancerProfile.user',
                'payment',
                'processor',
            ])
            ->latest('id');

        if ($request->filled('status')) {
            $status = $request->string('status')->toString();

            if (in_array($status, self::STATUSES, true)) {
                $query->where('status', $status);
            }
        }

        if ($request->filled('search')) {
            $search = trim(
                $request->string('search')->toString()
            );

            $query->where(function ($query) use ($search) {
                $query
                    ->where(
                        'refund_number',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'reason',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'order',
                        function ($orderQuery) use ($search) {
                            $orderQuery
                                ->where(
                                    'order_number',
                                    'like',
                                    '%' . $search . '%'
                                );
                        }
                    )
                    ->orWhereHas(
                        'order.client',
                        function ($userQuery) use ($search) {
                            $userQuery
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    '%' . $search . '%'
                                );
                        }
                    );
            });
        }

        $refunds = $query
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'all' => Refund::count(),

            'pending' => Refund::where(
                'status',
                'pending'
            )->count(),

            'processing' => Refund::where(
                'status',
                'processing'
            )->count(),

            'refunded' => Refund::where(
                'status',
                'refunded'
            )->count(),

            'rejected' => Refund::where(
                'status',
                'rejected'
            )->count(),
        ];

        return view(
            'admin.refunds.index',
            compact(
                'refunds',
                'counts'
            )
        );
    }

    public function show(Refund $refund): View
    {
        $refund->load([
            'order.client',
            'order.freelancerProfile.user',
            'order.items.service',
            'payment',
            'processor',
        ]);

        return view(
            'admin.refunds.show',
            compact('refund')
        );
    }

    public function process(
        Request $request,
        Refund $refund
    ): RedirectResponse {
        $validated = $request->validate([
            'admin_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $refund,
            $validated
        ) {
            $lockedRefund = Refund::query()
                ->lockForUpdate()
                ->findOrFail($refund->id);

            abort_unless(
                $lockedRefund->status === 'pending',
                422,
                'Refund ini tidak berada pada status pending.'
            );

            $lockedRefund->update([
                'status' => 'processing',
                'processed_by' => Auth::id(),
                'admin_note' => $validated['admin_note'] ?? null,
                'processed_at' => now(),
            ]);
        });

        return redirect()
            ->route(
                'admin.refunds.show',
                $refund
            )
            ->with(
                'success',
                'Refund masuk ke tahap processing.'
            );
    }

    public function complete(
        Request $request,
        Refund $refund
    ): RedirectResponse {
        $validated = $request->validate([
            'admin_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $refund,
            $validated
        ) {
            $lockedRefund = Refund::query()
                ->lockForUpdate()
                ->findOrFail($refund->id);

            abort_unless(
                $lockedRefund->status === 'processing',
                422,
                'Refund harus berstatus processing terlebih dahulu.'
            );

            $payment = $lockedRefund->payment()
                ->lockForUpdate()
                ->firstOrFail();

            $lockedRefund->update([
                'status' => 'refunded',
                'processed_by' => Auth::id(),
                'admin_note' => $validated['admin_note']
                    ?? $lockedRefund->admin_note,
                'completed_at' => now(),
            ]);

            $payment->update([
                'status' => 'refunded',
            ]);
        });

        return redirect()
            ->route(
                'admin.refunds.show',
                $refund
            )
            ->with(
                'success',
                'Refund berhasil diselesaikan dan status pembayaran diperbarui menjadi refunded.'
            );
    }

    public function reject(
        Request $request,
        Refund $refund
    ): RedirectResponse {
        $validated = $request->validate([
            'admin_note' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $refund,
            $validated
        ) {
            $lockedRefund = Refund::query()
                ->lockForUpdate()
                ->findOrFail($refund->id);

            abort_unless(
                in_array(
                    $lockedRefund->status,
                    [
                        'pending',
                        'processing',
                    ],
                    true
                ),
                422,
                'Refund ini tidak dapat ditolak pada status sekarang.'
            );

            $lockedRefund->update([
                'status' => 'rejected',
                'processed_by' => Auth::id(),
                'admin_note' => $validated['admin_note'],
                'processed_at' => now(),
            ]);
        });

        return redirect()
            ->route(
                'admin.refunds.show',
                $refund
            )
            ->with(
                'success',
                'Refund ditolak.'
            );
    }
}