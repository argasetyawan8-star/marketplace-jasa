<x-layouts.freelancer title="Profil Freelancer">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] px-4 py-3.5 text-sm text-[#17663D]">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>
                    <p class="font-semibold">
                        Berhasil
                    </p>

                    <p class="mt-0.5 text-[#557166]">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                        <i class="bi bi-person-badge"></i>
                        Profil Freelancer
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Profil Freelancer
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#71837B]">
                        Kelola informasi dan tampilan profil freelancer kamu.
                    </p>
                </div>

                <a
                    href="{{ route('freelancer.profile.edit') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                >
                    <i class="bi bi-pencil"></i>
                    Edit Profil
                </a>

            </div>
        </div>

        {{-- Profile Card --}}
        <div class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white">

            {{-- Cover --}}
            <div class="relative h-56 bg-[#EAF7EF] sm:h-72">

                @if ($freelancerProfile->cover_image)

                    <img
                        src="{{ asset('storage/' . $freelancerProfile->cover_image) }}"
                        alt="Cover {{ $freelancerProfile->username }}"
                        class="block h-full w-full object-cover"
                    >

                @else

                    <div class="flex h-full items-center justify-center bg-[#EAF7EF]">
                        <div class="text-center">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-[#0F6B3A]">
                                <i class="bi bi-person-badge text-2xl"></i>
                            </div>

                            <p class="mt-3 text-sm font-medium text-[#17663D]">
                                Profil Freelancer
                            </p>

                        </div>
                    </div>

                @endif

                {{-- Cover Label --}}
                <div class="absolute left-5 top-5">
                    <span class="inline-flex items-center gap-2 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#526960]">
                        <i class="bi bi-image text-[#1E9E5A]"></i>
                        Profil
                    </span>
                </div>

            </div>

            {{-- Profile Info --}}
            <div class="relative px-6 pb-6 sm:px-8">

                {{-- Avatar --}}
                <div class="-mt-16">
                    <div class="h-32 w-32 shrink-0 overflow-hidden rounded-full border-4 border-white bg-[#EAF7EF]">

                        @if ($freelancerProfile->avatar)

                            <img
                                src="{{ asset('storage/' . $freelancerProfile->avatar) }}"
                                alt="{{ $user->name }}"
                                class="block h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center">
                                <span class="text-4xl font-semibold text-[#0F6B3A]">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>

                        @endif

                    </div>
                </div>

                {{-- Name / Action --}}
                <div class="mt-5 flex flex-col justify-between gap-5 lg:flex-row lg:items-start">

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            <h2 class="text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                                {{ $user->name }}
                            </h2>

                            @if ($freelancerProfile->is_verified)
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#EAF7EF] px-3 py-1.5 text-xs font-semibold text-[#17663D]">
                                    <i class="bi bi-patch-check-fill"></i>
                                    Terverifikasi
                                </span>
                            @endif

                        </div>

                        <p class="mt-1 text-sm font-medium text-[#71837B]">
                            {{ '@' . $freelancerProfile->username }}
                        </p>

                        @if ($freelancerProfile->headline)
                            <p class="mt-3 max-w-2xl text-base leading-6 text-[#526960]">
                                {{ $freelancerProfile->headline }}
                            </p>
                        @endif

                    </div>

                    <div class="flex flex-wrap items-center gap-3">

                        @if ($freelancerProfile->is_available)

                            <span class="inline-flex items-center gap-2 rounded-xl bg-[#EAF7EF] px-3.5 py-2 text-sm font-semibold text-[#17663D]">
                                <span class="h-2 w-2 rounded-full bg-[#1E9E5A]"></span>
                                Tersedia
                            </span>

                        @else

                            <span class="inline-flex items-center gap-2 rounded-xl bg-[#F3F5F4] px-3.5 py-2 text-sm font-semibold text-[#667D73]">
                                <span class="h-2 w-2 rounded-full bg-[#94A3A0]"></span>
                                Tidak tersedia
                            </span>

                        @endif

                        <a
                            href="{{ route('freelancer.profile.edit') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E5DE] bg-white px-4 py-2.5 text-sm font-semibold text-[#526960] transition hover:bg-[#F8FCF9] hover:text-[#123128]"
                        >
                            <i class="bi bi-pencil"></i>
                            Edit Profil
                        </a>

                    </div>

                </div>

                {{-- Statistics --}}
                <div class="mt-7 grid grid-cols-2 gap-4 md:grid-cols-4">

                    {{-- Completed Orders --}}
                    <div class="rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4">
                        <div class="flex items-center gap-2 text-xs font-medium text-[#71837B]">
                            <i class="bi bi-check2-circle text-[#1E9E5A]"></i>
                            Pesanan Selesai
                        </div>

                        <p class="mt-2 text-xl font-semibold text-[#123128]">
                            {{ number_format($freelancerProfile->completed_orders) }}
                        </p>
                    </div>

                    {{-- Rating --}}
                    <div class="rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4">
                        <div class="flex items-center gap-2 text-xs font-medium text-[#71837B]">
                            <i class="bi bi-star-fill text-[#D9A441]"></i>
                            Rating
                        </div>

                        <p class="mt-2 text-xl font-semibold text-[#123128]">
                            {{ number_format($freelancerProfile->rating, 2) }}
                        </p>
                    </div>

                    {{-- Services --}}
                    <div class="rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4">
                        <div class="flex items-center gap-2 text-xs font-medium text-[#71837B]">
                            <i class="bi bi-briefcase text-[#1E9E5A]"></i>
                            Jumlah Jasa
                        </div>

                        <p class="mt-2 text-xl font-semibold text-[#123128]">
                            {{ $freelancerProfile->services->count() }}
                        </p>
                    </div>

                    {{-- Status --}}
                    <div class="rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4">
                        <div class="flex items-center gap-2 text-xs font-medium text-[#71837B]">
                            <i class="bi bi-circle-fill text-[#1E9E5A] text-[8px]"></i>
                            Status
                        </div>

                        <p class="mt-2 text-xl font-semibold text-[#123128]">
                            {{ $freelancerProfile->is_available ? 'Aktif' : 'Offline' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

        {{-- Main Information --}}
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- About --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 lg:col-span-2">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-[#123128]">
                            Tentang Saya
                        </h3>

                        <p class="mt-0.5 text-xs text-[#8A9B94]">
                            Informasi singkat mengenai kamu sebagai freelancer.
                        </p>
                    </div>

                </div>

                @if ($freelancerProfile->bio)

                    <div class="mt-5 rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-5">
                        <p class="whitespace-pre-line text-sm leading-7 text-[#5F7169]">
                            {{ $freelancerProfile->bio }}
                        </p>
                    </div>

                @else

                    <div class="mt-5 rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] p-8 text-center">

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-[#8A9B94]">
                            <i class="bi bi-file-text text-xl"></i>
                        </div>

                        <p class="mt-3 text-sm text-[#8A9B94]">
                            Kamu belum menambahkan deskripsi profil.
                        </p>

                    </div>

                @endif

            </div>

            {{-- Information --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-info-circle"></i>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-[#123128]">
                            Informasi
                        </h3>

                        <p class="mt-0.5 text-xs text-[#8A9B94]">
                            Informasi kontak freelancer.
                        </p>
                    </div>

                </div>

                <div class="mt-5 space-y-4">

                    {{-- Location --}}
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F3F8F5] text-[#0F6B3A]">
                            <i class="bi bi-geo-alt"></i>
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs text-[#8A9B94]">
                                Lokasi
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#345047]">
                                {{ $freelancerProfile->location ?: 'Belum diisi' }}
                            </p>
                        </div>

                    </div>

                    {{-- Email --}}
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F3F8F5] text-[#0F6B3A]">
                            <i class="bi bi-envelope"></i>
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs text-[#8A9B94]">
                                Email
                            </p>

                            <p class="mt-1 truncate text-sm font-medium text-[#345047]">
                                {{ $user->email }}
                            </p>
                        </div>

                    </div>

                    {{-- Website --}}
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F3F8F5] text-[#0F6B3A]">
                            <i class="bi bi-globe2"></i>
                        </div>

                        <div class="min-w-0">

                            <p class="text-xs text-[#8A9B94]">
                                Website
                            </p>

                            @if ($freelancerProfile->website)

                                <a
                                    href="{{ $freelancerProfile->website }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-1 block truncate text-sm font-medium text-[#0F6B3A] transition hover:text-[#0B542D]"
                                >
                                    {{ $freelancerProfile->website }}
                                </a>

                            @else

                                <p class="mt-1 text-sm font-medium text-[#345047]">
                                    Belum diisi
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Services --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-briefcase"></i>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-[#123128]">
                            Jasa Saya
                        </h3>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Jasa yang sedang kamu tawarkan di marketplace.
                        </p>
                    </div>

                </div>

                <a
                    href="{{ route('freelancer.services.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#0F6B3A] transition hover:text-[#0B542D]"
                >
                    Kelola Jasa
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

            @if ($freelancerProfile->services->count())

                <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">

                    @foreach ($freelancerProfile->services as $service)

                        <div class="group overflow-hidden rounded-xl border border-[#DCE9E2] bg-white transition hover:border-[#BFE7CF] hover:bg-[#FBFDFC]">

                            {{-- Thumbnail --}}
                            <div class="aspect-[16/9] bg-[#F3F8F5]">

                                @if ($service->thumbnail)

                                    <img
                                        src="{{ asset('storage/' . $service->thumbnail) }}"
                                        alt="{{ $service->title }}"
                                        class="block h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]"
                                    >

                                @else

                                    <div class="flex h-full items-center justify-center text-[#94A3A0]">
                                        <i class="bi bi-image text-3xl"></i>
                                    </div>

                                @endif

                            </div>

                            {{-- Content --}}
                            <div class="p-4">

                                <h4 class="line-clamp-2 text-sm font-semibold leading-5 text-[#123128]">
                                    {{ $service->title }}
                                </h4>

                                <div class="mt-4 flex items-center justify-between gap-3">

                                    <span class="text-sm font-semibold text-[#0F6B3A]">
                                        Mulai Rp {{ number_format($service->starting_price, 0, ',', '.') }}
                                    </span>

                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-[#8A9B94]">
                                        <i class="bi bi-clock"></i>
                                        {{ $service->delivery_days }} hari
                                    </span>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="mt-6 rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] p-10 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-briefcase text-2xl"></i>
                    </div>

                    <p class="mt-4 text-sm font-medium text-[#526960]">
                        Belum ada jasa yang dipublikasikan.
                    </p>

                    <p class="mt-1 text-xs text-[#8A9B94]">
                        Tambahkan jasa agar client dapat menemukan layanan kamu.
                    </p>

                    <a
                        href="{{ route('freelancer.services.create') }}"
                        class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Tambah Jasa
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-layouts.freelancer>