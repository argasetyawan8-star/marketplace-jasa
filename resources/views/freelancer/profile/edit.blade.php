<x-layouts.freelancer title="Edit Profil">

    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                        <i class="bi bi-person-gear"></i>
                        Profil Freelancer
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Edit Profil
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#71837B]">
                        Perbarui informasi profil freelancer kamu.
                    </p>
                </div>

                <a
                    href="{{ route('freelancer.profile.show') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E5DE] bg-white px-5 py-2.5 text-sm font-semibold text-[#526960] transition hover:bg-[#F8FCF9] hover:text-[#123128]"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

            </div>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="rounded-xl border border-[#F2D0D0] bg-[#FEF0F0] p-4 sm:p-5">
                <div class="flex items-start gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#B42318]">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-[#B42318]">
                            Ada beberapa data yang perlu diperbaiki.
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-[#A64A43]">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endif

        {{-- Form --}}
        <form
            action="{{ route('freelancer.profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @method('PATCH')

            {{-- Avatar --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-person-circle"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Foto Profil
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Gunakan foto yang jelas dan profesional.
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-6 sm:flex-row sm:items-center">

                    {{-- Current Avatar --}}
                    <div class="h-28 w-28 shrink-0 overflow-hidden rounded-full border-4 border-[#EAF7EF] bg-[#F3F8F5]">

                        @if ($freelancerProfile->avatar)

                            <img
                                src="{{ asset('storage/' . $freelancerProfile->avatar) }}"
                                alt="{{ $user->name }}"
                                class="block h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center">
                                <span class="text-3xl font-semibold text-[#0F6B3A]">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>

                        @endif

                    </div>

                    {{-- Upload --}}
                    <div class="min-w-0 flex-1">
                        <label
                            for="avatar"
                            class="block text-sm font-semibold text-[#345047]"
                        >
                            Upload foto baru
                        </label>

                        <div class="mt-2 rounded-xl border border-[#D8E5DE] bg-[#F8FCF9] p-3">
                            <input
                                type="file"
                                id="avatar"
                                name="avatar"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-[#526960] file:mr-4 file:rounded-lg file:border-0 file:bg-[#EAF7EF] file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-[#17663D] hover:file:bg-[#DDF3E6]"
                            >
                        </div>

                        <p class="mt-2 text-xs text-[#8A9B94]">
                            JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                        </p>

                        @error('avatar')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Cover --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-image"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Cover Profil
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Cover akan tampil pada bagian atas profil kamu.
                        </p>
                    </div>
                </div>

                @if ($freelancerProfile->cover_image)
                    <div class="mt-5 overflow-hidden rounded-xl border border-[#DCE9E2] bg-[#F3F8F5]">
                        <img
                            src="{{ asset('storage/' . $freelancerProfile->cover_image) }}"
                            alt="Cover profil"
                            class="block h-52 w-full object-cover sm:h-60"
                        >
                    </div>
                @endif

                <div class="mt-5">
                    <label
                        for="cover_image"
                        class="block text-sm font-semibold text-[#345047]"
                    >
                        Upload cover baru
                    </label>

                    <div class="mt-2 rounded-xl border border-[#D8E5DE] bg-[#F8FCF9] p-3">
                        <input
                            type="file"
                            id="cover_image"
                            name="cover_image"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full text-sm text-[#526960] file:mr-4 file:rounded-lg file:border-0 file:bg-[#EAF7EF] file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-[#17663D] hover:file:bg-[#DDF3E6]"
                        >
                    </div>

                    <p class="mt-2 text-xs text-[#8A9B94]">
                        JPG, JPEG, PNG, atau WEBP. Maksimal 10 MB.
                    </p>

                    @error('cover_image')
                        <p class="mt-2 text-sm text-[#B42318]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- Profile Information --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Informasi Profil
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Informasi yang akan dilihat client.
                        </p>
                    </div>
                </div>

                <div class="mt-6 space-y-5">

                    {{-- Username --}}
                    <div>
                        <label
                            for="username"
                            class="block text-sm font-semibold text-[#345047]"
                        >
                            Username
                        </label>

                        <div class="relative mt-2">
                            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-[#8A9B94]">
                                @
                            </span>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username', $freelancerProfile->username) }}"
                                placeholder="usernamekamu"
                                class="w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] py-3.5 pl-9 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            >
                        </div>

                        <p class="mt-2 text-xs text-[#8A9B94]">
                            Username digunakan sebagai identitas publik freelancer.
                        </p>

                        @error('username')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Headline --}}
                    <div>
                        <label
                            for="headline"
                            class="block text-sm font-semibold text-[#345047]"
                        >
                            Headline
                        </label>

                        <input
                            type="text"
                            id="headline"
                            name="headline"
                            value="{{ old('headline', $freelancerProfile->headline) }}"
                            placeholder="Contoh: Content Writer & SEO Specialist"
                            class="mt-2 w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                        >

                        @error('headline')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Bio --}}
                    <div>
                        <label
                            for="bio"
                            class="block text-sm font-semibold text-[#345047]"
                        >
                            Bio
                        </label>

                        <textarea
                            id="bio"
                            name="bio"
                            rows="6"
                            placeholder="Ceritakan pengalaman, keahlian, dan layanan yang kamu tawarkan..."
                            class="mt-2 w-full resize-none rounded-xl border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                        >{{ old('bio', $freelancerProfile->bio) }}</textarea>

                        @error('bio')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Additional Information --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-sliders"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Informasi Tambahan
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Informasi kontak dan ketersediaan kamu.
                        </p>
                    </div>
                </div>

                <div class="mt-6 space-y-5">

                    {{-- Location --}}
                    <div>
                        <label
                            for="location"
                            class="block text-sm font-semibold text-[#345047]"
                        >
                            Lokasi
                        </label>

                        <div class="relative mt-2">
                            <i class="bi bi-geo-alt pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#8A9B94]"></i>

                            <input
                                type="text"
                                id="location"
                                name="location"
                                value="{{ old('location', $freelancerProfile->location) }}"
                                placeholder="Contoh: Yogyakarta, Indonesia"
                                class="w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] py-3.5 pl-11 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            >
                        </div>

                        @error('location')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Website --}}
                    <div>
                        <label
                            for="website"
                            class="block text-sm font-semibold text-[#345047]"
                        >
                            Website
                        </label>

                        <div class="relative mt-2">
                            <i class="bi bi-globe2 pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#8A9B94]"></i>

                            <input
                                type="url"
                                id="website"
                                name="website"
                                value="{{ old('website', $freelancerProfile->website) }}"
                                placeholder="https://websitekamu.com"
                                class="w-full rounded-xl border-[#D8E5DE] bg-[#FBFDFC] py-3.5 pl-11 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            >
                        </div>

                        @error('website')
                            <p class="mt-2 text-sm text-[#B42318]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Availability --}}
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4 sm:p-5">

                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-[#123128]">
                                Status tersedia
                            </p>

                            <p class="mt-1 text-sm leading-5 text-[#71837B]">
                                Aktifkan jika kamu masih menerima pekerjaan baru.
                            </p>
                        </div>

                        <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                            <input
                                type="checkbox"
                                name="is_available"
                                value="1"
                                class="peer sr-only"
                                {{ old('is_available', $freelancerProfile->is_available) ? 'checked' : '' }}
                            >

                            <div class="h-6 w-11 rounded-full bg-[#CAD6D0] transition peer-checked:bg-[#1E9E5A] peer-focus:ring-4 peer-focus:ring-[#EAF7EF]"></div>

                            <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"></div>
                        </label>

                    </div>

                </div>
            </div>

            {{-- Account Information --}}
            <div class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-person-vcard"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Informasi Akun
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Data akun utama kamu.
                        </p>
                    </div>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-2">

                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4">
                        <p class="text-xs text-[#8A9B94]">
                            Nama
                        </p>

                        <p class="mt-1 text-sm font-semibold text-[#123128]">
                            {{ $user->name }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-[#E2ECE7] bg-[#F8FCF9] p-4">
                        <p class="text-xs text-[#8A9B94]">
                            Email
                        </p>

                        <p class="mt-1 break-all text-sm font-semibold text-[#123128]">
                            {{ $user->email }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Action --}}
            <div class="flex flex-col-reverse gap-3 border-t border-[#DCE9E2] pt-6 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('freelancer.profile.show') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E5DE] bg-white px-5 py-3 text-sm font-semibold text-[#526960] transition hover:bg-[#F8FCF9] hover:text-[#123128]"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</x-layouts.freelancer>