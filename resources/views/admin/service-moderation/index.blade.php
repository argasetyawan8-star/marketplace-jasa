<x-layouts.admin title="Moderasi Jasa">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                Service Moderation
            </p>

            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                Moderasi Jasa
            </h1>

            <p class="mt-1 text-sm text-[#71837B]">
                Periksa jasa freelancer sebelum dipublikasikan ke marketplace.
            </p>
        </div>


        {{-- Flash --}}
        @if (session('success'))

            <div class="rounded-xl border border-[#CBEAD8] bg-[#EAF7EF] px-4 py-3 text-sm text-[#17663D]">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>

        @endif


        {{-- Statistics --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">

            <a
                href="{{ route('admin.service-moderation.index', ['status' => 'pending']) }}"
                class="rounded-2xl border border-[#E8DFC2] bg-[#FFFBEF] p-5 transition hover:border-[#D9C88F]"
            >
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-[#8A7130]">
                        Pending
                    </span>

                    <i class="bi bi-hourglass-split text-[#B7791F]"></i>
                </div>

                <p class="mt-3 text-2xl font-semibold text-[#5F4B14]">
                    {{ $counts['pending'] }}
                </p>
            </a>


            <a
                href="{{ route('admin.service-moderation.index', ['status' => 'published']) }}"
                class="rounded-2xl border border-[#CBEAD8] bg-[#EAF7EF] p-5 transition hover:border-[#A9DEC0]"
            >
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-[#557166]">
                        Published
                    </span>

                    <i class="bi bi-check-circle text-[#1E9E5A]"></i>
                </div>

                <p class="mt-3 text-2xl font-semibold text-[#17663D]">
                    {{ $counts['published'] }}
                </p>
            </a>


            <a
                href="{{ route('admin.service-moderation.index', ['status' => 'rejected']) }}"
                class="rounded-2xl border border-red-200 bg-red-50 p-5 transition hover:border-red-300"
            >
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-red-600">
                        Rejected
                    </span>

                    <i class="bi bi-x-circle text-red-500"></i>
                </div>

                <p class="mt-3 text-2xl font-semibold text-red-700">
                    {{ $counts['rejected'] }}
                </p>
            </a>


            <a
                href="{{ route('admin.service-moderation.index', ['status' => 'draft']) }}"
                class="rounded-2xl border border-[#DCE9E2] bg-white p-5 transition hover:border-[#BFE7CF]"
            >
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-[#667D73]">
                        Draft
                    </span>

                    <i class="bi bi-file-earmark text-[#8A9B94]"></i>
                </div>

                <p class="mt-3 text-2xl font-semibold text-[#355248]">
                    {{ $counts['draft'] }}
                </p>
            </a>


            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-5">

                <div class="flex items-center justify-between">

                    <span class="text-xs font-medium text-[#667D73]">
                        Semua Jasa
                    </span>

                    <i class="bi bi-grid text-[#8A9B94]"></i>

                </div>

                <p class="mt-3 text-2xl font-semibold text-[#355248]">
                    {{ $counts['all'] }}
                </p>

            </div>

        </div>


        {{-- Filter --}}
        <section class="rounded-2xl border border-[#DCE9E2] bg-white p-5 sm:p-6">

            <form
                method="GET"
                action="{{ route('admin.service-moderation.index') }}"
                class="grid gap-4 md:grid-cols-[minmax(0,1fr)_200px_auto]"
            >

                <div>

                    <label
                        for="search"
                        class="mb-2 block text-xs font-semibold text-[#526960]"
                    >
                        Cari jasa
                    </label>

                    <div class="relative">

                        <i
                            class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#9AA8A2]"
                        ></i>

                        <input
                            id="search"
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Judul jasa, freelancer, email..."
                            class="w-full rounded-xl border border-[#D8E6DE] bg-white py-2.5 pl-9 pr-3 text-sm text-[#355248] outline-none transition placeholder:text-[#A5B0AB] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                        >

                    </div>

                </div>


                <div>

                    <label
                        for="status"
                        class="mb-2 block text-xs font-semibold text-[#526960]"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border border-[#D8E6DE] bg-white px-3 py-2.5 text-sm text-[#355248] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#1E9E5A]/10"
                    >

                        <option value="pending" @selected($status === 'pending')}>
                            Pending
                        </option>

                        <option value="published" @selected($status === 'published')}>
                            Published
                        </option>

                        <option value="rejected" @selected($status === 'rejected')}>
                            Rejected
                        </option>

                        <option value="draft" @selected($status === 'draft')}>
                            Draft
                        </option>

                        <option value="archived" @selected($status === 'archived')}>
                            Archived
                        </option>

                        <option value="" @selected($status === null || $status === '')>
                            Semua
                        </option>

                    </select>

                </div>


                <div class="flex items-end">

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D] md:w-auto"
                    >
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>

                </div>

            </form>

        </section>


        {{-- Table --}}
        <section class="overflow-hidden rounded-2xl border border-[#DCE9E2] bg-white">

            <div class="border-b border-[#E8EFEA] px-5 py-4 sm:px-6">

                <div class="flex items-center justify-between gap-4">

                    <div>

                        <h2 class="text-sm font-semibold text-[#123128]">
                            Daftar Jasa
                        </h2>

                        <p class="mt-0.5 text-xs text-[#8A9B94]">
                            {{ $services->total() }} data ditemukan
                        </p>

                    </div>

                    <i class="bi bi-briefcase text-[#A0ADA7]"></i>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-[#F8FCF9]">

                        <tr class="border-b border-[#E8EFEA]">

                            <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9B94]">
                                Jasa
                            </th>

                            <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9B94]">
                                Freelancer
                            </th>

                            <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9B94]">
                                Kategori
                            </th>

                            <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9B94]">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right text-[10px] font-semibold uppercase tracking-[0.08em] text-[#8A9B94]">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-[#EDF2EF]">

                        @forelse ($services as $service)

                            @php

                                $freelancer =
                                    $service->freelancerProfile;

                                $freelancerUser =
                                    $freelancer?->user;

                            @endphp

                            <tr class="transition hover:bg-[#FBFDFC]">

                                {{-- Service --}}
                                <td class="min-w-[280px] px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="h-14 w-20 shrink-0 overflow-hidden rounded-lg bg-[#F3F8F5]">

                                            @if ($service->thumbnail)

                                                <img
                                                    src="{{ asset('storage/' . $service->thumbnail) }}"
                                                    alt="{{ $service->title }}"
                                                    class="h-full w-full object-cover"
                                                >

                                            @else

                                                <div class="flex h-full w-full items-center justify-center text-[#91A099]">
                                                    <i class="bi bi-image"></i>
                                                </div>

                                            @endif

                                        </div>


                                        <div class="min-w-0">

                                            <p class="line-clamp-2 text-sm font-semibold text-[#18382E]">
                                                {{ $service->title }}
                                            </p>

                                            <p class="mt-1 text-xs text-[#8A9B94]">
                                                Mulai Rp
                                                {{ number_format((float) $service->starting_price, 0, ',', '.') }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Freelancer --}}
                                <td class="px-5 py-4">
                                    <div class="min-w-[180px]">
                                        <p class="text-sm font-medium text-[#355248]">
                                            {{ $freelancerUser?->name ?? 'Freelancer' }}
                                        </p>

                                        @if ($freelancer?->username)
                                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                                {{ '@' . ltrim($freelancer->username, '@') }}
                                            </p>
                                        @endif
                                    </div>
                                </td>


                                {{-- Category --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-[130px]">

                                        <p class="text-xs font-medium text-[#526960]">
                                            {{ $service->category?->name ?? '-' }}
                                        </p>

                                        @if ($service->subcategory)

                                            <p class="mt-0.5 text-[11px] text-[#8A9B94]">
                                                {{ $service->subcategory->name }}
                                            </p>

                                        @endif

                                    </div>

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @if ($service->status === 'pending')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#FFFBEF] px-2.5 py-1.5 text-[10px] font-semibold text-[#9A6700]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#D9A441]"></span>
                                            Pending
                                        </span>

                                    @elseif ($service->status === 'published')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#EAF7EF] px-2.5 py-1.5 text-[10px] font-semibold text-[#17663D]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>
                                            Published
                                        </span>

                                    @elseif ($service->status === 'rejected')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1.5 text-[10px] font-semibold text-red-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                            Rejected
                                        </span>

                                    @elseif ($service->status === 'draft')

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 px-2.5 py-1.5 text-[10px] font-semibold text-gray-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                            Draft
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 px-2.5 py-1.5 text-[10px] font-semibold text-gray-600">
                                            {{ ucfirst($service->status) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Action --}}
                                <td class="px-5 py-4 text-right">

                                    <a
                                        href="{{ route('admin.service-moderation.show', $service) }}"
                                        class="inline-flex items-center gap-2 rounded-lg border border-[#D8E6DE] bg-white px-3.5 py-2 text-xs font-semibold text-[#526960] transition hover:border-[#BFE7CF] hover:bg-[#F8FCF9] hover:text-[#0F6B3A]"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-16 text-center"
                                >

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F3F8F5] text-[#8A9B94]">
                                        <i class="bi bi-inbox text-xl"></i>
                                    </div>

                                    <p class="mt-4 text-sm font-semibold text-[#355248]">
                                        Tidak ada jasa
                                    </p>

                                    <p class="mt-1 text-xs text-[#8A9B94]">
                                        Belum ada data yang sesuai filter.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($services->hasPages())

                <div class="border-t border-[#E8EFEA] px-5 py-4 sm:px-6">
                    {{ $services->links() }}
                </div>

            @endif

        </section>

    </div>

</x-layouts.admin>