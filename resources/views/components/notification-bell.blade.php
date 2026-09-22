@php
    $user = auth()->user();

    $unreadCount = $user
        ? $user->unreadNotifications()->count()
        : 0;

    $recentNotifications = $user
        ? $user->notifications()->latest()->limit(5)->get()
        : collect();

    $notificationTarget = route('notifications.index');
@endphp

@if($user)

    <div
        class="relative"
        x-data="{ open: false }"
        @keydown.escape.window="open = false"
    >

        <button
            type="button"
            class="relative flex h-9 w-9 items-center justify-center rounded-full text-current/80 transition hover:bg-current/5 hover:text-current"
            title="Notifikasi"
            aria-label="Notifikasi"
            @click="open = !open"
        >
            <i class="bi bi-bell text-[15px]"></i>

            @if($unreadCount > 0)
                <span class="absolute right-0.5 top-0.5 flex min-h-[16px] min-w-[16px] items-center justify-center rounded-full bg-[#E5484D] px-1 text-[8px] font-bold leading-none text-white ring-2 ring-white">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
        </button>

        <div
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 translate-y-1 scale-[0.98]"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-1 scale-[0.98]"
            @click.outside="open = false"
            class="absolute right-0 z-50 mt-3 w-[min(360px,calc(100vw-2rem))] overflow-hidden rounded-2xl border border-[#DCE7E1] bg-white shadow-[0_18px_50px_rgba(18,49,40,0.12)]"
        >

            <div class="flex items-center justify-between border-b border-[#EDF2EF] px-4 py-3.5">

                <div>
                    <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                        Akun
                    </p>

                    <p class="mt-0.5 text-sm font-semibold text-[#18382E]">
                        Notifikasi
                    </p>
                </div>

                @if($unreadCount > 0)
                    <form
                        action="{{ route('notifications.read_all') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="text-[9px] font-semibold text-[#66766E] transition hover:text-[#1E9E5A]"
                        >
                            Tandai semua
                        </button>
                    </form>
                @endif

            </div>

            <div class="max-h-[390px] overflow-y-auto">

                @forelse($recentNotifications as $notification)

                    @php
                        $data = $notification->data ?? [];

                        $title = $data['title'] ?? 'Notifikasi JASAIN';
                        $message = $data['message'] ?? 'Ada aktivitas baru.';
                        $icon = $data['icon'] ?? 'bi-bell';
                        $actionUrl = $data['action_url'] ?? route('notifications.index');
                        $isUnread = is_null($notification->read_at);
                    @endphp

                    <form
                        action="{{ route('notifications.read', $notification->id) }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="block w-full border-b border-[#F0F4F2] px-4 py-3.5 text-left transition hover:bg-[#F8FCF9]"
                        >
                            <div class="flex items-start gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#1E9E5A]">
                                    <i class="bi {{ $icon }} text-[13px]"></i>
                                </div>

                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-2">
                                        <p class="truncate text-[11px] font-semibold text-[#18382E]">
                                            {{ $title }}
                                        </p>

                                        @if($isUnread)
                                            <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-[#1E9E5A]"></span>
                                        @endif
                                    </div>

                                    <p class="mt-1 line-clamp-2 text-[10px] leading-4 text-[#819089]">
                                        {{ $message }}
                                    </p>

                                    <p class="mt-1.5 text-[8px] text-[#A2AEA8]">
                                        {{ $notification->created_at?->diffForHumans() }}
                                    </p>

                                </div>

                            </div>
                        </button>
                    </form>

                @empty

                    <div class="px-5 py-8 text-center">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-[#F3F7F5] text-[#9AA7A1]">
                            <i class="bi bi-bell-slash"></i>
                        </div>

                        <p class="mt-3 text-[10px] font-medium text-[#71837B]">
                            Belum ada notifikasi.
                        </p>
                    </div>

                @endforelse

            </div>

            <div class="border-t border-[#EDF2EF] bg-[#FBFDFC] p-3">

                <a
                    href="{{ $notificationTarget }}"
                    class="flex h-9 items-center justify-center gap-2 rounded-xl bg-white text-[10px] font-semibold text-[#52685F] transition hover:bg-[#EAF7EF] hover:text-[#1E9E5A]"
                >
                    Lihat semua notifikasi
                    <i class="bi bi-arrow-right text-[9px]"></i>
                </a>

            </div>

        </div>

    </div>

@endif
