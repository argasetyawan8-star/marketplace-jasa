<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeEvidence;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DisputeController extends Controller
{
    private const DISPUTABLE_STATUSES = [
        'paid',
        'in_progress',
        'delivered',
        'revision',
    ];

    private const CATEGORIES = [
        'delivery_issue',
        'quality_issue',
        'scope_issue',
        'communication_issue',
        'non_delivery',
        'payment_issue',
        'other',
    ];

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(
        Order $order
    ): View|RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        abort_unless(
            $order->freelancer_profile_id === $profile->id,
            403
        );

        abort_unless(
            in_array(
                $order->status,
                self::DISPUTABLE_STATUSES,
                true
            ),
            422
        );

        /*
        |--------------------------------------------------------------------------
        | Jika sudah ada dispute aktif, jangan membuat dispute baru.
        | Arahkan Freelancer ke dispute yang sedang berjalan.
        |--------------------------------------------------------------------------
        */

        $activeDispute = $order->activeDispute;

        if ($activeDispute) {
            return redirect()->route(
                'freelancer.disputes.show',
                $activeDispute
            );
        }

        $order->load([
            'client',
            'items.service',
        ]);

        $existingDispute = $order->disputes()
            ->latest('id')
            ->first();

        return view(
            'freelancer.disputes.create',
            compact(
                'order',
                'existingDispute'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        Order $order
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        abort_unless(
            $order->freelancer_profile_id === $profile->id,
            403
        );

        abort_unless(
            in_array(
                $order->status,
                self::DISPUTABLE_STATUSES,
                true
            ),
            422
        );

        $activeDispute = $order->activeDispute;

        if ($activeDispute) {
            return redirect()->route(
                'freelancer.disputes.show',
                $activeDispute
            );
        }

        $validated = $request->validate([
            'category' => [
                'required',
                'string',
                'in:' . implode(',', self::CATEGORIES),
            ],
            'reason' => [
                'required',
                'string',
                'min:20',
                'max:5000',
            ],
        ]);

        $disputeNumber =
            'DSP-' .
            now()->format('YmdHis') .
            '-' .
            random_int(100, 999);

        $dispute = $order->disputes()->create([
            'dispute_number' => $disputeNumber,
            'opened_by' => Auth::id(),
            'opened_by_role' => 'freelancer',
            'category' => $validated['category'],
            'reason' => $validated['reason'],
            'status' => 'pending_response',
        ]);

        return redirect()
            ->route(
                'freelancer.disputes.show',
                $dispute
            )
            ->with(
                'success',
                'Dispute berhasil diajukan. Client sekarang dapat memberikan tanggapan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(
        Dispute $dispute
    ): View {
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

        $this->authorizeDispute($dispute);

        return view(
            'freelancer.disputes.show',
            compact('dispute')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MESSAGE
    |--------------------------------------------------------------------------
    */

    public function message(
        Request $request,
        Dispute $dispute
    ): RedirectResponse {
        $dispute->load('order');

        $this->authorizeDispute($dispute);

        abort_unless(
            in_array(
                $dispute->status,
                [
                    'open',
                    'pending_response',
                    'under_review',
                ],
                true
            ),
            422,
            'Dispute ini sudah tidak menerima tanggapan.'
        );

        $validated = $request->validate([
            'message' => [
                'required',
                'string',
                'min:2',
                'max:5000',
            ],
        ]);

        $dispute->messages()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Client membuka dispute → Freelancer membalas
        | → masuk tahap review Admin.
        |--------------------------------------------------------------------------
        */

        if (
            $dispute->opened_by_role === 'client' &&
            $dispute->opened_by !== Auth::id() &&
            $dispute->status === 'pending_response'
        ) {
            $dispute->update([
                'status' => 'under_review',
            ]);
        }

        return back()->with(
            'success',
            'Tanggapan berhasil dikirim.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EVIDENCE
    |--------------------------------------------------------------------------
    */

    public function evidence(
        Request $request,
        Dispute $dispute
    ): RedirectResponse {
        $dispute->load('order');

        $this->authorizeDispute($dispute);

        abort_unless(
            in_array(
                $dispute->status,
                [
                    'open',
                    'pending_response',
                    'under_review',
                ],
                true
            ),
            422,
            'Dispute ini sudah tidak menerima bukti tambahan.'
        );

        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240',
                'mimes:jpg,jpeg,png,webp,pdf,doc,docx,xls,xlsx,zip',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $file = $validated['file'];

        $path = $file->store(
            'disputes/evidences',
            'public'
        );

        DisputeEvidence::create([
            'dispute_id' => $dispute->id,
            'uploaded_by' => Auth::id(),
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'description' =>
                $validated['description'] ?? null,
        ]);

        return back()->with(
            'success',
            'Bukti berhasil ditambahkan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PRIVATE
    |--------------------------------------------------------------------------
    */

    private function authorizeDispute(
        Dispute $dispute
    ): void {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        abort_unless(
            $dispute->order &&
            $dispute->order->freelancer_profile_id === $profile->id,
            403
        );
    }
}