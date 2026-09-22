<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeEvidence;
use App\Models\Order;
use App\Models\User;
use App\Services\NotificationService;
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

    /**
     * --------------------------------------------------------------------------
     * CREATE
     * --------------------------------------------------------------------------
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

        /**
         * Jika sudah ada dispute aktif, jangan membuat dispute baru.
         * Arahkan Freelancer ke dispute yang sedang berjalan.
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

    /**
     * --------------------------------------------------------------------------
     * STORE
     * --------------------------------------------------------------------------
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

        /**
         * ----------------------------------------------------------------------
         * NOTIFICATION
         * ----------------------------------------------------------------------
         *
         * Freelancer membuka dispute:
         * 1. Client diberi tahu bahwa ada dispute dan perlu memberikan tanggapan.
         * 2. Admin diberi tahu agar dispute dapat dipantau.
         */
        $order->loadMissing([
            'client',
        ]);

        $client = $order->client;
        $freelancer = Auth::user();

        if ($client) {
            app(NotificationService::class)->send(
                recipient: $client,
                event: NotificationService::DISPUTE_OPENED,
                title: 'Dispute baru dari freelancer',
                message:
                    'Freelancer membuka dispute untuk order "' .
                    $order->order_number .
                    '". Silakan baca alasan dispute dan berikan tanggapan.',
                actionUrl: route(
                    'client.disputes.show',
                    $dispute
                ),
                priority: 'action',
                actor: $freelancer,
                relatedType: 'dispute',
                relatedId: $dispute->id,
                extra: [
                    'dispute_id' => $dispute->id,
                    'dispute_number' => $dispute->dispute_number,
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'category' => $dispute->category,
                    'status' => $dispute->status,
                    'opened_by_role' => $dispute->opened_by_role,
                ],
                dedupeKey:
                    'dispute_opened:client:' . $dispute->id
            );
        }

        /**
         * Kirim notifikasi ke seluruh Admin.
         */
        $admins = User::query()
            ->where('role', 'admin')
            ->get();

        foreach ($admins as $admin) {
            app(NotificationService::class)->send(
                recipient: $admin,
                event: NotificationService::DISPUTE_OPENED,
                title: 'Dispute baru perlu ditinjau',
                message:
                    'Freelancer membuka dispute untuk order "' .
                    $order->order_number .
                    '". Sengketa menunggu tanggapan dari Client.',
                actionUrl: route(
                    'admin.disputes.show',
                    $dispute
                ),
                priority: 'action',
                actor: $freelancer,
                relatedType: 'dispute',
                relatedId: $dispute->id,
                extra: [
                    'dispute_id' => $dispute->id,
                    'dispute_number' => $dispute->dispute_number,
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'category' => $dispute->category,
                    'status' => $dispute->status,
                    'opened_by_role' => $dispute->opened_by_role,
                ],
                dedupeKey:
                    'dispute_opened:admin:' .
                    $admin->id .
                    ':' .
                    $dispute->id
            );
        }

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

    /**
     * --------------------------------------------------------------------------
     * SHOW
     * --------------------------------------------------------------------------
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

    /**
     * --------------------------------------------------------------------------
     * MESSAGE
     * --------------------------------------------------------------------------
     */
    public function message(
        Request $request,
        Dispute $dispute
    ): RedirectResponse {
        $dispute->load([
            'order.client',
        ]);

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

        /**
         * ----------------------------------------------------------------------
         * Client membuka dispute → Freelancer membalas
         * → masuk tahap review Admin.
         * ----------------------------------------------------------------------
         */
        $statusChangedToReview = false;

        if (
            $dispute->opened_by_role === 'client' &&
            $dispute->opened_by !== Auth::id() &&
            $dispute->status === 'pending_response'
        ) {
            $dispute->update([
                'status' => 'under_review',
            ]);

            $statusChangedToReview = true;
        }

        /**
         * ----------------------------------------------------------------------
         * NOTIFICATION KE CLIENT
         * ----------------------------------------------------------------------
         *
         * Freelancer memberikan tanggapan terhadap dispute yang dibuka Client.
         */
        $client = $dispute->order->client;

        if (
            $client &&
            $dispute->opened_by_role === 'client'
        ) {
            app(NotificationService::class)->send(
                recipient: $client,
                event: NotificationService::DISPUTE_RESPONSE,
                title: 'Freelancer memberikan tanggapan',
                message:
                    'Freelancer telah memberikan tanggapan pada dispute "' .
                    $dispute->dispute_number .
                    '" untuk order "' .
                    $dispute->order->order_number .
                    '".',
                actionUrl: route(
                    'client.disputes.show',
                    $dispute
                ),
                priority: 'action',
                actor: Auth::user(),
                relatedType: 'dispute',
                relatedId: $dispute->id,
                extra: [
                    'dispute_id' => $dispute->id,
                    'dispute_number' => $dispute->dispute_number,
                    'order_id' => $dispute->order->id,
                    'order_number' => $dispute->order->order_number,
                    'status' => $dispute->status,
                    'status_changed_to_review' => $statusChangedToReview,
                ],
                dedupeKey:
                    'dispute_response:client:' .
                    $dispute->id .
                    ':' .
                    sha1($validated['message'])
            );
        }

        return back()->with(
            'success',
            'Tanggapan berhasil dikirim.'
        );
    }

    /**
     * --------------------------------------------------------------------------
     * EVIDENCE
     * --------------------------------------------------------------------------
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

    /**
     * --------------------------------------------------------------------------
     * PRIVATE
     * --------------------------------------------------------------------------
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
