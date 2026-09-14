<x-layouts.freelancer title="Detail Jasa">

    <div class="mx-auto max-w-6xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a
                    href="{{ route('freelancer.services.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#667D73] transition hover:text-[#0F6B3A]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Jasa Saya
                </a>

                <div class="mt-4">
                    <h1 class="text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Detail Jasa
                    </h1>

                    <p class="mt-1 text-sm text-[#71837B]">
                        Lihat informasi lengkap dari jasa yang kamu tawarkan.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('freelancer.services.edit', $service) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
            >
                <i class="bi bi-pencil"></i>
                Edit Jasa
            </a>
        </div>

        {{-- Success --}}
        @if(session('success'))
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

        {{-- Main Card --}}
        <div class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white">

            {{-- Thumbnail --}}
            <div class="relative h-72 bg-[#F3F8F5] sm:h-[400px]">
                @if($service->thumbnail)
                    <img
                        src="{{ asset('storage/' . $service->thumbnail) }}"
                        alt="{{ $service->title }}"
                        class="h-full w-full object-cover"
                    >
                @else
                    <div class="flex h-full flex-col items-center justify-center text-[#90A39A]">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white">
                            <i class="bi bi-image text-3xl"></i>
                        </div>

                        <p class="mt-3 text-sm font-medium">
                            Belum ada thumbnail
                        </p>
                    </div>
                @endif

                {{-- Status --}}
                <div class="absolute left-4 top-4 flex flex-wrap gap-2 sm:left-6 sm:top-6">

                    @if($service->status === 'published')
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#17663D]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>
                            Published
                        </span>
                    @elseif($service->status === 'pending')
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#9A6700]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#D9A441]"></span>
                            Pending
                        </span>
                    @elseif($service->status === 'rejected')
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#B42318]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#D92D20]"></span>
                            Rejected
                        </span>
                    @elseif($service->status === 'archived')
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#667D73]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#94A3A0]"></span>
                            Archived
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#667D73]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#94A3A0]"></span>
                            Draft
                        </span>
                    @endif

                    @if($service->is_featured)
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#123128] px-3 py-1.5 text-xs font-semibold text-white">
                            <i class="bi bi-star-fill text-[10px]"></i>
                            Featured
                        </span>
                    @endif

                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 sm:p-8">

                {{-- Category --}}
                @if($service->category || $service->subcategory)
                    <div class="flex flex-wrap gap-2">
                        @if($service->category)
                            <span class="inline-flex items-center gap-2 rounded-lg bg-[#F3F8F5] px-3 py-1.5 text-xs font-medium text-[#667D73]">
                                <i class="bi bi-folder2"></i>
                                {{ $service->category->name }}
                            </span>
                        @endif

                        @if($service->subcategory)
                            <span class="inline-flex items-center gap-2 rounded-lg bg-[#EAF7EF] px-3 py-1.5 text-xs font-semibold text-[#17663D]">
                                <i class="bi bi-tag"></i>
                                {{ $service->subcategory->name }}
                            </span>
                        @endif
                    </div>
                @endif

                {{-- Title --}}
                <h2 class="mt-5 max-w-4xl text-2xl font-semibold leading-tight text-[#123128] sm:text-3xl">
                    {{ $service->title }}
                </h2>

                {{-- Stats --}}
                <div class="mt-7 grid grid-cols-2 gap-4 lg:grid-cols-4">

                    {{-- Price --}}
                    <div class="rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] p-4">
                        <div class="flex items-center gap-2 text-xs font-medium text-[#557166]">
                            <i class="bi bi-wallet2 text-[#1E9E5A]"></i>
                            Harga mulai
                        </div>

                        <p class="mt-2 text-lg font-semibold text-[#123128]">
                            Rp {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Delivery --}}
                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4">
                        <div class="flex items-center gap-2 text-xs font-medium text-[#71837B]">
                            <i class="bi bi-clock text-[#1E9E5A]"></i>
                            Pengerjaan
                        </div>

                        <p class="mt-2 text-lg font-semibold text-[#123128]">
                            {{ $service->delivery_days }} hari
                        </p>
                    </div>

                    {{-- Orders --}}
                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4">
                        <div class="flex items-center gap-2 text-xs font-medium text-[#71837B]">
                            <i class="bi bi-bag-check text-[#1E9E5A]"></i>
                            Pesanan
                        </div>

                        <p class="mt-2 text-lg font-semibold text-[#123128]">
                            {{ $service->orders_count }}
                        </p>
                    </div>

                    {{-- Rating --}}
                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4">
                        <div class="flex items-center gap-2 text-xs font-medium text-[#71837B]">
                            <i class="bi bi-star text-[#1E9E5A]"></i>
                            Rating
                        </div>

                        <p class="mt-2 text-lg font-semibold text-[#123128]">
                            {{ number_format((float) $service->rating, 1) }}
                        </p>
                    </div>

                </div>

                {{-- Description --}}
                <div class="mt-8 rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-5 sm:p-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-file-text"></i>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-[#123128]">
                                Deskripsi Jasa
                            </h3>

                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                Detail layanan yang kamu tawarkan
                            </p>
                        </div>
                    </div>

                    <p class="mt-5 whitespace-pre-line text-sm leading-7 text-[#5F7169]">
                        {{ $service->description }}
                    </p>
                </div>

                {{-- Category --}}
                <div class="mt-4 rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-5 sm:p-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-[#123128]">
                                Kategori Jasa
                            </h3>

                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                Pengelompokan layanan
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">

                        @if($service->category)
                            <span class="inline-flex items-center gap-2 rounded-lg border border-[#DDEAE2] bg-white px-3.5 py-2 text-sm font-medium text-[#526960]">
                                <i class="bi bi-folder text-[#1E9E5A]"></i>
                                {{ $service->category->name }}
                            </span>
                        @endif

                        @if($service->subcategory)
                            <span class="inline-flex items-center gap-2 rounded-lg border border-[#BFE7CF] bg-[#EAF7EF] px-3.5 py-2 text-sm font-medium text-[#17663D]">
                                <i class="bi bi-tag"></i>
                                {{ $service->subcategory->name }}
                            </span>
                        @endif

                        @if(!$service->category && !$service->subcategory)
                            <span class="text-sm text-[#8A9B94]">
                                Kategori belum ditentukan.
                            </span>
                        @endif

                    </div>
                </div>

                {{-- Bottom Actions --}}
                <div class="mt-8 flex flex-col-reverse gap-3 border-t border-[#E7EFEA] pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('freelancer.services.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E8DF] bg-white px-5 py-2.5 text-sm font-semibold text-[#526960] transition hover:bg-[#F8FCF9] hover:text-[#123128]"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <a
                        href="{{ route('freelancer.services.edit', $service) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                    >
                        <i class="bi bi-pencil"></i>
                        Edit Jasa
                    </a>

                </div>

            </div>
        </div>

    </div>

</x-layouts.freelancer>