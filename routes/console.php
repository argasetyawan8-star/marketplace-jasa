<?php

use App\Models\Order;
use App\Services\NotificationService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/*
|--------------------------------------------------------------------------
| JASAIN - Order Deadline Reminder
|--------------------------------------------------------------------------
|
| Reminder dikirim kepada Freelancer:
|
| 1. Ketika order memasuki 24 jam terakhir.
| 2. Ketika order memasuki 3 jam terakhir.
|
| Scheduler berjalan setiap 5 menit.
| Dedupe key mencegah notifikasi dikirim berkali-kali
| untuk order dan reminder window yang sama.
|
*/

Schedule::call(function () {
    $now = now();

    $orders = Order::query()
        ->with([
            'freelancerProfile.user',
        ])
        ->whereIn('status', [
            'paid',
            'in_progress',
            'revision',
        ])
        ->whereNotNull('due_at')
        ->where('due_at', '>', $now)
        ->where('due_at', '<=', $now->copy()->addHours(24))
        ->orderBy('due_at')
        ->get();

    foreach ($orders as $order) {
        $freelancerUser = $order->freelancerProfile?->user;

        if (!$freelancerUser) {
            continue;
        }

        $remainingMinutes = $now->diffInMinutes(
            $order->due_at
        );

        $remainingHours = max(
            1,
            (int) ceil($remainingMinutes / 60)
        );

        /*
         * --------------------------------------------------------------
         * Tentukan jenis reminder
         * --------------------------------------------------------------
         *
         * 3 jam terakhir memiliki prioritas lebih tinggi.
         * Order yang lebih dari 3 jam akan menggunakan reminder 24 jam.
         */
        if ($remainingMinutes <= 180) {
            $window = '3h';

            $title = 'Deadline order semakin dekat';

            $message =
                'Order ' .
                $order->order_number .
                ' memiliki batas pengerjaan sekitar ' .
                $remainingHours .
                ' jam lagi. Segera selesaikan dan kirim hasil pekerjaan.';

            $priority =
                NotificationService::PRIORITY_ACTION;
        } else {
            $window = '24h';

            $title = 'Deadline order dalam 24 jam';

            $message =
                'Order ' .
                $order->order_number .
                ' akan mencapai deadline dalam sekitar ' .
                $remainingHours .
                ' jam. Pastikan pekerjaan selesai dan segera kirim hasilnya.';

            $priority =
                NotificationService::PRIORITY_INFO;
        }

        NotificationService::send(
            recipient: $freelancerUser,

            event: NotificationService::ORDER_DEADLINE,

            title: $title,

            message: $message,

            actionUrl: route(
                'freelancer.orders.show',
                $order
            ),

            priority: $priority,

            actor: null,

            relatedType: 'order',

            relatedId: $order->id,

            extra: [
                'order_id' =>
                    $order->id,

                'order_number' =>
                    $order->order_number,

                'order_status' =>
                    $order->status,

                'due_at' =>
                    $order->due_at?->toIso8601String(),

                'remaining_hours' =>
                    $remainingHours,

                'remaining_minutes' =>
                    $remainingMinutes,

                'deadline_window' =>
                    $window,
            ],

            dedupeKey:
                'order_deadline:freelancer:' .
                $freelancerUser->id .
                ':' .
                $order->id .
                ':' .
                $window
        );
    }
})
    ->name('jasain-order-deadline-reminders')
    ->everyFiveMinutes()
    ->withoutOverlapping();
