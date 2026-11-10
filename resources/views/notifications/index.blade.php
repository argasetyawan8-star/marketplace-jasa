
<x-layouts.marketplace title="Notifikasi - ProKerja">
    @php
        $notificationItems = $notifications ?? collect();

        $getNotificationValue = function ($notification, $key, $fallback = null) {
            $value = data_get($notification, $key);

            if ($value !== null && $value !== '') {
                return $value;
            }

            return $fallback;
        };

        $isReadNotification = function ($notification) {
            if (isset($notification->read_at)) {
                return $notification->read_at !== null;
            }

            if (isset($notification->is_read)) {
                return (bool) $notification->is_read;
            }

            return false;
        };

        $getNotificationExtra = function ($notification) {
            $extra = data_get($notification, 'extra', []);

            if (empty($extra)) {
                $extra = data_get($notification, 'data.extra', []);
            }

            if (is_string($extra)) {
                $decoded = json_decode($extra, true);
                $extra = is_array($decoded) ? $decoded : [];
            }

            return is_array($extra) ? $extra : [];
        };
    @endphp

    <div class="min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">

            {{-- HEADER --}}
            <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-wider text-blue-600">
                        Pusat Informasi
                    </p>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Notifikasi
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Lihat pembaruan akun, pengajuan, dan aktivitas kamu di ProKerja.
                    </p>
                </div>

                @if (Route::has('notifications.read_all'))
                    <form
                        method="POST"
                        action="{{ route('notifications.read_all') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                        >
                            Tandai semua dibaca
                        </button>
                    </form>
                @endif
            </div>

            {{-- FLASH MESSAGES --}}
            @if (session('success'))
                <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            {{-- NOTIFICATION LIST --}}
            <div class="space-y-3">
                @forelse ($notificationItems as $notification)
                    @php
                        $title = $getNotificationValue(
                            $notification,
                            'title',
                            data_get($notification, 'data.title', 'Notifikasi ProKerja')
                        );

                        $message = $getNotificationValue(
                            $notification,
                            'message',
                            data_get($notification, 'data.message', '')
                        );

                        $event = (string) $getNotificationValue(
                            $notification,
                            'event',
                            data_get($notification, 'data.event', '')
                        );

                        $priority = (string) $getNotificationValue(
                            $notification,
                            'priority',
                            data_get($notification, 'data.priority', 'info')
                        );

                        $actionUrl = $getNotificationValue(
                            $notification,
                            'action_url',
                            data_get($notification, 'data.action_url')
                        );

                        $extra = $getNotificationExtra($notification);

                        $rejectionReason = $getNotificationValue(
                            $notification,
                            'rejection_reason',
                            data_get($extra, 'rejection_reason',
                                data_get($notification, 'data.rejection_reason')
                            )
                        );

                        $isRead = $isReadNotification($notification);

                        $normalizedEvent = strtolower($event);
                        $normalizedTitle = strtolower((string) $title);

                        $isKycRejected = str_contains($normalizedEvent, 'rejected')
                            || str_contains($normalizedEvent, 'rejected')
                            || str_contains($normalizedTitle, 'ditolak');

                        $isKycReviewing = str_contains($normalizedEvent, 'reviewing')
                            || str_contains($normalizedTitle, 'sedang diperiksa');

                        $isKycNotification = $isKycRejected || $isKycReviewing
                            || str_contains($normalizedEvent, 'kyc');

                        $notificationDate = $getNotificationValue(
                            $notification,
                            'created_at',
                            data_get($notification, 'createdAt')
                        );

                        $dateLabel = null;

                        if ($notificationDate instanceof \DateTimeInterface) {
                            $dateLabel = $notificationDate->format('d M Y, H:i');
                        } elseif (is_string($notificationDate) && $notificationDate !== '') {
                            try {
                                $dateLabel = \Illuminate\Support\Carbon::parse($notificationDate)
                                    ->format('d M Y, H:i');
                            } catch (\Throwable $e) {
                                $dateLabel = null;
                            }
                        }

                        $iconClass = $isKycRejected
                            ? 'bg-red-50 text-red-600'
                            : ($isKycReviewing
                                ? 'bg-amber-50 text-amber-600'
                                : 'bg-blue-50 text-blue-600');
                    @endphp

                    <article class="overflow-hidden rounded-2xl border bg-white shadow-sm transition hover:shadow-md
                        {{ $isRead ? 'border-slate-200' : 'border-blue-200' }}">

                        <div class="flex gap-3 p-4 sm:gap-4 sm:p-5">
                            {{-- ICON --}}
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $iconClass }}">
                                @if ($isKycRejected)
                                    <span class="text-lg font-bold" aria-hidden="true">!</span>
                                @elseif ($isKycReviewing)
                                    <span class="text-lg" aria-hidden="true">&#9203;</span>
                                @else
                                    <span class="text-lg" aria-hidden="true">&#9679;</span>
                                @endif
                            </div>

                            {{-- CONTENT --}}
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="break-words text-sm font-bold text-slate-900 sm:text-base">
                                        {{ $title }}
                                    </h2>

                                    @if (! $isRead)
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-blue-700">
                                            Baru
                                        </span>
                                    @endif
                                </div>

                                @if ($message)
                                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">
                                        {{ $message }}
                                    </p>
                                @endif

                                {{-- REJECTION REASON --}}
                                @if ($isKycRejected && $rejectionReason)
                                    <div class="mt-4 rounded-xl border border-red-100 bg-red-50 p-4">
                                        <p class="text-xs font-bold uppercase tracking-wider text-red-700">
                                            Alasan penolakan
                                        </p>

                                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $rejectionReason }}</p>
                                    </div>
                                @endif

                                {{-- DATE AND PRIORITY --}}
                                <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                                    @if ($dateLabel)
                                        <span>{{ $dateLabel }}</span>
                                    @endif

                                    @if ($priority === 'action')
                                        <span class="rounded-full bg-red-50 px-2 py-1 font-semibold text-red-600">
                                            Perlu tindakan
                                        </span>
                                    @elseif ($priority === 'critical')
                                        <span class="rounded-full bg-amber-50 px-2 py-1 font-semibold text-amber-700">
                                            Penting
                                        </span>
                                    @endif
                                </div>

                                {{-- ACTIONS --}}
                                <div class="mt-4 flex flex-wrap items-center gap-2">
                                    @if ($actionUrl)
                                        @if ($isKycRejected)
                                            <a
                                                href="{{ route('freelancer.onboarding', ['step' => 1]) }}"
                                                class="inline-flex min-h-10 items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-blue-700"
                                            >
                                                Perbaiki Pengajuan
                                            </a>
                                        @elseif ($isKycReviewing)
                                            <a
                                                href="{{ route('freelancer.onboarding', ['step' => 5]) }}"
                                                class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                            >
                                                Lihat Status
                                            </a>
                                        @else
                                            <a
                                                href="{{ $actionUrl }}"
                                                class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                            >
                                                Lihat detail
                                            </a>
                                        @endif
                                    @endif

                                    @if (! $isRead && Route::has('notifications.read'))
                                        <form
                                            method="POST"
                                            action="{{ route('notifications.read', ['notification' => $notification->id]) }}"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="inline-flex min-h-10 items-center justify-center rounded-xl px-3 py-2 text-sm font-medium text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
                                            >
                                                Tandai dibaca
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-14 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl text-slate-400">
                            &#9675;
                        </div>

                        <h2 class="mt-4 font-bold text-slate-900">
                            Belum ada notifikasi
                        </h2>

                        <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                            Jika ada pembaruan pengajuan atau aktivitas akun,
                            notifikasi akan muncul di sini.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            @if (is_object($notificationItems) && method_exists($notificationItems, 'links'))
                <div class="mt-6">
                    {{ $notificationItems->links() }}
                </div>
            @endif

        </div>
    </div>
</x-layouts.marketplace>