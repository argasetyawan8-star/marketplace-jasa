<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * Menampilkan daftar seluruh pengajuan penarikan.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $allowedStatuses = [
            'pending',
            'processing',
            'approved',
            'rejected',
        ];

        $withdrawals = Withdrawal::query()
            ->with([
                'freelancerProfile.user',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('account_name', 'like', '%' . $search . '%')
                        ->orWhere('account_number', 'like', '%' . $search . '%')
                        ->orWhere('method', 'like', '%' . $search . '%')
                        ->orWhereHas('freelancerProfile.user', function ($userQuery) use ($search) {
                            $userQuery
                                ->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
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

        return view('admin.withdrawals.index', compact(
            'withdrawals',
            'search',
            'status'
        ));
    }

    /**
     * Menampilkan detail pengajuan penarikan.
     */
    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load([
            'freelancerProfile.user',
        ]);

        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    /**
     * Memperbarui status pengajuan penarikan.
     */
    public function update(Request $request, Withdrawal $withdrawal)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,processing,approved,rejected',
            ],
            'rejection_reason' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $updateData = [
            'status' => $validated['status'],
        ];

        if ($validated['status'] === 'rejected') {
            $updateData['rejection_reason'] =
                $validated['rejection_reason'] ?? null;
        } else {
            $updateData['rejection_reason'] = null;
        }

        if (
            in_array($validated['status'], ['processing', 'approved', 'rejected'], true)
            && !$withdrawal->processed_at
        ) {
            $updateData['processed_at'] = now();
        }

        if ($validated['status'] === 'pending') {
            $updateData['processed_at'] = null;
        }

        $withdrawal->update($updateData);

        return redirect()
            ->route('admin.withdrawals.show', $withdrawal)
            ->with('success', 'Status penarikan berhasil diperbarui.');
    }
}