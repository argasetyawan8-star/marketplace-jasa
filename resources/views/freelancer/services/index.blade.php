<x-layouts.freelancer title="Jasa Saya">

    <div class="mx-auto max-w-7xl space-y-6">


        {{-- =========================================================
            HEADER
        ========================================================== --}}

        <section class="rounded-[22px] border border-slate-200 bg-white p-5 sm:p-6">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                <div class="min-w-0">

                    <div class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                        Layanan
                    </div>

                    <h1 class="mt-2 text-2xl font-bold tracking-[-0.025em] text-slate-900 sm:text-[28px]">
                        Jasa Saya
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Kelola layanan yang kamu tawarkan dan pastikan setiap jasa siap ditemukan
                        oleh client di marketplace ProKerja.
                    </p>

                </div>


                <a
                    href="{{ route('freelancer.services.create') }}"
                    class="inline-flex h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white transition duration-200 hover:bg-blue-700 active:scale-[0.99]"
                >

                    <i class="bi bi-plus-lg text-xs"></i>

                    Tambah jasa

                </a>

            </div>

        </section>



        {{-- =========================================================
            FLASH MESSAGE
        ========================================================== --}}

        @if (session('success'))

            <div class="rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3">

                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm">

                        <i class="bi bi-check-circle text-sm"></i>

                    </div>

                    <p class="pt-1 text-xs leading-5 text-blue-700">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        @endif


        @if (session('error'))

            <div class="rounded-2xl border border-red-100 bg-red-50 px-4 py-3">

                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-red-600">

                        <i class="bi bi-exclamation-circle text-sm"></i>

                    </div>

                    <p class="pt-1 text-xs leading-5 text-red-700">
                        {{ session('error') }}
                    </p>

                </div>

            </div>

        @endif



        {{-- =========================================================
            SECTION TITLE
        ========================================================== --}}

        <div class="flex items-end justify-between gap-4 px-1">

            <div class="min-w-0">

                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-blue-600">
                    Layanan kamu
                </p>

                <h2 class="mt-1.5 text-[22px] font-bold tracking-[-0.025em] text-slate-900 sm:text-2xl">
                    Daftar jasa
                </h2>

                <p class="mt-1.5 text-sm leading-6 text-slate-500">
                    Semua layanan yang kamu buat di ProKerja.
                </p>

            </div>


            <span
                class="hidden shrink-0 items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-[10px] font-semibold text-blue-600 sm:inline-flex"
            >

                <i class="bi bi-briefcase"></i>

                {{ $services->count() }} jasa

            </span>

        </div>



        @if ($services->count())


            {{-- =====================================================
                MOBILE
                2 CARD / ROW
            ====================================================== --}}

            <div class="grid grid-cols-2 gap-3 sm:hidden">

                @foreach ($services as $service)

                    @php

                        $statusConfig = match ($service->status) {

                            'published' => [
                                'label' => 'Published',
                                'class' => 'bg-emerald-50 text-emerald-700',
                                'dot' => 'bg-emerald-500',
                            ],

                            'pending' => [
                                'label' => 'Pending',
                                'class' => 'bg-amber-50 text-amber-700',
                                'dot' => 'bg-amber-500',
                            ],

                            'rejected' => [
                                'label' => 'Rejected',
                                'class' => 'bg-red-50 text-red-700',
                                'dot' => 'bg-red-500',
                            ],

                            'archived' => [
                                'label' => 'Archived',
                                'class' => 'bg-slate-100 text-slate-600',
                                'dot' => 'bg-slate-400',
                            ],

                            default => [
                                'label' => 'Draft',
                                'class' => 'bg-slate-100 text-slate-600',
                                'dot' => 'bg-slate-400',
                            ],

                        };

                    @endphp


                    <article
                        class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_5px_18px_rgba(15,23,42,0.04)] transition duration-200 active:scale-[0.99]"
                    >


                        {{-- IMAGE --}}

                        <a
                            href="{{ route('freelancer.services.show', $service) }}"
                            class="block overflow-hidden bg-slate-100"
                        >

                            <div class="relative aspect-[4/3] w-full">

                                @if ($service->thumbnail)

                                    <img
                                        src="{{ asset('storage/' . $service->thumbnail) }}"
                                        alt="{{ $service->title }}"
                                        class="block h-full w-full object-cover"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center bg-blue-50">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">

                                            <i class="bi bi-briefcase text-base"></i>

                                        </div>

                                    </div>

                                @endif


                                @if ($service->is_featured)

                                    <span class="absolute left-2 top-2 inline-flex items-center gap-1 rounded-full bg-white/95 px-2 py-1 text-[8px] font-semibold text-blue-600 shadow-sm backdrop-blur">

                                        <i class="bi bi-stars text-[8px]"></i>

                                        Pilihan

                                    </span>

                                @endif

                            </div>

                        </a>



                        {{-- CONTENT --}}

                        <div class="p-3">


                            {{-- STATUS --}}

                            <span
                                class="inline-flex max-w-full items-center gap-1 rounded-full px-2 py-1 text-[8px] font-semibold {{ $statusConfig['class'] }}"
                            >

                                <span class="h-1.5 w-1.5 shrink-0 rounded-full {{ $statusConfig['dot'] }}"></span>

                                <span class="truncate">
                                    {{ $statusConfig['label'] }}
                                </span>

                            </span>



                            {{-- TITLE --}}

                            <a
                                href="{{ route('freelancer.services.show', $service) }}"
                                class="mt-2 block"
                            >

                                <h3 class="line-clamp-2 min-h-[40px] text-xs font-bold leading-5 text-slate-900">

                                    {{ $service->title }}

                                </h3>

                            </a>



                            {{-- PRICE --}}

                            <p class="mt-2 truncate text-[11px] font-bold text-slate-900">

                                Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}

                            </p>



                            {{-- RATING + DELIVERY --}}

                            <div class="mt-1.5 flex items-center gap-2 text-[8px] text-slate-400">

                                <span class="inline-flex items-center gap-1">

                                    <i class="bi bi-star-fill text-[8px] text-amber-400"></i>

                                    {{ number_format((float) $service->rating, 1) }}

                                </span>


                                <span class="text-slate-300">
                                    •
                                </span>


                                <span>
                                    {{ $service->delivery_days }} hari
                                </span>

                            </div>



                            {{-- ACTION --}}

                            <div class="mt-3 flex gap-1.5">

                                <a
                                    href="{{ route('freelancer.services.show', $service) }}"
                                    class="inline-flex h-8 min-w-0 flex-1 items-center justify-center gap-1 rounded-lg border border-slate-200 bg-white px-2 text-[8px] font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                >

                                    <i class="bi bi-eye text-[9px]"></i>

                                    Lihat

                                </a>


                                <a
                                    href="{{ route('freelancer.services.edit', $service) }}"
                                    class="inline-flex h-8 min-w-0 flex-1 items-center justify-center gap-1 rounded-lg border border-slate-200 bg-white px-2 text-[8px] font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                >

                                    <i class="bi bi-pencil text-[9px]"></i>

                                    Edit

                                </a>

                            </div>


                        </div>

                    </article>

                @endforeach

            </div>



            {{-- =====================================================
                TABLET / DESKTOP
                LIST HORIZONTAL SEPERTI DESAIN SEBELUMNYA
            ====================================================== --}}

            <section class="hidden overflow-hidden rounded-[22px] border border-slate-200 bg-white sm:block">


                @foreach ($services as $service)

                    @php

                        $statusConfig = match ($service->status) {

                            'published' => [
                                'label' => 'Published',
                                'class' => 'bg-emerald-50 text-emerald-700',
                                'dot' => 'bg-emerald-500',
                            ],

                            'pending' => [
                                'label' => 'Pending',
                                'class' => 'bg-amber-50 text-amber-700',
                                'dot' => 'bg-amber-500',
                            ],

                            'rejected' => [
                                'label' => 'Rejected',
                                'class' => 'bg-red-50 text-red-700',
                                'dot' => 'bg-red-500',
                            ],

                            'archived' => [
                                'label' => 'Archived',
                                'class' => 'bg-slate-100 text-slate-600',
                                'dot' => 'bg-slate-400',
                            ],

                            default => [
                                'label' => 'Draft',
                                'class' => 'bg-slate-100 text-slate-600',
                                'dot' => 'bg-slate-400',
                            ],

                        };

                    @endphp


                    <article
                        class="group border-b border-slate-100 p-5 transition duration-200 last:border-b-0 hover:bg-slate-50/60 sm:p-6"
                    >

                        <div class="flex flex-col gap-5 lg:flex-row">


                            {{-- =================================================
                                THUMBNAIL
                            ================================================== --}}

                            <a
                                href="{{ route('freelancer.services.show', $service) }}"
                                class="block w-full shrink-0 overflow-hidden rounded-2xl bg-slate-100 sm:w-48 lg:w-52"
                            >

                                <div class="aspect-[16/10] w-full">

                                    @if ($service->thumbnail)

                                        <img
                                            src="{{ asset('storage/' . $service->thumbnail) }}"
                                            alt="{{ $service->title }}"
                                            class="block h-full w-full object-cover transition duration-500 group-hover:scale-[1.025]"
                                        >

                                    @else

                                        <div class="flex h-full w-full items-center justify-center bg-blue-50">

                                            <div class="text-center">

                                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm">

                                                    <i class="bi bi-briefcase text-lg"></i>

                                                </div>


                                                <p class="mt-2 text-[10px] font-semibold text-blue-600">

                                                    {{ $service->category?->name ?? 'Jasa' }}

                                                </p>

                                            </div>

                                        </div>

                                    @endif

                                </div>

                            </a>



                            {{-- =================================================
                                CONTENT
                            ================================================== --}}

                            <div class="min-w-0 flex-1">


                                {{-- STATUS --}}

                                <div class="flex flex-wrap items-center gap-2">

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1.5 text-[10px] font-semibold {{ $statusConfig['class'] }}"
                                    >

                                        <span
                                            class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"
                                        ></span>

                                        {{ $statusConfig['label'] }}

                                    </span>


                                    @if ($service->is_featured)

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1.5 text-[10px] font-semibold text-blue-600"
                                        >

                                            <i class="bi bi-stars"></i>

                                            Pilihan ProKerja

                                        </span>

                                    @endif

                                </div>



                                {{-- TITLE --}}

                                <a
                                    href="{{ route('freelancer.services.show', $service) }}"
                                    class="mt-3 block"
                                >

                                    <h3
                                        class="line-clamp-2 text-base font-bold leading-6 text-slate-900 transition duration-200 group-hover:text-blue-600 sm:text-lg"
                                    >

                                        {{ $service->title }}

                                    </h3>

                                </a>



                                {{-- DESCRIPTION --}}

                                <p class="mt-2 line-clamp-2 max-w-3xl text-sm leading-6 text-slate-500">

                                    {{ $service->description }}

                                </p>



                                {{-- META --}}

                                <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-slate-400">

                                    <span class="inline-flex items-center gap-1.5 font-bold text-slate-900">

                                        Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}

                                    </span>


                                    <span class="inline-flex items-center gap-1.5">

                                        <i class="bi bi-clock text-blue-600"></i>

                                        {{ $service->delivery_days }} hari

                                    </span>


                                    <span class="inline-flex items-center gap-1.5">

                                        <i class="bi bi-bag-check text-blue-600"></i>

                                        {{ $service->orders_count }} pesanan

                                    </span>


                                    <span class="inline-flex items-center gap-1.5">

                                        <i class="bi bi-star-fill text-amber-400"></i>

                                        {{ number_format((float) $service->rating, 1) }}

                                        <span class="text-slate-300">
                                            ({{ $service->reviews_count }})
                                        </span>

                                    </span>

                                </div>



                                {{-- BOTTOM --}}

                                <div
                                    class="mt-5 flex flex-col gap-4 border-t border-slate-100 pt-4 sm:flex-row sm:items-center sm:justify-between"
                                >


                                    {{-- CATEGORY --}}

                                    <div class="flex min-w-0 items-center gap-2 text-[11px] text-slate-400">

                                        @if ($service->category)

                                            <span class="truncate">
                                                {{ $service->category->name }}
                                            </span>

                                        @endif


                                        @if ($service->subcategory)

                                            <span class="text-slate-300">
                                                •
                                            </span>

                                            <span class="truncate">
                                                {{ $service->subcategory->name }}
                                            </span>

                                        @endif

                                    </div>



                                    {{-- ACTIONS --}}

                                    <div class="flex items-center gap-2">

                                        <a
                                            href="{{ route('freelancer.services.show', $service) }}"
                                            class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 text-[11px] font-semibold text-slate-600 transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                        >

                                            <i class="bi bi-eye"></i>

                                            Lihat

                                        </a>


                                        <a
                                            href="{{ route('freelancer.services.edit', $service) }}"
                                            class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 text-[11px] font-semibold text-slate-600 transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                        >

                                            <i class="bi bi-pencil"></i>

                                            Edit

                                        </a>


                                        <form
                                            action="{{ route('freelancer.services.destroy', $service) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus jasa ini?')"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="inline-flex h-9 items-center justify-center rounded-xl border border-slate-200 bg-white px-3 text-slate-400 transition duration-200 hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                                                title="Hapus"
                                            >

                                                <i class="bi bi-trash text-xs"></i>

                                            </button>

                                        </form>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </article>

                @endforeach

            </section>


        @else


            {{-- =========================================================
                EMPTY STATE
            ========================================================== --}}

            <section class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-[0_5px_18px_rgba(15,23,42,0.03)] sm:py-20">

                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600"
                >

                    <i class="bi bi-briefcase text-2xl"></i>

                </div>


                <h3 class="mt-5 text-base font-bold text-slate-900">
                    Belum ada jasa
                </h3>


                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-400">

                    Buat jasa pertama kamu agar client dapat menemukan
                    layanan yang kamu tawarkan di marketplace ProKerja.

                </p>


                <a
                    href="{{ route('freelancer.services.create') }}"
                    class="mt-6 inline-flex h-11 items-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white transition duration-200 hover:bg-blue-700 active:scale-[0.99]"
                >

                    <i class="bi bi-plus-lg text-xs"></i>

                    Tambah jasa

                </a>

            </section>

        @endif


    </div>

</x-layouts.freelancer>