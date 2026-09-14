<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Menampilkan daftar komisi.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $allowedStatuses = [
            'pending',
            'earned',
            'paid',
            'cancelled',
        ];

        $commissions = Commission::query()
            ->with([
                'order.client',
                'freelancerProfile.user',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('order', function ($orderQuery) use ($search) {
                        $orderQuery->where(
                            'order_number',
                            'like',
                            '%' . $search . '%'
                        );
                    })
                    ->orWhereHas('order.client', function ($clientQuery) use ($search) {
                        $clientQuery
                            ->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('freelancerProfile.user', function ($userQuery) use ($search) {
                        $userQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );
                    });
                });
            })
            ->when(
                in_array($status, $allowedStatuses, true),
                fn ($query) => $query->where('status', $status)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.commissions.index', compact(
            'commissions',
            'search',
            'status'
        ));
    }

    /**
     * Menampilkan detail komisi.
     */
    public function show(Commission $commission)
    {
        $commission->load([
            'order.client',
            'order.payment',
            'order.items',
            'freelancerProfile.user',
        ]);

        return view('admin.commissions.show', compact('commission'));
    }
}