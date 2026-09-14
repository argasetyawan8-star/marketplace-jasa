@php
    $user = auth()->user();

    $freelancerProfile = $user?->freelancerProfile;
@endphp

{{-- Mobile Overlay --}}
<div
    x-show="sidebarOpen"
    x-transition.opacity
    @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-black/30 lg:hidden"
></div>


{{-- Sidebar --}}
<aside
    class="fixed inset-y-0 left-0 z-50 w-64 transform border-r border-gray-200 bg-white transition-transform duration-300 lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>

    <div class="flex h-full flex-col">

        {{-- Logo --}}
        <div class="flex h-20 items-center border-b border-gray-100 px-6">

            <a
                href="{{ route('freelancer.dashboard') }}"
                class="flex items-center gap-3"
            >

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-500">

                    <span class="text-lg font-semibold text-white">
                        J
                    </span>

                </div>


                <div>

                    <div class="text-lg font-semibold text-gray-900">
                        JASAIN
                    </div>

                    <div class="text-xs text-gray-400">
                        Freelancer
                    </div>

                </div>

            </a>

        </div>


        {{-- Navigation --}}
        <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6">

            <p class="mb-3 px-3 text-xs font-medium uppercase tracking-wider text-gray-400">
                Menu
            </p>


            {{-- Dashboard --}}
            <a
                href="{{ route('freelancer.dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('freelancer.dashboard')
                        ? 'bg-green-50 text-green-700'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >

                <i class="bi bi-grid text-lg"></i>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- Jasa --}}
            <a
                href="{{ route('freelancer.services.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('freelancer.services.*')
                        ? 'bg-green-50 text-green-700'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >

                <i class="bi bi-briefcase text-lg"></i>

                <span>
                    Jasa Saya
                </span>

            </a>


            {{-- Pesanan --}}
            <a
                href="{{ route('freelancer.orders.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('freelancer.orders.*')
                        ? 'bg-green-50 text-green-700'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >

                <i class="bi bi-bag-check text-lg"></i>

                <span>
                    Pesanan
                </span>

            </a>


            {{-- Pesan --}}
            <a
                href="{{ route('freelancer.messages.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('freelancer.messages.*')
                        ? 'bg-green-50 text-green-700'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >

                <i class="bi bi-chat-dots text-lg"></i>

                <span>
                    Pesan
                </span>

            </a>


            {{-- Dompet --}}
            <a
                href="{{ route('freelancer.wallet.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('freelancer.wallet.*')
                        ? 'bg-green-50 text-green-700'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >

                <i class="bi bi-wallet2 text-lg"></i>

                <span>
                    Dompet
                </span>

            </a>


            {{-- Penarikan --}}
            <a
                href="{{ route('freelancer.withdrawals.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('freelancer.withdrawals.*')
                        ? 'bg-green-50 text-green-700'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >

                <i class="bi bi-bank text-lg"></i>

                <span>
                    Penarikan
                </span>

            </a>


            {{-- Akun --}}
            <div class="pt-6">

                <p class="mb-3 px-3 text-xs font-medium uppercase tracking-wider text-gray-400">
                    Akun
                </p>


                {{-- Profil --}}
                <a
                    href="{{ route('freelancer.profile.show') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('freelancer.profile.*')
                            ? 'bg-green-50 text-green-700'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                >

                    <i class="bi bi-person text-lg"></i>

                    <span>
                        Profil
                    </span>

                </a>


                {{-- Beranda --}}
                <a
                    href="{{ route('marketplace.home') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900"
                >

                    <i class="bi bi-house text-lg"></i>

                    <span>
                        Beranda
                    </span>

                </a>

            </div>

        </nav>


        {{-- User Sidebar --}}
        <div class="border-t border-gray-100 p-4">

            <div class="flex items-center gap-3 px-2">

                {{-- Avatar --}}
                <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full bg-green-100">

                    @if ($freelancerProfile?->avatar)

                        <img
                            src="{{ asset('storage/' . $freelancerProfile->avatar) }}"
                            alt="{{ $user->name }}"
                            class="block h-full w-full object-cover"
                        >

                    @else

                        <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-green-700">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                    @endif

                </div>


                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-medium text-gray-900">
                        {{ $user->name }}
                    </p>

                    <p class="truncate text-xs text-gray-400">
                        {{ $user->email }}
                    </p>

                </div>

            </div>


            {{-- Logout --}}
            <form
                method="POST"
                action="{{ route('logout') }}"
                class="mt-3"
            >

                @csrf

                <button
                    type="submit"
                    class="flex w-full items-center gap-3 rounded-xl px-2.5 py-2.5 text-sm text-gray-600 transition hover:bg-red-50 hover:text-red-600"
                >

                    <i class="bi bi-box-arrow-right text-lg"></i>

                    <span>
                        Keluar
                    </span>

                </button>

            </form>

        </div>

    </div>

</aside>