<x-layouts.admin title="Detail Pengguna">

    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Back --}}
        <a
            href="{{ route('admin.users.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#0F6B3A] dark:text-[#9CB0A5] dark:hover:text-[#7AD8B5]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Pengguna
        </a>

        {{-- Profile Header --}}
        <div class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white transition-colors dark:border-[#263B31] dark:bg-[#111F18]">

            <div class="h-32 bg-[#EAF7EF] dark:bg-[#173B29] sm:h-40"></div>

            <div class="px-6 pb-6 sm:px-7">

                {{-- Avatar --}}
                <div class="-mt-12">
                    <div class="flex h-24 w-24 items-center justify-center rounded-2xl border-4 border-white bg-[#D9F3E3] text-3xl font-semibold text-[#0F6B3A] dark:border-[#111F18] dark:bg-[#1C402C] dark:text-[#7AD8B5]">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                    <div>
                        <div class="flex flex-wrap items-center gap-2">

                            <h1 class="text-2xl font-semibold tracking-tight text-[#123128] dark:text-[#E7F2EC]">
                                {{ $user->name }}
                            </h1>

                            @if($user->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#173B29] px-2.5 py-1.5 text-xs font-semibold text-[#7AD8B5]">
                                    <i class="bi bi-shield-check"></i>
                                    Admin
                                </span>
                            @elseif($user->role === 'freelancer')
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#EAF7EF] px-2.5 py-1.5 text-xs font-semibold text-[#17663D] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                                    <i class="bi bi-briefcase"></i>
                                    Freelancer
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#F3F8F5] px-2.5 py-1.5 text-xs font-semibold text-[#667D73] dark:bg-[#1A2B22] dark:text-[#B3C4BC]">
                                    <i class="bi bi-person"></i>
                                    Client
                                </span>
                            @endif

                        </div>

                        <p class="mt-1 text-sm text-[#8A9B94] dark:text-[#71877B]">
                            {{ $user->email }}
                        </p>
                    </div>

                    @if($user->email_verified_at)
                        <span class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-[#EAF7EF] px-3 py-2 text-xs font-semibold text-[#17663D] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                            <i class="bi bi-check-circle-fill"></i>
                            Email Terverifikasi
                        </span>
                    @else
                        <span class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-[#FFF7E6] px-3 py-2 text-xs font-semibold text-[#9A6700]">
                            <i class="bi bi-clock"></i>
                            Belum Terverifikasi
                        </span>
                    @endif

                </div>

            </div>
        </div>

        {{-- Information --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Account --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 transition-colors dark:border-[#263B31] dark:bg-[#111F18]">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                        <i class="bi bi-person-vcard"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            Informasi Akun
                        </h2>

                        <p class="mt-0.5 text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Data dasar pengguna.
                        </p>
                    </div>

                </div>

                <div class="mt-5 space-y-4">

                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                        <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Nama
                        </p>

                        <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            {{ $user->name }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                        <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Email
                        </p>

                        <p class="mt-1 break-all text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                        <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Role
                        </p>

                        <p class="mt-1 text-sm font-semibold capitalize text-[#123128] dark:text-[#E7F2EC]">
                            {{ $user->role }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                        <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Bergabung
                        </p>

                        <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            {{ $user->created_at?->format('d M Y H:i') ?? '-' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Profile --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 transition-colors dark:border-[#263B31] dark:bg-[#111F18]">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                        <i class="bi bi-info-circle"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            Informasi Profil
                        </h2>

                        <p class="mt-0.5 text-xs text-[#8A9B94] dark:text-[#71877B]">
                            Data tambahan pengguna.
                        </p>
                    </div>

                </div>

                @if($user->role === 'freelancer' && $user->freelancerProfile)

                    <div class="mt-5 space-y-4">

                        <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                            <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                                Username Freelancer
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                {{ '@' . $user->freelancerProfile->username }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                            <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                                Headline
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                {{ $user->freelancerProfile->headline ?: 'Belum diisi' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                            <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                                Lokasi
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                {{ $user->freelancerProfile->location ?: 'Belum diisi' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">

                            <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                                <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                                    Pesanan Selesai
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                    {{ number_format($user->freelancerProfile->completed_orders) }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                                <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                                    Rating
                                </p>

                                <p class="mt-1 text-lg font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                    {{ number_format((float) $user->freelancerProfile->rating, 2) }}
                                </p>
                            </div>

                        </div>

                    </div>

                @elseif($user->profile)

                    <div class="mt-5 space-y-4">

                        <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                            <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                                Lokasi
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                {{ $user->profile->location ?: 'Belum diisi' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4 dark:border-[#2B4337] dark:bg-[#16251D]">
                            <p class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                                Bio
                            </p>

                            <p class="mt-1 whitespace-pre-line text-sm leading-6 text-[#526960] dark:text-[#B3C4BC]">
                                {{ $user->profile->bio ?: 'Belum diisi' }}
                            </p>
                        </div>

                    </div>

                @else

                    <div class="mt-5 rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] p-8 text-center dark:border-[#2B4337] dark:bg-[#16251D]">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-[#8A9B94] dark:bg-[#1B2C23] dark:text-[#71877B]">
                            <i class="bi bi-person text-xl"></i>
                        </div>

                        <p class="mt-3 text-sm text-[#8A9B94] dark:text-[#71877B]">
                            Belum ada informasi profil tambahan.
                        </p>
                    </div>

                @endif

            </div>

        </div>

        {{-- Freelancer Services --}}
        @if($user->role === 'freelancer' && $user->freelancerProfile)

            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 transition-colors dark:border-[#263B31] dark:bg-[#111F18]">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A] dark:bg-[#173B29] dark:text-[#7AD8B5]">
                        <i class="bi bi-briefcase"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128] dark:text-[#E7F2EC]">
                            Jasa Freelancer
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94] dark:text-[#71877B]">
                            Jasa yang dimiliki oleh freelancer ini.
                        </p>
                    </div>

                </div>

                @if($user->freelancerProfile->services->count())

                    <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">

                        @foreach($user->freelancerProfile->services as $service)

                            <div class="overflow-hidden rounded-xl border border-[#DCE9E2] dark:border-[#2B4337]">

                                <div class="aspect-[16/9] bg-[#F3F8F5] dark:bg-[#16251D]">

                                    @if($service->thumbnail)

                                        <img
                                            src="{{ asset('storage/' . $service->thumbnail) }}"
                                            alt="{{ $service->title }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-full items-center justify-center text-[#94A3A0]">
                                            <i class="bi bi-image text-3xl"></i>
                                        </div>

                                    @endif

                                </div>

                                <div class="p-4">

                                    <div class="flex items-start justify-between gap-3">
                                        <h3 class="line-clamp-2 text-sm font-semibold text-[#123128] dark:text-[#E7F2EC]">
                                            {{ $service->title }}
                                        </h3>
                                    </div>

                                    <div class="mt-4 flex items-center justify-between gap-3">

                                        <span class="text-sm font-semibold text-[#0F6B3A] dark:text-[#7AD8B5]">
                                            Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                        </span>

                                        <span class="text-xs text-[#8A9B94] dark:text-[#71877B]">
                                            {{ $service->delivery_days }} hari
                                        </span>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="mt-5 rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] p-8 text-center dark:border-[#2B4337] dark:bg-[#16251D]">
                        <p class="text-sm text-[#8A9B94] dark:text-[#71877B]">
                            Freelancer ini belum memiliki jasa.
                        </p>
                    </div>

                @endif

            </div>

        @endif

    </div>

</x-layouts.admin>