<x-layouts.admin title="CMS Banner">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.16em] text-[#2563EB]">
                    <i class="bi bi-images"></i>
                    Content Management
                </div>

                <h1 class="text-2xl font-semibold tracking-tight text-[#0F172A] sm:text-3xl">
                    CMS Banner
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#64748B]">
                    Kelola banner homepage ProKerja untuk berbagai posisi tampilan.
                </p>
            </div>

            <a
                href="{{ route('admin.banners.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-[#1D4ED8] hover:shadow-md"
            >
                <i class="bi bi-plus-lg"></i>
                Tambah Banner
            </a>

        </div>


        {{-- FLASH MESSAGE --}}
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-2xl border border-[#BBF7D0] bg-[#F0FDF4] p-4 text-sm text-[#166534]">
                <i class="bi bi-check-circle-fill mt-0.5 shrink-0"></i>

                <span>
                    {{ session('success') }}
                </span>
            </div>
        @endif


        {{-- STATISTICS --}}
        <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">

            {{-- TOTAL --}}
            <div class="rounded-2xl border border-[#E2E8F0] bg-white p-4 shadow-sm sm:p-5">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-xs font-medium text-[#64748B] sm:text-sm">
                        Total Banner
                    </span>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                        <i class="bi bi-images"></i>
                    </div>
                </div>

                <p class="mt-4 text-2xl font-semibold text-[#0F172A]">
                    {{ $banners->total() }}
                </p>
            </div>

            {{-- HERO --}}
            <div class="rounded-2xl border border-[#E2E8F0] bg-white p-4 shadow-sm sm:p-5">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-xs font-medium text-[#64748B] sm:text-sm">
                        Hero
                    </span>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                        <i class="bi bi-display"></i>
                    </div>
                </div>

                <p class="mt-4 text-2xl font-semibold text-[#0F172A]">
                    {{ $heroCount }}
                </p>
            </div>

            {{-- MIDDLE --}}
            <div class="rounded-2xl border border-[#E2E8F0] bg-white p-4 shadow-sm sm:p-5">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-xs font-medium text-[#64748B] sm:text-sm">
                        Middle
                    </span>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                        <i class="bi bi-layout-text-window"></i>
                    </div>
                </div>

                <p class="mt-4 text-2xl font-semibold text-[#0F172A]">
                    {{ $middleCount }}
                </p>
            </div>

            {{-- ACTIVE --}}
            <div class="rounded-2xl border border-[#E2E8F0] bg-white p-4 shadow-sm sm:p-5">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-xs font-medium text-[#64748B] sm:text-sm">
                        Aktif
                    </span>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F0FDF4] text-[#16A34A]">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>

                <p class="mt-4 text-2xl font-semibold text-[#0F172A]">
                    {{ $activeCount }}
                </p>
            </div>

        </div>


        {{-- DESKTOP TABLE --}}
        <div class="hidden overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm lg:block">

            <div class="border-b border-[#E2E8F0] px-5 py-5">
                <h2 class="text-base font-semibold text-[#0F172A]">
                    Daftar Banner
                </h2>

                <p class="mt-1 text-xs leading-5 text-[#64748B]">
                    Banner ditampilkan berdasarkan posisi, urutan, status, dan jadwal tayang.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full text-left text-sm">

                    <thead class="border-b border-[#E2E8F0] bg-[#F8FAFC]">
                        <tr>
                            <th class="px-5 py-4 font-semibold text-[#64748B]">
                                Banner
                            </th>

                            <th class="px-5 py-4 font-semibold text-[#64748B]">
                                Posisi
                            </th>

                            <th class="px-5 py-4 font-semibold text-[#64748B]">
                                Urutan
                            </th>

                            <th class="px-5 py-4 font-semibold text-[#64748B]">
                                Status
                            </th>

                            <th class="px-5 py-4 font-semibold text-[#64748B]">
                                Jadwal
                            </th>

                            <th class="px-5 py-4 text-right font-semibold text-[#64748B]">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#E2E8F0]">

                        @forelse ($banners as $banner)

                            @php
                                $placementText = match ($banner->placement) {
                                    'hero' => 'Hero',
                                    'middle' => 'Middle',
                                    'bottom' => 'Bottom',
                                    default => ucfirst($banner->placement),
                                };
                            @endphp

                            <tr class="transition hover:bg-[#F8FAFC]">

                                {{-- BANNER --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-4">

                                        <div class="h-16 w-28 shrink-0 overflow-hidden rounded-xl bg-[#EFF6FF]">
                                            <img
                                                src="{{ $banner->image_url }}"
                                                alt="{{ $banner->alt_text ?: $banner->name }}"
                                                class="h-full w-full object-cover"
                                            >
                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-[#0F172A]">
                                                {{ $banner->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-[#94A3B8]">
                                                {{ $banner->mobile_image_path ? 'Desktop + Mobile' : 'Desktop saja' }}
                                            </p>
                                        </div>

                                    </div>
                                </td>


                                {{-- PLACEMENT --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full bg-[#EFF6FF] px-3 py-1 text-xs font-semibold text-[#2563EB]">
                                        {{ $placementText }}
                                    </span>
                                </td>


                                {{-- SORT --}}
                                <td class="px-5 py-4 font-medium text-[#64748B]">
                                    {{ $banner->sort_order }}
                                </td>


                                {{-- STATUS --}}
                                <td class="px-5 py-4">
                                    <form
                                        action="{{ route('admin.banners.status', $banner) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold transition {{ $banner->is_active ? 'bg-[#F0FDF4] text-[#166534] hover:bg-[#DCFCE7]' : 'bg-[#F1F5F9] text-[#64748B] hover:bg-[#E2E8F0]' }}"
                                            title="{{ $banner->is_active ? 'Nonaktifkan banner' : 'Aktifkan banner' }}"
                                        >
                                            <span class="h-1.5 w-1.5 rounded-full {{ $banner->is_active ? 'bg-[#16A34A]' : 'bg-[#94A3B8]' }}"></span>
                                            {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td>


                                {{-- SCHEDULE --}}
                                <td class="px-5 py-4">

                                    <div class="space-y-0.5 text-xs leading-5 text-[#64748B]">

                                        @if ($banner->starts_at)
                                            <div>
                                                Mulai:
                                                {{ $banner->starts_at->format('d M Y H:i') }}
                                            </div>
                                        @endif

                                        @if ($banner->ends_at)
                                            <div>
                                                Selesai:
                                                {{ $banner->ends_at->format('d M Y H:i') }}
                                            </div>
                                        @endif

                                        @if (!$banner->starts_at && !$banner->ends_at)
                                            <span>
                                                Selalu tayang
                                            </span>
                                        @endif

                                    </div>

                                </td>


                                {{-- ACTION --}}
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.banners.edit', $banner) }}"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#E2E8F0] text-[#2563EB] transition hover:bg-[#EFF6FF]"
                                            title="Edit"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.banners.destroy', $banner) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus banner ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#FECACA] text-[#DC2626] transition hover:bg-[#FEF2F2]"
                                                title="Hapus"
                                            >
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EFF6FF] text-[#2563EB]">
                                        <i class="bi bi-images text-2xl"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-[#0F172A]">
                                        Belum ada banner
                                    </h3>

                                    <p class="mt-1 text-xs text-[#64748B]">
                                        Tambahkan banner pertama untuk homepage ProKerja.
                                    </p>

                                    <a
                                        href="{{ route('admin.banners.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#2563EB] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#1D4ED8]"
                                    >
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Banner
                                    </a>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- MOBILE CARDS --}}
        <div class="space-y-3 lg:hidden">

            @forelse ($banners as $banner)

                @php
                    $placementText = match ($banner->placement) {
                        'hero' => 'Hero',
                        'middle' => 'Middle',
                        'bottom' => 'Bottom',
                        default => ucfirst($banner->placement),
                    };
                @endphp

                <article class="overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm">

                    <div class="relative aspect-[16/7] overflow-hidden bg-[#EFF6FF]">
                        <img
                            src="{{ $banner->image_url }}"
                            alt="{{ $banner->alt_text ?: $banner->name }}"
                            class="h-full w-full object-cover"
                        >

                        <div class="absolute left-3 top-3">
                            <span class="inline-flex rounded-full bg-white/95 px-3 py-1 text-[11px] font-semibold text-[#2563EB] shadow-sm">
                                {{ $placementText }}
                            </span>
                        </div>

                    </div>


                    <div class="p-4">

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">
                                <h3 class="truncate text-sm font-semibold text-[#0F172A]">
                                    {{ $banner->name }}
                                </h3>

                                <p class="mt-1 text-xs text-[#94A3B8]">
                                    {{ $banner->mobile_image_path ? 'Desktop + Mobile' : 'Desktop saja' }}
                                </p>
                            </div>

                            <form
                                action="{{ route('admin.banners.status', $banner) }}"
                                method="POST"
                                class="shrink-0"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1.5 text-[11px] font-semibold {{ $banner->is_active ? 'bg-[#F0FDF4] text-[#166534]' : 'bg-[#F1F5F9] text-[#64748B]' }}"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full {{ $banner->is_active ? 'bg-[#16A34A]' : 'bg-[#94A3B8]' }}"></span>
                                    {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>

                        </div>


                        <div class="mt-4 grid grid-cols-2 gap-3">

                            <div class="rounded-xl bg-[#F8FAFC] px-3 py-2.5">
                                <p class="text-[10px] font-medium uppercase tracking-wide text-[#94A3B8]">
                                    Urutan
                                </p>

                                <p class="mt-1 text-xs font-semibold text-[#0F172A]">
                                    {{ $banner->sort_order }}
                                </p>
                            </div>

                            <div class="rounded-xl bg-[#F8FAFC] px-3 py-2.5">
                                <p class="text-[10px] font-medium uppercase tracking-wide text-[#94A3B8]">
                                    Jadwal
                                </p>

                                <p class="mt-1 truncate text-xs font-semibold text-[#0F172A]">
                                    @if ($banner->starts_at || $banner->ends_at)
                                        Terjadwal
                                    @else
                                        Selalu tayang
                                    @endif
                                </p>
                            </div>

                        </div>


                        <div class="mt-4 flex gap-2">

                            <a
                                href="{{ route('admin.banners.edit', $banner) }}"
                                class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-[#E2E8F0] px-4 py-2.5 text-xs font-semibold text-[#2563EB] transition hover:bg-[#EFF6FF]"
                            >
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.banners.destroy', $banner) }}"
                                method="POST"
                                class="flex-1"
                                onsubmit="return confirm('Yakin ingin menghapus banner ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#FECACA] px-4 py-2.5 text-xs font-semibold text-[#DC2626] transition hover:bg-[#FEF2F2]"
                                >
                                    <i class="bi bi-trash3"></i>
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </div>

                </article>

            @empty

                <div class="rounded-2xl border border-dashed border-[#CBD5E1] bg-white px-5 py-14 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EFF6FF] text-[#2563EB]">
                        <i class="bi bi-images text-2xl"></i>
                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-[#0F172A]">
                        Belum ada banner
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-[#64748B]">
                        Tambahkan banner pertama untuk homepage ProKerja.
                    </p>

                    <a
                        href="{{ route('admin.banners.create') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#2563EB] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#1D4ED8]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Tambah Banner
                    </a>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if ($banners->hasPages())
            <div class="rounded-2xl border border-[#E2E8F0] bg-white px-4 py-4 shadow-sm sm:px-5">
                {{ $banners->links() }}
            </div>
        @endif

    </div>

</x-layouts.admin>