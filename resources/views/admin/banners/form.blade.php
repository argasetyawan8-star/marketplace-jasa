<x-layouts.admin :title="$mode === 'create' ? 'Tambah Banner' : 'Edit Banner'">

    @php
        $isCreate = $mode === 'create';

        $startsAt = old(
            'starts_at',
            $banner->starts_at?->format('Y-m-d\TH:i')
        );

        $endsAt = old(
            'ends_at',
            $banner->ends_at?->format('Y-m-d\TH:i')
        );
    @endphp


    <div class="mx-auto max-w-5xl space-y-6">

        {{-- HEADER --}}
        <div>

            <div class="flex items-center gap-2 text-xs font-medium text-[#64748B]">
                <a
                    href="{{ route('admin.banners.index') }}"
                    class="transition hover:text-[#2563EB]"
                >
                    CMS Banner
                </a>

                <i class="bi bi-chevron-right text-[10px]"></i>

                <span class="text-[#0F172A]">
                    {{ $isCreate ? 'Tambah Banner' : 'Edit Banner' }}
                </span>
            </div>


            <div class="mt-3">
                <h1 class="text-2xl font-semibold tracking-tight text-[#0F172A] sm:text-3xl">
                    {{ $isCreate ? 'Tambah Banner' : 'Edit Banner' }}
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#64748B]">
                    {{ $isCreate
                        ? 'Tambahkan banner baru untuk memperkaya tampilan homepage ProKerja.'
                        : 'Perbarui informasi, gambar, posisi, atau jadwal banner.'
                    }}
                </p>
            </div>

        </div>


        {{-- ERROR --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-[#FECACA] bg-[#FEF2F2] p-4 text-sm text-[#991B1B]">

                <div class="flex items-start gap-3">

                    <i class="bi bi-exclamation-triangle-fill mt-0.5 shrink-0"></i>

                    <div>
                        <p class="font-semibold">
                            Periksa kembali data yang dimasukkan.
                        </p>

                        <ul class="mt-2 space-y-1 pl-5 text-xs leading-5">
                            @foreach ($errors->all() as $error)
                                <li class="list-disc">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            </div>
        @endif


        <form
            action="{{ $isCreate
                ? route('admin.banners.store')
                : route('admin.banners.update', $banner)
            }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >

            @csrf

            @if (!$isCreate)
                @method('PUT')
            @endif


            {{-- INFORMATION --}}
            <section class="overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm">

                <div class="border-b border-[#E2E8F0] px-5 py-5 sm:px-6">
                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                            <i class="bi bi-info-circle"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#0F172A]">
                                Informasi Banner
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-[#64748B]">
                                Informasi dasar untuk mengatur identitas dan posisi banner.
                            </p>
                        </div>

                    </div>
                </div>


                <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">

                    {{-- NAME --}}
                    <div class="sm:col-span-2">

                        <label
                            for="name"
                            class="mb-2 block text-sm font-semibold text-[#334155]"
                        >
                            Nama Banner
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $banner->name) }}"
                            maxlength="150"
                            required
                            placeholder="Contoh: Promo Website UMKM"
                            class="w-full rounded-xl border border-[#E2E8F0] bg-white px-4 py-3 text-sm text-[#0F172A] outline-none transition placeholder:text-[#94A3B8] focus:border-[#2563EB] focus:ring-4 focus:ring-[#DBEAFE]"
                        >

                        <p class="mt-2 text-xs text-[#94A3B8]">
                            Nama ini hanya digunakan untuk memudahkan pengelolaan banner di CMS.
                        </p>

                    </div>


                    {{-- PLACEMENT --}}
                    <div>

                        <label
                            for="placement"
                            class="mb-2 block text-sm font-semibold text-[#334155]"
                        >
                            Posisi Banner
                        </label>

                        <select
                            id="placement"
                            name="placement"
                            required
                            class="w-full rounded-xl border border-[#E2E8F0] bg-white px-4 py-3 text-sm text-[#0F172A] outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-[#DBEAFE]"
                        >
                            <option
                                value="hero"
                                @selected(old('placement', $banner->placement) === 'hero')
                            >
                                Hero
                            </option>

                            <option
                                value="middle"
                                @selected(old('placement', $banner->placement) === 'middle')
                            >
                                Middle
                            </option>

                            <option
                                value="bottom"
                                @selected(old('placement', $banner->placement) === 'bottom')
                            >
                                Bottom
                            </option>
                        </select>

                        <p class="mt-2 text-xs leading-5 text-[#94A3B8]">
                            Menentukan lokasi banner pada homepage.
                        </p>

                    </div>


                    {{-- SORT --}}
                    <div>

                        <label
                            for="sort_order"
                            class="mb-2 block text-sm font-semibold text-[#334155]"
                        >
                            Urutan
                        </label>

                        <input
                            id="sort_order"
                            type="number"
                            name="sort_order"
                            value="{{ old('sort_order', $banner->sort_order ?? 0) }}"
                            min="0"
                            max="9999"
                            required
                            class="w-full rounded-xl border border-[#E2E8F0] bg-white px-4 py-3 text-sm text-[#0F172A] outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-[#DBEAFE]"
                        >

                        <p class="mt-2 text-xs leading-5 text-[#94A3B8]">
                            Angka lebih kecil akan ditampilkan lebih dahulu.
                        </p>

                    </div>

                </div>

            </section>


            {{-- IMAGE --}}
            <section class="overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm">

                <div class="border-b border-[#E2E8F0] px-5 py-5 sm:px-6">
                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                            <i class="bi bi-image"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#0F172A]">
                                Media Banner
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-[#64748B]">
                                Gunakan gambar desktop dan mobile agar banner tetap proporsional di semua perangkat.
                            </p>
                        </div>

                    </div>
                </div>


                <div class="grid gap-6 p-5 sm:p-6 lg:grid-cols-2">

                    {{-- DESKTOP --}}
                    <div>

                        <label
                            for="image"
                            class="mb-2 block text-sm font-semibold text-[#334155]"
                        >
                            Gambar Desktop
                            @if ($isCreate)
                                <span class="text-[#DC2626]">*</span>
                            @endif
                        </label>


                        @if (!$isCreate && $banner->image_path)
                            <div class="mb-3 overflow-hidden rounded-xl border border-[#E2E8F0] bg-[#F8FAFC]">
                                <img
                                    src="{{ $banner->image_url }}"
                                    alt="{{ $banner->alt_text ?: $banner->name }}"
                                    class="aspect-[16/7] w-full object-cover"
                                >
                            </div>
                        @endif


                        <input
                            id="image"
                            type="file"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            {{ $isCreate ? 'required' : '' }}
                            class="block w-full cursor-pointer rounded-xl border border-[#E2E8F0] bg-white text-sm text-[#64748B] file:mr-4 file:border-0 file:bg-[#EFF6FF] file:px-4 file:py-3 file:text-sm file:font-semibold file:text-[#2563EB] hover:file:bg-[#DBEAFE]"
                        >

                        <p class="mt-2 text-xs leading-5 text-[#94A3B8]">
                            JPG, PNG, atau WebP. Maksimal 10 MB.
                        </p>

                    </div>


                    {{-- MOBILE --}}
                    <div>

                        <label
                            for="mobile_image"
                            class="mb-2 block text-sm font-semibold text-[#334155]"
                        >
                            Gambar Mobile
                            <span class="font-normal text-[#94A3B8]">
                                (opsional)
                            </span>
                        </label>


                        @if (!$isCreate && $banner->mobile_image_url)
                            <div class="mb-3 overflow-hidden rounded-xl border border-[#E2E8F0] bg-[#F8FAFC]">
                                <img
                                    src="{{ $banner->mobile_image_url }}"
                                    alt="{{ $banner->alt_text ?: $banner->name }}"
                                    class="aspect-[4/3] w-full object-cover"
                                >
                            </div>
                        @endif


                        <input
                            id="mobile_image"
                            type="file"
                            name="mobile_image"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="block w-full cursor-pointer rounded-xl border border-[#E2E8F0] bg-white text-sm text-[#64748B] file:mr-4 file:border-0 file:bg-[#EFF6FF] file:px-4 file:py-3 file:text-sm file:font-semibold file:text-[#2563EB] hover:file:bg-[#DBEAFE]"
                        >

                        <p class="mt-2 text-xs leading-5 text-[#94A3B8]">
                            Opsional. Disarankan menggunakan komposisi khusus mobile.
                        </p>

                    </div>


                    {{-- ALT --}}
                    <div class="lg:col-span-2">

                        <label
                            for="alt_text"
                            class="mb-2 block text-sm font-semibold text-[#334155]"
                        >
                            Alt Text
                        </label>

                        <input
                            id="alt_text"
                            type="text"
                            name="alt_text"
                            value="{{ old('alt_text', $banner->alt_text) }}"
                            maxlength="255"
                            placeholder="Contoh: Promo jasa pembuatan website ProKerja"
                            class="w-full rounded-xl border border-[#E2E8F0] bg-white px-4 py-3 text-sm text-[#0F172A] outline-none transition placeholder:text-[#94A3B8] focus:border-[#2563EB] focus:ring-4 focus:ring-[#DBEAFE]"
                        >

                    </div>

                </div>

            </section>


            {{-- LINK --}}
            <section class="overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm">

                <div class="border-b border-[#E2E8F0] px-5 py-5 sm:px-6">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                            <i class="bi bi-link-45deg"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#0F172A]">
                                Tautan Banner
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-[#64748B]">
                                Tentukan halaman yang dibuka ketika banner diklik.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="space-y-5 p-5 sm:p-6">

                    {{-- LINK URL --}}
                    <div>

                        <label
                            for="link_url"
                            class="mb-2 block text-sm font-semibold text-[#334155]"
                        >
                            URL Tujuan
                        </label>

                        <input
                            id="link_url"
                            type="text"
                            name="link_url"
                            value="{{ old('link_url', $banner->link_url) }}"
                            maxlength="2048"
                            placeholder="/search atau https://example.com"
                            class="w-full rounded-xl border border-[#E2E8F0] bg-white px-4 py-3 text-sm text-[#0F172A] outline-none transition placeholder:text-[#94A3B8] focus:border-[#2563EB] focus:ring-4 focus:ring-[#DBEAFE]"
                        >

                        <p class="mt-2 text-xs leading-5 text-[#94A3B8]">
                            Bisa menggunakan URL internal seperti <span class="font-medium text-[#64748B]">/search</span> atau URL eksternal dengan https://.
                        </p>

                    </div>


                    {{-- NEW TAB --}}
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] p-4">

                        <input
                            type="checkbox"
                            name="open_new_tab"
                            value="1"
                            class="mt-0.5 h-4 w-4 rounded border-[#CBD5E1] text-[#2563EB] focus:ring-[#DBEAFE]"
                            @checked(old('open_new_tab', $banner->open_new_tab))
                        >

                        <span>
                            <span class="block text-sm font-semibold text-[#334155]">
                                Buka di tab baru
                            </span>

                            <span class="mt-1 block text-xs leading-5 text-[#64748B]">
                                Cocok digunakan untuk tautan ke website atau halaman eksternal.
                            </span>
                        </span>

                    </label>

                </div>

            </section>


            {{-- SCHEDULE + STATUS --}}
            <section class="overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm">

                <div class="border-b border-[#E2E8F0] px-5 py-5 sm:px-6">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EFF6FF] text-[#2563EB]">
                            <i class="bi bi-calendar-event"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#0F172A]">
                                Jadwal & Status
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-[#64748B]">
                                Atur kapan banner mulai tayang dan kapan berhenti ditampilkan.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">

                    {{-- START --}}
                    <div>

                        <label
                            for="starts_at"
                            class="mb-2 block text-sm font-semibold text-[#334155]"
                        >
                            Mulai Tayang
                        </label>

                        <input
                            id="starts_at"
                            type="datetime-local"
                            name="starts_at"
                            value="{{ $startsAt }}"
                            class="w-full rounded-xl border border-[#E2E8F0] bg-white px-4 py-3 text-sm text-[#0F172A] outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-[#DBEAFE]"
                        >

                        <p class="mt-2 text-xs text-[#94A3B8]">
                            Kosongkan untuk langsung tayang.
                        </p>

                    </div>


                    {{-- END --}}
                    <div>

                        <label
                            for="ends_at"
                            class="mb-2 block text-sm font-semibold text-[#334155]"
                        >
                            Selesai Tayang
                        </label>

                        <input
                            id="ends_at"
                            type="datetime-local"
                            name="ends_at"
                            value="{{ $endsAt }}"
                            class="w-full rounded-xl border border-[#E2E8F0] bg-white px-4 py-3 text-sm text-[#0F172A] outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-[#DBEAFE]"
                        >

                        <p class="mt-2 text-xs text-[#94A3B8]">
                            Kosongkan agar banner tidak memiliki tanggal akhir.
                        </p>

                    </div>


                    {{-- STATUS --}}
                    <div class="sm:col-span-2">

                        <label class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] p-4">

                            <span>
                                <span class="block text-sm font-semibold text-[#334155]">
                                    Aktifkan Banner
                                </span>

                                <span class="mt-1 block text-xs leading-5 text-[#64748B]">
                                    Banner aktif dapat ditampilkan apabila berada dalam jadwal tayang.
                                </span>
                            </span>

                            <span class="relative inline-flex shrink-0">

                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    class="peer sr-only"
                                    @checked(old('is_active', $banner->is_active))
                                >

                                <span class="relative h-6 w-11 rounded-full bg-[#CBD5E1] transition peer-checked:bg-[#2563EB] peer-focus:ring-4 peer-focus:ring-[#DBEAFE]">
                                    <span class="absolute left-[3px] top-[3px] h-5 w-5 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"></span>
                                </span>

                            </span>

                        </label>

                    </div>

                </div>

            </section>


            {{-- ACTION --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-between">

                <a
                    href="{{ route('admin.banners.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#E2E8F0] bg-white px-5 py-3 text-sm font-semibold text-[#64748B] transition hover:bg-[#F8FAFC]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1D4ED8] hover:shadow-md"
                >
                    <i class="bi bi-check2"></i>
                    {{ $isCreate ? 'Simpan Banner' : 'Simpan Perubahan' }}
                </button>

            </div>

        </form>

    </div>

</x-layouts.admin>