@php
    $layout = match ($role) {
        'freelancer' => 'layouts.freelancer',
        'admin' => 'layouts.admin',
        default => 'layouts.client',
    };
@endphp

<x-dynamic-component :component="$layout" title="Notifikasi">

<div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">
    <div class="mx-auto max-w-5xl px-4 py-7 sm:px-6 lg:px-8 lg:py-9">

        @if(session('success'))
            <div class="mb-5 rounded-2xl border border-[#CDE8D7] bg-white px-4 py-3.5 shadow-[0_4px_16px_rgba(18,49,40,0.04)]">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF] text-[#1E9E5A]">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <p class="text-sm text-[#355248]">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        <section class="overflow-hidden rounded-3xl border border-[#E1EAE5] bg-white shadow-[0_8px_28px_rgba(18,49,40,0.045)]">

            <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-7">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>
                        <p class="text-[9px] font-semibold uppercase tracking-[0.18em] text-[#1E9E5A]">
                            Akun
                        </p>

                        <h1 class="mt-1 text-xl font-semibold tracking-[-0.03em] text-[#123128] sm:text-2xl">
                            Notifikasi
                        </h1>

                        <p class="mt-1.5 text-xs leading-5 text-[#71837B]">
                            Informasi penting tentang order, pembayaran, pesan, refund, dan aktivitas akunmu.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">

                        <a
                            href="{{ route('notifications.index') }}"
                            class="inline-flex h-9 items-center justify-center rounded-xl px-3 text-[10px] font-semibold transition
                                {{ $filter !== 'unread'
                                    ? 'bg-[#EAF7EF] text-[#168A4D]'
                                    : 'border border-[#DCE7E1] bg-white text-[#66766E] hover:bg-[#F5FAF7]' }}"
                        >
                            Semua
                        </a>

                        <a
                            href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                            class="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl px-3 text-[10px] font-semibold transition
                                {{ $filter === 'unread'
                                    ? 'bg-[#EAF7EF] text-[#168A4D]'
                                    : 'border border-[#DCE7E1] bg-white text-[#66766E] hover:bg-[#F5FAF7]' }}"
                        >
                            Belum dibaca

                            @if($unreadCount > 0)
                                <span class="rounded-full bg-[#1E9E5A] px-1.5 py-0.5 text-[8px] text-white">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                            @endif
                        </a>

                        @if($unreadCount > 0)
                            <form
                                action="{{ route('notifications.read_all') }}"
                                method="POST"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="inline-flex h-9 items-center justify-center rounded-xl border border-[#DCE7E1] bg-white px-3 text-[10px] font-semibold text-[#66766E] transition hover:bg-[#F5FAF7] hover:text-[#1E9E5A]"
                                >
                                    Tandai semua dibaca
                                </button>
                            </form>
                        @endif

                    </div>

                </div>
            </div>

            <div class="divide-y divide-[#EDF2EF]">

                @forelse($notifications as $notification)

                    @php
                        $data = $notification->data ?? [];

                        $title = $data['title'] ?? 'Notifikasi JASAIN';
                        $message = $data['message'] ?? 'Ada aktivitas baru pada akunmu.';
                        $event = $data['event'] ?? null;
                        $priority = $data['priority'] ?? 'normal';
                        $icon = $data['icon'] ?? 'bi-bell';
                        $actionUrl = $data['action_url'] ?? null;

                        $iconClass = match($priority) {
                            'critical' => 'bg-[#FFF1F1] text-[#C65353]',
                            'action' => 'bg-[#FFF9EA] text-[#B7791F]',
                            'info' => 'bg-[#EEF5FF] text-[#315A91]',
                            default => 'bg-[#EAF7EF] text-[#1E9E5A]',
                        };

                        $isUnread = is_null($notification->read_at);
                    @endphp

                    <div class="px-5 py-5 sm:px-7 {{ $isUnread ? 'bg-[#FBFEFC]' : 'bg-white' }}">

                        <div class="flex items-start gap-3.5">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $iconClass }}">
                                <i class="bi {{ $icon }} text-[15px]"></i>
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                    <div class="min-w-0">

                                        <div class="flex flex-wrap items-center gap-2">

                                            <h2 class="text-sm font-semibold text-[#18382E]">
                                                {{ $title }}
                                            </h2>

                                            @if($isUnread)
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-2 py-1 text-[8px] font-semibold text-[#168A4D]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#35C978]"></span>
                                                    Baru
                                                </span>
                                            @endif

                                        </div>

                                        <p class="mt-1.5 max-w-3xl text-xs leading-5 text-[#6E8178]">
                                            {{ $message }}
                                        </p>

                                    </div>

                                    <span class="shrink-0 text-[9px] text-[#A0ADA7]">
                                        {{ $notification->created_at?->diffForHumans() }}
                                    </span>

                                </div>

                                <div class="mt-3 flex flex-wrap items-center gap-2">

                                    @if($event)
                                        <span class="rounded-full bg-[#F4F7F5] px-2 py-1 text-[8px] font-medium text-[#84938C]">
                                            {{ $event }}
                                        </span>
                                    @endif

                                    @if($actionUrl)

                                        <form
                                            action="{{ route('notifications.read', $notification->id) }}"
                                            method="POST"
                                            class="inline-flex"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="inline-flex h-8 items-center gap-1.5 rounded-lg bg-[#F8FCF9] px-3 text-[9px] font-semibold text-[#1E9E5A] transition hover:bg-[#EAF7EF]"
                                            >
                                                Lihat detail
                                                <i class="bi bi-arrow-right text-[9px]"></i>
                                            </button>
                                        </form>

                                    @elseif($isUnread)

                                        <form
                                            action="{{ route('notifications.read', $notification->id) }}"
                                            method="POST"
                                            class="inline-flex"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="inline-flex h-8 items-center rounded-lg bg-[#F8FCF9] px-3 text-[9px] font-semibold text-[#62766D] transition hover:bg-[#EEF5F1]"
                                            >
                                                Tandai dibaca
                                            </button>
                                        </form>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="px-5 py-16 text-center sm:px-7">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#1E9E5A]">
                            <i class="bi bi-bell-slash text-xl"></i>
                        </div>

                        <h2 class="mt-4 text-sm font-semibold text-[#18382E]">
                            Belum ada notifikasi
                        </h2>

                        <p class="mt-1.5 text-xs leading-5 text-[#8B9992]">
                            Notifikasi penting akan muncul di sini ketika ada aktivitas pada akunmu.
                        </p>

                    </div>

                @endforelse

            </div>

            @if($notifications->hasPages())

                <div class="border-t border-[#E8EFEB] px-5 py-4 sm:px-7">
                    {{ $notifications->onEachSide(1)->links() }}
                </div>

            @endif

        </section>

    </div>
</div>

</x-dynamic-component>