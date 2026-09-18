<x-layouts.admin title="Detail Moderasi Jasa">

    <div class="mx-auto max-w-6xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <a
                    href="{{ route('admin.service-moderation.index') }}"
                    class="inline-flex items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Moderasi Jasa
                </a>

                <div class="mt-4">

                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                        Service Moderation
                    </p>

                    <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Detail Jasa
                    </h1>

                    <p class="mt-1 text-sm text-[#71837B]">
                        Periksa informasi jasa sebelum menentukan keputusan.
                    </p>

                </div>

            </div>


            {{-- Status --}}
            <div>

                @if ($service->status === 'pending')

                    <span class="inline-flex items-center gap-2 rounded-xl bg-[#FFFBEF] px-4 py-2.5 text-xs font-semibold text-[#9A6700]">
                        <span class="h-2 w-2 rounded-full bg-[#D9A441]"></span>
                        Menunggu Review
                    </span>

                @elseif ($service->status === 'published')

                    <span class="inline-flex items-center gap-2 rounded-xl bg-[#EAF7EF] px-4 py-2.5 text-xs font-semibold text-[#17663D]">
                        <span class="h-2 w-2 rounded-full bg-[#1E9E5A]"></span>
                        Published
                    </span>

                @elseif ($service->status === 'rejected')

                    <span class="inline-flex items-center gap-2 rounded-xl bg-red-50 px-4 py-2.5 text-xs font-semibold text-red-700">
                        <span class="h-2 w-2 rounded-full bg-red-500"></span>
                        Rejected
                    </span>

                @else

                    <span class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-4 py-2.5 text-xs font-semibold text-gray-600">
                        {{ ucfirst($service->status) }}
                    </span>

                @endif

            </div>

        </div>


        {{-- Flash --}}
        @if (session('success'))

            <div class="rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] px-4 py-3.5 text-sm text-[#17663D]">

                <div class="flex items-center gap-3">

                    <i class="bi bi-check-circle"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            </div>

        @endif


        {{-- Errors --}}
        @if ($errors->any())

            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">

                <div class="flex items-start gap-3">

                    <i class="bi bi-exclamation-circle mt-0.5"></i>

                    <div>

                        <p class="font-semibold">
                            Ada yang perlu diperbaiki
                        </p>

                        <ul class="mt-2 space-y-1 text-xs">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- Main --}}
        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_330px]">

            {{-- Left --}}
            <div class="space-y-6">

                {{-- Thumbnail + info --}}
                <section class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white">

                    <div class="aspect-[16/8] bg-[#F3F8F5]">

                        @if ($service->thumbnail)

                            <img
                                src="{{ asset('storage/' . $service->thumbnail) }}"
                                alt="{{ $service->title }}"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full items-center justify-center text-[#91A099]">

                                <div class="text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white">
                                        <i class="bi bi-image text-2xl"></i>
                                    </div>

                                    <p class="mt-3 text-xs font-medium">
                                        Tidak ada thumbnail
                                    </p>

                                </div>

                            </div>

                        @endif

                    </div>


                    <div class="p-6 sm:p-7">

                        <div class="flex flex-wrap gap-2">

                            @if ($service->category)

                                <span class="inline-flex items-center gap-2 rounded-lg bg-[#F3F8F5] px-3 py-1.5 text-xs font-medium text-[#667D73]">
                                    <i class="bi bi-folder2"></i>
                                    {{ $service->category->name }}
                                </span>

                            @endif

                            @if ($service->subcategory)

                                <span class="inline-flex items-center gap-2 rounded-lg bg-[#EAF7EF] px-3 py-1.5 text-xs font-semibold text-[#17663D]">
                                    <i class="bi bi-tag"></i>
                                    {{ $service->subcategory->name }}
                                </span>

                            @endif

                        </div>


                        <h2 class="mt-5 text-2xl font-semibold leading-tight text-[#123128] sm:text-3xl">
                            {{ $service->title }}
                        </h2>


                        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">

                            <div class="rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] p-4">

                                <p class="text-[10px] font-medium text-[#557166]">
                                    Harga mulai
                                </p>

                                <p class="mt-2 text-base font-semibold text-[#123128]">
                                    Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                </p>

                            </div>


                            <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4">

                                <p class="text-[10px] font-medium text-[#71837B]">
                                    Pengerjaan
                                </p>

                                <p class="mt-2 text-base font-semibold text-[#123128]">
                                    {{ $service->delivery_days }} hari
                                </p>

                            </div>


                            <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4">

                                <p class="text-[10px] font-medium text-[#71837B]">
                                    Rating
                                </p>

                                <p class="mt-2 text-base font-semibold text-[#123128]">
                                    {{ number_format((float) $service->rating, 1) }}
                                </p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- Description --}}
                <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-file-text"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128]">
                                Deskripsi Jasa
                            </h2>

                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                Isi layanan yang ditawarkan freelancer
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 rounded-xl bg-[#F8FCF9] px-4 py-4">

                        <p class="whitespace-pre-line text-sm leading-7 text-[#5F7169]">
                            {{ $service->description }}
                        </p>

                    </div>

                </section>


                {{-- Moderation information --}}
                <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F3F8F5] text-[#0F6B3A]">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128]">
                                Informasi Moderasi
                            </h2>

                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                Riwayat pengajuan jasa
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 space-y-4">

                        <div class="flex items-center justify-between gap-4">

                            <span class="text-xs text-[#71837B]">
                                Diajukan
                            </span>

                            <span class="text-right text-xs font-medium text-[#355248]">
                                {{ $service->submitted_at?->format('d M Y, H:i') ?? '-' }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-4">

                            <span class="text-xs text-[#71837B]">
                                Direview
                            </span>

                            <span class="text-right text-xs font-medium text-[#355248]">
                                {{ $service->reviewed_at?->format('d M Y, H:i') ?? '-' }}
                            </span>

                        </div>


                        <div class="flex items-center justify-between gap-4">

                            <span class="text-xs text-[#71837B]">
                                Reviewer
                            </span>

                            <span class="text-right text-xs font-medium text-[#355248]">
                                {{ $service->reviewer?->name ?? '-' }}
                            </span>

                        </div>

                    </div>


                    @if ($service->rejection_reason)

                        <div class="mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-4">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-red-500">
                                Alasan Penolakan
                            </p>

                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-red-800">
                                {{ $service->rejection_reason }}
                            </p>

                        </div>

                    @endif

                </section>

            </div>


            {{-- Right --}}
            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">

                {{-- Freelancer --}}
                @php
                    $freelancer = $service->freelancerProfile;
                    $freelancerUser = $freelancer?->user;
                    $freelancerName = $freelancerUser?->name ?? 'Freelancer';
                @endphp

                <section class="rounded-2xl border border-[#DCE9E2] bg-white p-5">

                    <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                        Freelancer
                    </p>

                    <div class="mt-4 flex items-center gap-3">

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] text-sm font-semibold text-[#1E9E5A]">

                            @if ($freelancer?->avatar)

                                <img
                                    src="{{ asset('storage/' . $freelancer->avatar) }}"
                                    alt="{{ $freelancerName }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                {{ strtoupper(substr($freelancerName, 0, 1)) }}

                            @endif

                        </div>


                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-[#18382E]">
                                {{ $freelancerName }}
                            </p>

                            @if ($freelancer?->username)
                                <p class="mt-0.5 truncate text-xs text-[#8A9B94]">
                                    {{ '@' . ltrim($freelancer->username, '@') }}
                                </p>
                            @endif

                            @if ($freelancer?->is_verified)
                                <span class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-[#EAF7EF] px-2.5 py-1 text-[10px] font-semibold text-[#17663D]">
                                    <i class="bi bi-patch-check-fill"></i>
                                    Terverifikasi
                                </span>
                            @endif
                        </div>

                    </div>


                    @if ($freelancer?->headline)

                        <p class="mt-4 text-xs leading-5 text-[#71837B]">
                            {{ $freelancer->headline }}
                        </p>

                    @endif

                </section>


                {{-- Decision --}}
                @if ($service->status === 'pending')

                    <section class="rounded-2xl border border-[#DCE9E2] bg-white p-5">

                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                            Keputusan Admin
                        </p>

                        <h2 class="mt-1 text-sm font-semibold text-[#123128]">
                            Review jasa
                        </h2>

                        {{-- Publish --}}
                        <form
                            method="POST"
                            action="{{ route('admin.service-moderation.publish', $service) }}"
                            class="mt-5"
                        >

                            @csrf

                            <button
                                type="submit"
                                onclick="return confirm('Publikasikan jasa ini ke marketplace?')"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                            >
                                <i class="bi bi-check-circle"></i>
                                Publikasikan Jasa
                            </button>

                        </form>


                        {{-- Reject --}}
                        <div class="my-5 border-t border-[#E8EFEA]"></div>

                        <form
                            method="POST"
                            action="{{ route('admin.service-moderation.reject', $service) }}"
                            class="space-y-4"
                        >

                            @csrf

                            <div>

                                <label
                                    for="rejection_reason"
                                    class="mb-2 block text-xs font-semibold text-[#526960]"
                                >
                                    Alasan penolakan
                                </label>

                                <textarea
                                    id="rejection_reason"
                                    name="rejection_reason"
                                    rows="5"
                                    placeholder="Jelaskan bagian yang perlu diperbaiki freelancer..."
                                    class="w-full rounded-xl border border-[#D8E6DE] bg-white px-3 py-3 text-sm text-[#355248] outline-none transition placeholder:text-[#A5B0AB] focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                >{{ old('rejection_reason') }}</textarea>

                                <p class="mt-1.5 text-[10px] text-[#8A9B94]">
                                    Minimal 10 karakter.
                                </p>

                            </div>

                            <button
                                type="submit"
                                onclick="return confirm('Tolak pengajuan jasa ini?')"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-100"
                            >
                                <i class="bi bi-x-circle"></i>
                                Tolak Jasa
                            </button>

                        </form>

                    </section>

                @else

                    <section class="rounded-2xl border border-[#DCE9E2] bg-[#F8FCF9] p-5">

                        <div class="flex items-start gap-3">

                            <i class="bi bi-info-circle mt-0.5 text-[#1E9E5A]"></i>

                            <div>

                                <p class="text-xs font-semibold text-[#355248]">
                                    Tidak ada tindakan
                                </p>

                                <p class="mt-1 text-xs leading-5 text-[#8A9B94]">
                                    Jasa ini sudah diproses dan tidak dapat
                                    dipublikasikan atau ditolak kembali melalui
                                    moderasi.
                                </p>

                            </div>

                        </div>

                    </section>

                @endif


                {{-- Public preview --}}
                @if ($service->status === 'published')

                    <a
                        href="{{ route('marketplace.service', $service->slug) }}"
                        target="_blank"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#D8E6DE] bg-white px-4 py-3 text-sm font-semibold text-[#526960] transition hover:bg-[#F8FCF9] hover:text-[#0F6B3A]"
                    >
                        <i class="bi bi-box-arrow-up-right"></i>
                        Lihat di Marketplace
                    </a>

                @endif

            </aside>

        </div>

    </div>

</x-layouts.admin>