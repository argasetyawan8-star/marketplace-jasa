<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DisputeController extends Controller
{
    private const REVIEWABLE_STATUS = 'under_review';

    private const STATUSES = [
        'open',
        'pending_response',
        'under_review',
        'resolved_client',
        'resolved_freelancer',
        'resolved_partial',
        'closed',
    ];

    public function index(Request $request): View
    {
        $query = Dispute::query()
            ->with([
                'order.client',
                'order.freelancerProfile.user',
                'opener',
                'resolver',
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
                        'dispute_number',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'reason',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'category',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'order',
                        function ($orderQuery) use ($search) {
                            $orderQuery->where(
                                'order_number',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    )
                    ->orWhereHas(
                        'opener',
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

        $disputes = $query
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'all' => Dispute::count(),
            'open' => Dispute::where(
                'status',
                'open'
            )->count(),
            'pending_response' => Dispute::where(
                'status',
                'pending_response'
            )->count(),
            'under_review' => Dispute::where(
                'status',
                'under_review'
            )->count(),
            'resolved' => Dispute::whereIn(
                'status',
                [
                    'resolved_client',
                    'resolved_freelancer',
                    'resolved_partial',
                    'closed',
                ]
            )->count(),
        ];

        return view(
            'admin.disputes.index',
            compact('disputes', 'counts')
        );
    }

    public function show(Dispute $dispute): View
    {
        $dispute->load([
            'order.client.profile',
            'order.freelancerProfile.user',
            'order.items.service',
            'order.payment',
            'order.deliveries',
            'opener',
            'resolver',
            'messages.user',
            'evidences.uploader',
        ]);

        return view(
            'admin.disputes.show',
            compact('dispute')
        );
    }

    public function resolve(
        Request $request,
        Dispute $dispute
    ): RedirectResponse {
        $validated = $request->validate([
            'resolution' => [
                'required',
                'string',
                'in:client,freelancer,partial',
            ],
            'resolution_note' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
        ]);

        DB::transaction(function () use (
            $dispute,
            $validated
        ) {
            $lockedDispute = Dispute::query()
                ->lockForUpdate()
                ->findOrFail($dispute->id);

            abort_unless(
                $lockedDispute->status === self::REVIEWABLE_STATUS,
                422,
                'Dispute ini belum berada pada tahap peninjauan admin.'
            );

            $status = match ($validated['resolution']) {
                'client' => 'resolved_client',
                'freelancer' => 'resolved_freelancer',
                'partial' => 'resolved_partial',
            };

            $lockedDispute->update([
                'status' => $status,
                'resolution' => $validated['resolution'],
                'resolution_note' => $validated['resolution_note'],
                'resolved_by' => Auth::id(),
                'resolved_at' => now(),
            ]);
        });

        return redirect()
            ->route(
                'admin.disputes.show',
                $dispute
            )
            ->with(
                'success',
                'Dispute berhasil diselesaikan. Jika keputusan menimbulkan refund, proses uangnya akan ditangani pada modul Refund.'
            );
    }

    public function close(Dispute $dispute): RedirectResponse
    {
        abort_unless(
            $dispute->status !== 'under_review',
            422,
            'Dispute yang sedang ditinjau harus diselesaikan melalui keputusan admin.'
        );

        abort_unless(
            in_array(
                $dispute->status,
                [
                    'resolved_client',
                    'resolved_freelancer',
                    'resolved_partial',
                ],
                true
            ),
            422,
            'Dispute belum berada pada tahap yang dapat ditutup.'
        );

        $dispute->update([
            'status' => 'closed',
        ]);

        return back()->with(
            'success',
            'Dispute berhasil ditutup.'
        );
    }
}
