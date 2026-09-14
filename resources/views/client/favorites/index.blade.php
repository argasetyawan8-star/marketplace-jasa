<x-layouts.client title="Favorit">

    <div class="min-h-screen bg-[#F8FCF9]">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">


            {{-- =========================================================
                HEADER
            ========================================================== --}}
            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <div class="flex items-center gap-2">

                        <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>

                        <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                            Koleksi kamu
                        </p>

                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-[-0.03em] text-[#123128] sm:text-[28px]">
                        Favorit
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-[#7B8C84]">
                        Simpan jasa yang menarik dan kembali kapan saja saat kamu siap menggunakannya.
                    </p>

                </div>


                <a
                    href="{{ route('marketplace.search') }}"
                    class="inline-flex h-10 w-fit shrink-0 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-4 text-xs font-semibold text-white shadow-[0_5px_15px_rgba(30,158,90,0.12)] transition duration-200 hover:bg-[#0F6B3A]"
                >
                    <i class="bi bi-search text-[12px]"></i>
                    Cari jasa
                </a>

            </div>


            {{-- =========================================================
                SUCCESS MESSAGE
            ========================================================== --}}
            @if(session('success'))

                <div class="mt-6 overflow-hidden rounded-xl border border-[#CDE8D7] bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF]">
                            <i class="bi bi-check-lg text-sm text-[#1E9E5A]"></i>
                        </div>

                        <p class="text-sm text-[#355248]">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                FAVORITES
            ========================================================== --}}
            @if($favorites->count())

                <div class="mt-8">


                    {{-- Collection Header --}}
                    <div class="mb-5 flex items-center justify-between">

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128]">
                                Jasa tersimpan
                            </h2>

                            <p class="mt-0.5 text-[10px] text-[#8A9992]">
                                {{ $favorites->count() }} jasa di halaman ini
                            </p>

                        </div>


                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#1E9E5A]">
                            <i class="bi bi-heart-fill text-[12px]"></i>
                        </div>

                    </div>


                    {{-- Cards --}}
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                        @foreach($favorites as $favorite)

                            @php
                                $service = $favorite->service;

                                $freelancer = $service?->freelancerProfile;

                                $freelancerUser = $freelancer?->user;

                                $freelancerName =
                                    $freelancerUser?->name
                                    ?? 'Freelancer';

                                $freelancerInitial = strtoupper(
                                    substr($freelancerName, 0, 1)
                                );
                            @endphp


                            @if($service)

                                <article
                                    class="group overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_5px_18px_rgba(18,49,40,0.035)] transition duration-200 hover:-translate-y-0.5 hover:border-[#CFE3D6] hover:shadow-[0_12px_30px_rgba(18,49,40,0.07)]"
                                >


                                    {{-- =================================================
                                        THUMBNAIL
                                    ================================================== --}}
                                    <a
                                        href="{{ route('marketplace.service', $service->slug) }}"
                                        class="block"
                                    >

                                        <div class="relative aspect-[16/10] overflow-hidden bg-[#EAF7EF]">

                                            @if($service->thumbnail)

                                                <img
                                                    src="{{ asset('storage/' . $service->thumbnail) }}"
                                                    alt="{{ $service->title }}"
                                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.035]"
                                                >

                                            @else

                                                <div class="flex h-full w-full items-center justify-center">

                                                    <div class="text-center">

                                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-[#1E9E5A] shadow-sm">

                                                            <i class="bi bi-briefcase text-lg"></i>

                                                        </div>

                                                        <p class="mt-2 text-[10px] font-medium text-[#1E9E5A]">
                                                            {{ $service->category?->name ?? 'Jasa' }}
                                                        </p>

                                                    </div>

                                                </div>

                                            @endif


                                            {{-- Favorite marker --}}
                                            <div class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-white/95 text-[#1E9E5A] shadow-sm backdrop-blur-sm">

                                                <i class="bi bi-heart-fill text-[12px]"></i>

                                            </div>

                                        </div>

                                    </a>



                                    {{-- =================================================
                                        CONTENT
                                    ================================================== --}}
                                    <div class="p-4.5">


                                        {{-- Freelancer --}}
                                        @if($freelancer && $freelancerUser)

                                            <a
                                                href="{{ route('marketplace.freelancer', $freelancer->username) }}"
                                                class="group/freelancer flex items-center gap-2.5"
                                            >

                                                <div class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF]">

                                                    @if($freelancer->avatar)

                                                        <img
                                                            src="{{ asset('storage/' . $freelancer->avatar) }}"
                                                            alt="{{ $freelancerName }}"
                                                            class="h-full w-full object-cover"
                                                        >

                                                    @else

                                                        <span class="text-[10px] font-semibold text-[#1E9E5A]">
                                                            {{ $freelancerInitial }}
                                                        </span>

                                                    @endif

                                                </div>


                                                <div class="min-w-0">

                                                    <p class="truncate text-[10px] font-semibold text-[#355248] transition group-hover/freelancer:text-[#1E9E5A]">
                                                        {{ $freelancerName }}
                                                    </p>

                                                    <p class="truncate text-[9px] text-[#99A59F]">
                                                        {{ '@' . $freelancer->username }}
                                                    </p>

                                                </div>

                                            </a>

                                        @endif


                                        {{-- Service title --}}
                                        <a
                                            href="{{ route('marketplace.service', $service->slug) }}"
                                            class="block"
                                        >

                                            <h2 class="mt-4 min-h-[48px] line-clamp-2 text-sm font-semibold leading-6 tracking-[-0.01em] text-[#18382E] transition duration-200 group-hover:text-[#0F6B3A]">
                                                {{ $service->title }}
                                            </h2>

                                        </a>


                                        {{-- Rating --}}
                                        <div class="mt-3 flex items-center gap-2">

                                            <div class="flex items-center gap-1 text-[10px] text-[#D59A20]">

                                                <i class="bi bi-star-fill"></i>

                                                <span class="font-semibold">
                                                    {{ number_format((float) $service->rating, 1) }}
                                                </span>

                                            </div>

                                            <span class="h-1 w-1 rounded-full bg-[#CBD5D0]"></span>

                                            <span class="text-[10px] text-[#8B9992]">
                                                {{ number_format($service->reviews_count) }} ulasan
                                            </span>

                                        </div>


                                        {{-- Category --}}
                                        @if($service->category)

                                            <div class="mt-3">

                                                <span class="inline-flex items-center rounded-md bg-[#F3F8F5] px-2 py-1 text-[9px] font-medium text-[#6D8177]">
                                                    {{ $service->category->name }}
                                                </span>

                                            </div>

                                        @endif


                                        {{-- Divider --}}
                                        <div class="my-4 border-t border-[#EDF2EF]"></div>


                                        {{-- Footer --}}
                                        <div class="flex items-end justify-between gap-3">

                                            <div class="min-w-0">

                                                <p class="text-[9px] uppercase tracking-[0.12em] text-[#99A59F]">
                                                    Mulai dari
                                                </p>

                                                <p class="mt-1 text-[15px] font-semibold tracking-[-0.02em] text-[#123128]">
                                                    Rp{{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                                </p>

                                            </div>


                                            <form
                                                action="{{ route('client.favorites.destroy', $service) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-[#A0ADA7] transition duration-200 hover:bg-red-50 hover:text-red-500"
                                                    title="Hapus dari favorit"
                                                    aria-label="Hapus dari favorit"
                                                >
                                                    <i class="bi bi-heart-fill text-[12px]"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </article>

                            @endif

                        @endforeach

                    </div>


                    {{-- =========================================================
                        PAGINATION
                    ========================================================== --}}
                    @if($favorites->hasPages())

                        <div class="mt-8 border-t border-[#E5ECE8] pt-6">

                            {{ $favorites->links() }}

                        </div>

                    @endif

                </div>


            @else

                {{-- =========================================================
                    EMPTY STATE
                ========================================================== --}}
                <div class="mt-8 overflow-hidden rounded-3xl border border-[#E1EAE5] bg-white shadow-[0_8px_30px_rgba(18,49,40,0.04)]">

                    <div class="relative px-6 py-16 text-center sm:px-10 sm:py-20">

                        {{-- Decorative --}}
                        <div class="pointer-events-none absolute inset-0 overflow-hidden">

                            <div class="absolute left-1/2 top-8 h-36 w-36 -translate-x-1/2 rounded-full bg-[#EAF7EF] opacity-60 blur-3xl"></div>

                        </div>


                        <div class="relative">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-[#D8EBDD] bg-[#F3FAF5] text-[#1E9E5A] shadow-sm">

                                <i class="bi bi-heart text-[23px]"></i>

                            </div>


                            <p class="mt-6 text-[9px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                                Koleksi kosong
                            </p>


                            <h2 class="mt-2 text-xl font-semibold tracking-[-0.025em] text-[#123128]">
                                Belum ada jasa favorit
                            </h2>


                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#7B8C84]">
                                Temukan jasa yang kamu suka dan simpan ke favorit
                                agar bisa kamu pertimbangkan kembali nanti.
                            </p>


                            <a
                                href="{{ route('marketplace.search') }}"
                                class="mt-7 inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-xs font-semibold text-white shadow-[0_5px_18px_rgba(30,158,90,0.15)] transition duration-200 hover:bg-[#0F6B3A]"
                            >
                                <i class="bi bi-search text-[12px]"></i>
                                Jelajahi jasa
                                <i class="bi bi-arrow-right text-[11px]"></i>
                            </a>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-layouts.client>