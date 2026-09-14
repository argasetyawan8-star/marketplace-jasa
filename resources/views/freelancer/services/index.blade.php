<x-layouts.freelancer title="Jasa Saya">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <section class="rounded-[22px] border border-[#DDE9E2] bg-white p-5 sm:p-6">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                <div class="min-w-0">

                    <div class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1E9E5A]">
                        Layanan
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-[28px]">
                        Jasa Saya
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#6B7E75]">
                        Kelola layanan yang kamu tawarkan dan pastikan setiap jasa siap ditemukan
                        oleh client di marketplace JASAIN.
                    </p>

                </div>

                <a
                    href="{{ route('freelancer.services.create') }}"
                    class="inline-flex h-11 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah jasa
                </a>

            </div>

        </section>


        {{-- =========================================================
            FLASH MESSAGE
        ========================================================== --}}
        @if (session('success'))
            <div class="rounded-2xl border border-[#CDE8D8] bg-[#F0FAF4] px-4 py-3">
                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#0F6B3A]">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <p class="pt-1 text-xs leading-5 text-[#256B46]">
                        {{ session('success') }}
                    </p>

                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-red-100 bg-red-50 px-4 py-3">
                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-red-600">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>

                    <p class="pt-1 text-xs leading-5 text-red-700">
                        {{ session('error') }}
                    </p>

                </div>
            </div>
        @endif


        {{-- =========================================================
            SERVICES
        ========================================================== --}}
        <section class="overflow-hidden rounded-[22px] border border-[#DDE9E2] bg-white">

            {{-- Section Header --}}
            <div class="border-b border-[#E8EFEA] px-5 py-5 sm:px-6">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Daftar jasa
                        </h2>

                        <p class="mt-1 text-xs text-[#8A9B94]">
                            Semua layanan yang kamu buat di JASAIN.
                        </p>
                    </div>

                    <div class="flex items-center gap-2">

                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-[10px] font-semibold text-[#0F6B3A]"
                        >
                            <i class="bi bi-briefcase"></i>
                            {{ $services->count() }} jasa
                        </span>

                    </div>

                </div>

            </div>


            @forelse ($services as $service)

                @php
                    $statusConfig = match ($service->status) {
                        'published' => [
                            'label' => 'Published',
                            'class' => 'bg-[#EAF7EF] text-[#0F6B3A]',
                            'dot' => 'bg-[#1E9E5A]',
                        ],
                        'pending' => [
                            'label' => 'Pending',
                            'class' => 'bg-[#FFF7E8] text-[#9A6A12]',
                            'dot' => 'bg-[#D8A52B]',
                        ],
                        'rejected' => [
                            'label' => 'Rejected',
                            'class' => 'bg-[#FDEEEE] text-[#B42318]',
                            'dot' => 'bg-[#D64545]',
                        ],
                        'archived' => [
                            'label' => 'Archived',
                            'class' => 'bg-[#F1F4F2] text-[#677870]',
                            'dot' => 'bg-[#9AA8A2]',
                        ],
                        default => [
                            'label' => 'Draft',
                            'class' => 'bg-[#F1F4F2] text-[#677870]',
                            'dot' => 'bg-[#9AA8A2]',
                        ],
                    };
                @endphp


                <article
                    class="group border-b border-[#E9EFEB] p-5 transition last:border-b-0 hover:bg-[#FBFDFC] sm:p-6"
                >

                    <div class="flex flex-col gap-5 lg:flex-row">

                        {{-- Thumbnail --}}
                        <a
                            href="{{ route('freelancer.services.show', $service) }}"
                            class="block w-full shrink-0 overflow-hidden rounded-2xl bg-[#F2F7F4] sm:w-48 lg:w-52"
                        >
                            <div class="aspect-[16/10] w-full">

                                @if ($service->thumbnail)

                                    <img
                                        src="{{ asset('storage/' . $service->thumbnail) }}"
                                        alt="{{ $service->title }}"
                                        class="block h-full w-full object-cover transition duration-500 group-hover:scale-[1.025]"
                                    >

                                @else

                                    <div class="flex h-full w-full items-center justify-center bg-[#EAF7EF]">
                                        <div class="text-center">

                                            <div
                                                class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-[#0F6B3A]"
                                            >
                                                <i class="bi bi-briefcase text-lg"></i>
                                            </div>

                                            <p class="mt-2 text-[10px] font-medium text-[#0F6B3A]">
                                                {{ $service->category?->name ?? 'Jasa' }}
                                            </p>

                                        </div>
                                    </div>

                                @endif

                            </div>
                        </a>


                        {{-- Content --}}
                        <div class="min-w-0 flex-1">

                            {{-- Status --}}
                            <div class="flex flex-wrap items-center gap-2">

                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1.5 text-[10px] font-semibold {{ $statusConfig['class'] }}"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ $statusConfig['label'] }}
                                </span>

                                @if ($service->is_featured)
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[#F2F8F4] px-2.5 py-1.5 text-[10px] font-semibold text-[#0F6B3A]"
                                    >
                                        <i class="bi bi-stars"></i>
                                        Pilihan JASAIN
                                    </span>
                                @endif

                            </div>


                            {{-- Title --}}
                            <a
                                href="{{ route('freelancer.services.show', $service) }}"
                                class="mt-3 block"
                            >
                                <h3 class="line-clamp-2 text-base font-semibold leading-6 text-[#29483D] transition group-hover:text-[#0F6B3A] sm:text-lg">
                                    {{ $service->title }}
                                </h3>
                            </a>


                            {{-- Description --}}
                            <p class="mt-2 line-clamp-2 max-w-3xl text-sm leading-6 text-[#73857D]">
                                {{ $service->description }}
                            </p>


                            {{-- Meta --}}
                            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-[#7C8D85]">

                                <span class="inline-flex items-center gap-1.5 font-semibold text-[#123128]">
                                    Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <i class="bi bi-clock text-[#1E9E5A]"></i>
                                    {{ $service->delivery_days }} hari
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <i class="bi bi-bag-check text-[#1E9E5A]"></i>
                                    {{ $service->orders_count }} pesanan
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <i class="bi bi-star-fill text-[#1E9E5A]"></i>
                                    {{ number_format((float) $service->rating, 1) }}

                                    <span class="text-[#A0ADA7]">
                                        ({{ $service->reviews_count }})
                                    </span>
                                </span>

                            </div>


                            {{-- Bottom --}}
                            <div class="mt-5 flex flex-col gap-4 border-t border-[#EDF2EE] pt-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-center gap-2 text-[11px] text-[#8A9B94]">

                                    @if ($service->category)
                                        <span>
                                            {{ $service->category->name }}
                                        </span>
                                    @endif

                                    @if ($service->subcategory)
                                        <span class="text-[#C1CDC7]">•</span>

                                        <span>
                                            {{ $service->subcategory->name }}
                                        </span>
                                    @endif

                                </div>


                                {{-- Actions --}}
                                <div class="flex items-center gap-2">

                                    <a
                                        href="{{ route('freelancer.services.show', $service) }}"
                                        class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-[#D8E5DD] bg-white px-3.5 text-[11px] font-semibold text-[#52675D] transition hover:border-[#C3D8CB] hover:bg-[#F8FCF9] hover:text-[#0F6B3A]"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Lihat
                                    </a>

                                    <a
                                        href="{{ route('freelancer.services.edit', $service) }}"
                                        class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-[#D8E5DD] bg-white px-3.5 text-[11px] font-semibold text-[#52675D] transition hover:border-[#C3D8CB] hover:bg-[#F8FCF9] hover:text-[#0F6B3A]"
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
                                            class="inline-flex h-9 items-center justify-center rounded-xl border border-[#E5DCDC] bg-white px-3 text-[#9A7777] transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"
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

            @empty

                {{-- Empty State --}}
                <div class="px-6 py-16 text-center sm:py-20">

                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF7EF] text-[#0F6B3A]"
                    >
                        <i class="bi bi-briefcase text-2xl"></i>
                    </div>

                    <h3 class="mt-5 text-base font-semibold text-[#123128]">
                        Belum ada jasa
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#87978F]">
                        Buat jasa pertama kamu agar client dapat menemukan
                        layanan yang kamu tawarkan di marketplace JASAIN.
                    </p>

                    <a
                        href="{{ route('freelancer.services.create') }}"
                        class="mt-6 inline-flex h-11 items-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Tambah jasa
                    </a>

                </div>

            @endforelse

        </section>

    </div>

</x-layouts.freelancer>