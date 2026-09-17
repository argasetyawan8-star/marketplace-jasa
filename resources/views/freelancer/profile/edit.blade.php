<x-layouts.freelancer title="Edit Profil">

    <div
        class="mx-auto max-w-5xl pb-28"
        x-data="profileEditor({
            experiences: @js(
                $freelancerProfile->experiences->map(fn ($item) => [
                    'id' => $item->id,
                    'position' => $item->position,
                    'company' => $item->company,
                    'start_year' => $item->start_year,
                    'end_year' => $item->end_year,
                    'description' => $item->description,
                ])->values()
            ),
            educations: @js(
                $freelancerProfile->educations->map(fn ($item) => [
                    'id' => $item->id,
                    'institution' => $item->institution,
                    'field_of_study' => $item->field_of_study,
                    'start_year' => $item->start_year,
                    'end_year' => $item->end_year,
                ])->values()
            ),
            certificates: @js(
                $freelancerProfile->certificates->map(fn ($item) => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'issuer' => $item->issuer,
                    'year' => $item->year,
                    'credential_url' => $item->credential_url,
                ])->values()
            ),
            skills: @js(
                $freelancerProfile->skills->map(fn ($item) => [
                    'id' => $item->id,
                    'name' => $item->name,
                ])->values()
            ),
            languages: @js(
                $freelancerProfile->languages->map(fn ($item) => [
                    'id' => $item->id,
                    'language' => $item->language,
                    'level' => $item->level,
                ])->values()
            )
        })"
    >

        {{-- ====================================================== --}}
        {{-- HEADER --}}
        {{-- ====================================================== --}}
        <div class="mb-6 rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#1E9E5A]">
                        <i class="bi bi-person-gear"></i>
                        Profil Freelancer
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#123128] sm:text-3xl">
                        Edit Profil
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#71837B]">
                        Kelola informasi profil, pengalaman, pendidikan, sertifikat,
                        keahlian, dan bahasa kamu dalam satu halaman.
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


        {{-- ====================================================== --}}
        {{-- ERROR --}}
        {{-- ====================================================== --}}
        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-[#F2D0D0] bg-[#FEF0F0] p-4 sm:p-5">

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

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- ====================================================== --}}
        {{-- MAIN FORM --}}
        {{-- ====================================================== --}}
        <form
            action="{{ route('freelancer.profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >

            @csrf
            @method('PATCH')


            {{-- ================================================== --}}
            {{-- PHOTO --}}
            {{-- ================================================== --}}
            <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-image"></i>
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

                    <div class="h-28 w-28 shrink-0 overflow-hidden rounded-full border-4 border-[#EAF7EF] bg-[#F3F8F5]">

                        @if ($freelancerProfile->avatar)

                            <img
                                src="{{ asset('storage/' . $freelancerProfile->avatar) }}"
                                alt="{{ $user->name }}"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center">
                                <span class="text-3xl font-semibold text-[#0F6B3A]">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>

                        @endif

                    </div>


                    <div class="flex-1">

                        <label class="text-sm font-semibold text-[#345047]">
                            Upload foto baru
                        </label>

                        <div class="mt-2 rounded-xl border border-[#D8E5DE] bg-[#F8FCF9] p-3">

                            <input
                                type="file"
                                name="avatar"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-[#526960] file:mr-4 file:rounded-lg file:border-0 file:bg-[#EAF7EF] file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-[#17663D] hover:file:bg-[#DDF3E6]"
                            >

                        </div>

                        <p class="mt-2 text-xs text-[#8A9B94]">
                            JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                        </p>

                    </div>

                </div>

            </section>


            {{-- ================================================== --}}
            {{-- COVER --}}
            {{-- ================================================== --}}
            <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-card-image"></i>
                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-[#123128]">
                            Cover Profil
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Banner yang ditampilkan pada bagian atas profil kamu.
                        </p>

                    </div>

                </div>


                @if ($freelancerProfile->cover_image)

                    <div class="mt-5 overflow-hidden rounded-xl border border-[#DCE9E2] bg-[#F3F8F5]">

                        <img
                            src="{{ asset('storage/' . $freelancerProfile->cover_image) }}"
                            alt="Cover profil"
                            class="block h-48 w-full object-cover sm:h-60"
                        >

                    </div>

                @endif


                <div class="mt-5">

                    <label class="text-sm font-semibold text-[#345047]">
                        Upload cover baru
                    </label>

                    <div class="mt-2 rounded-xl border border-[#D8E5DE] bg-[#F8FCF9] p-3">

                        <input
                            type="file"
                            name="cover_image"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full text-sm text-[#526960] file:mr-4 file:rounded-lg file:border-0 file:bg-[#EAF7EF] file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-[#17663D] hover:file:bg-[#DDF3E6]"
                        >

                    </div>

                    <p class="mt-2 text-xs text-[#8A9B94]">
                        JPG, JPEG, PNG, atau WEBP. Maksimal 10 MB.
                    </p>

                </div>

            </section>


            {{-- ================================================== --}}
            {{-- PROFILE INFORMATION --}}
            {{-- ================================================== --}}
            <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-[#123128]">
                            Informasi Profil
                        </h2>

                        <p class="mt-0.5 text-sm text-[#8A9B94]">
                            Informasi utama yang akan dilihat client.
                        </p>

                    </div>

                </div>


                <div class="mt-6 grid gap-5">

                    {{-- Username --}}
                    <div>

                        <label class="text-sm font-semibold text-[#345047]">
                            Username
                        </label>

                        <div class="relative mt-2">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold text-[#8A9B94]">
                                @
                            </span>

                            <input
                                type="text"
                                name="username"
                                value="{{ old('username', $freelancerProfile->username) }}"
                                required
                                maxlength="50"
                                class="w-full rounded-xl border border-[#D8E5DE] bg-[#FBFDFC] py-3.5 pl-9 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            >

                        </div>

                    </div>


                    {{-- Headline --}}
                    <div>

                        <label class="text-sm font-semibold text-[#345047]">
                            Headline
                        </label>

                        <input
                            type="text"
                            name="headline"
                            value="{{ old('headline', $freelancerProfile->headline) }}"
                            placeholder="Contoh: Content Writer & SEO Specialist"
                            maxlength="255"
                            class="mt-2 w-full rounded-xl border border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                        >

                    </div>


                    {{-- Bio --}}
                    <div>

                        <label class="text-sm font-semibold text-[#345047]">
                            Bio
                        </label>

                        <textarea
                            name="bio"
                            rows="6"
                            placeholder="Ceritakan pengalaman, keahlian, dan layanan yang kamu tawarkan..."
                            class="mt-2 w-full resize-none rounded-xl border border-[#D8E5DE] bg-[#FBFDFC] px-4 py-3.5 text-sm leading-6 text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                        >{{ old('bio', $freelancerProfile->bio) }}</textarea>

                    </div>


                    {{-- Location --}}
                    <div>

                        <label class="text-sm font-semibold text-[#345047]">
                            Lokasi
                        </label>

                        <div class="relative mt-2">

                            <i class="bi bi-geo-alt pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#8A9B94]"></i>

                            <input
                                type="text"
                                name="location"
                                value="{{ old('location', $freelancerProfile->location) }}"
                                placeholder="Contoh: Yogyakarta, Indonesia"
                                maxlength="255"
                                class="w-full rounded-xl border border-[#D8E5DE] bg-[#FBFDFC] py-3.5 pl-11 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            >

                        </div>

                    </div>


                    {{-- Website --}}
                    <div>

                        <label class="text-sm font-semibold text-[#345047]">
                            Website
                        </label>

                        <div class="relative mt-2">

                            <i class="bi bi-globe2 pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#8A9B94]"></i>

                            <input
                                type="url"
                                name="website"
                                value="{{ old('website', $freelancerProfile->website) }}"
                                placeholder="https://websitekamu.com"
                                class="w-full rounded-xl border border-[#D8E5DE] bg-[#FBFDFC] py-3.5 pl-11 pr-4 text-sm text-[#123128] outline-none transition placeholder:text-[#A0B0A9] focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            >

                        </div>

                    </div>


                    {{-- Availability --}}
                    <div class="flex items-center justify-between gap-5 rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4 sm:p-5">

                        <div>

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

                            <div class="h-6 w-11 rounded-full bg-[#CAD6D0] transition peer-checked:bg-[#1E9E5A]"></div>

                            <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"></div>

                        </label>

                    </div>

                </div>

            </section>


            {{-- ================================================== --}}
            {{-- EXPERIENCE --}}
            {{-- ================================================== --}}
            <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-[#123128]">
                                Pengalaman
                            </h2>

                            <p class="mt-0.5 text-sm text-[#8A9B94]">
                                Tambahkan seluruh pengalaman profesional kamu.
                            </p>
                        </div>

                    </div>

                    <button
                        type="button"
                        @click="addExperience()"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#BFE7CF] bg-[#EAF7EF] px-4 py-2.5 text-sm font-semibold text-[#17663D] transition hover:bg-[#DDF3E6]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Tambah Pengalaman
                    </button>

                </div>


                <div class="mt-6 space-y-4">

                    <template x-for="(experience, index) in experiences" :key="experience._key">

                        <div class="rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-5">

                            <input
                                type="hidden"
                                :name="`experiences[${index}][id]`"
                                x-model="experience.id"
                            >

                            <div class="flex items-start justify-between gap-4">

                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#1E9E5A]">
                                        Pengalaman
                                        <span x-text="index + 1"></span>
                                    </p>

                                    <p class="mt-1 text-sm text-[#8A9B94]">
                                        Isi informasi pengalaman kamu.
                                    </p>

                                </div>

                                <button
                                    type="button"
                                    @click="removeExperience(index)"
                                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-red-200 bg-white text-red-600 transition hover:bg-red-50"
                                    title="Hapus pengalaman"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>


                            <div class="mt-5 grid gap-4 sm:grid-cols-2">

                                <div>

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Posisi
                                    </label>

                                    <input
                                        type="text"
                                        :name="`experiences[${index}][position]`"
                                        x-model="experience.position"
                                        required
                                        placeholder="Contoh: UI/UX Designer"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                                <div>

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Perusahaan
                                    </label>

                                    <input
                                        type="text"
                                        :name="`experiences[${index}][company]`"
                                        x-model="experience.company"
                                        placeholder="Contoh: ABC Studio"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                                <div>

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Tahun Mulai
                                    </label>

                                    <input
                                        type="number"
                                        :name="`experiences[${index}][start_year]`"
                                        x-model="experience.start_year"
                                        min="1900"
                                        max="2100"
                                        required
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                                <div>

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Tahun Selesai
                                    </label>

                                    <input
                                        type="number"
                                        :name="`experiences[${index}][end_year]`"
                                        x-model="experience.end_year"
                                        min="1900"
                                        max="2100"
                                        placeholder="Kosongkan jika masih bekerja"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                            </div>


                            <div class="mt-4">

                                <label class="text-xs font-semibold text-[#526960]">
                                    Deskripsi
                                </label>

                                <textarea
                                    :name="`experiences[${index}][description]`"
                                    x-model="experience.description"
                                    rows="4"
                                    placeholder="Jelaskan tanggung jawab atau pengalaman kamu..."
                                    class="mt-1.5 block w-full resize-none rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm leading-6 text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                ></textarea>

                            </div>

                        </div>

                    </template>


                    <div
                        x-show="experiences.length === 0"
                        class="rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] p-8 text-center"
                    >

                        <i class="bi bi-briefcase text-2xl text-[#A0AEA8]"></i>

                        <p class="mt-3 text-sm font-medium text-[#526960]">
                            Belum ada pengalaman
                        </p>

                        <button
                            type="button"
                            @click="addExperience()"
                            class="mt-4 text-sm font-semibold text-[#0F6B3A] hover:text-[#0B542D]"
                        >
                            + Tambah pengalaman
                        </button>

                    </div>

                </div>

            </section>


            {{-- ================================================== --}}
            {{-- EDUCATION --}}
            {{-- ================================================== --}}
            <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-[#123128]">
                                Pendidikan
                            </h2>

                            <p class="mt-0.5 text-sm text-[#8A9B94]">
                                Tambahkan riwayat pendidikan kamu.
                            </p>
                        </div>

                    </div>

                    <button
                        type="button"
                        @click="addEducation()"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#BFE7CF] bg-[#EAF7EF] px-4 py-2.5 text-sm font-semibold text-[#17663D] hover:bg-[#DDF3E6]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Tambah Pendidikan
                    </button>

                </div>


                <div class="mt-6 space-y-4">

                    <template x-for="(education, index) in educations" :key="education._key">

                        <div class="rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-5">

                            <input
                                type="hidden"
                                :name="`educations[${index}][id]`"
                                x-model="education.id"
                            >

                            <div class="flex items-start justify-between gap-4">

                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#1E9E5A]">
                                        Pendidikan
                                        <span x-text="index + 1"></span>
                                    </p>

                                </div>

                                <button
                                    type="button"
                                    @click="removeEducation(index)"
                                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-red-200 bg-white text-red-600 hover:bg-red-50"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>


                            <div class="mt-5 grid gap-4 sm:grid-cols-2">

                                <div class="sm:col-span-2">

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Institusi
                                    </label>

                                    <input
                                        type="text"
                                        :name="`educations[${index}][institution]`"
                                        x-model="education.institution"
                                        required
                                        placeholder="Contoh: Universitas Gadjah Mada"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                                <div class="sm:col-span-2">

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Bidang Studi
                                    </label>

                                    <input
                                        type="text"
                                        :name="`educations[${index}][field_of_study]`"
                                        x-model="education.field_of_study"
                                        placeholder="Contoh: Sistem Informasi"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                                <div>

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Tahun Mulai
                                    </label>

                                    <input
                                        type="number"
                                        :name="`educations[${index}][start_year]`"
                                        x-model="education.start_year"
                                        min="1900"
                                        max="2100"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                                <div>

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Tahun Selesai
                                    </label>

                                    <input
                                        type="number"
                                        :name="`educations[${index}][end_year]`"
                                        x-model="education.end_year"
                                        min="1900"
                                        max="2100"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                            </div>

                        </div>

                    </template>


                    <div
                        x-show="educations.length === 0"
                        class="rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] p-8 text-center"
                    >

                        <i class="bi bi-mortarboard text-2xl text-[#A0AEA8]"></i>

                        <p class="mt-3 text-sm text-[#8A9B94]">
                            Belum ada pendidikan.
                        </p>

                        <button
                            type="button"
                            @click="addEducation()"
                            class="mt-4 text-sm font-semibold text-[#0F6B3A]"
                        >
                            + Tambah pendidikan
                        </button>

                    </div>

                </div>

            </section>


            {{-- ================================================== --}}
            {{-- CERTIFICATES --}}
            {{-- ================================================== --}}
            <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-award-fill"></i>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-[#123128]">
                                Sertifikat
                            </h2>

                            <p class="mt-0.5 text-sm text-[#8A9B94]">
                                Tambahkan sertifikat dan kredensial profesional.
                            </p>
                        </div>

                    </div>

                    <button
                        type="button"
                        @click="addCertificate()"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#BFE7CF] bg-[#EAF7EF] px-4 py-2.5 text-sm font-semibold text-[#17663D] hover:bg-[#DDF3E6]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Tambah Sertifikat
                    </button>

                </div>


                <div class="mt-6 space-y-4">

                    <template x-for="(certificate, index) in certificates" :key="certificate._key">

                        <div class="rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-5">

                            <input
                                type="hidden"
                                :name="`certificates[${index}][id]`"
                                x-model="certificate.id"
                            >

                            <div class="flex items-start justify-between gap-4">

                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#1E9E5A]">
                                        Sertifikat
                                        <span x-text="index + 1"></span>
                                    </p>

                                </div>

                                <button
                                    type="button"
                                    @click="removeCertificate(index)"
                                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-red-200 bg-white text-red-600 hover:bg-red-50"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>


                            <div class="mt-5 grid gap-4 sm:grid-cols-2">

                                <div class="sm:col-span-2">

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Nama Sertifikat
                                    </label>

                                    <input
                                        type="text"
                                        :name="`certificates[${index}][name]`"
                                        x-model="certificate.name"
                                        required
                                        placeholder="Contoh: Google UX Design Certificate"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                                <div>

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Penerbit
                                    </label>

                                    <input
                                        type="text"
                                        :name="`certificates[${index}][issuer]`"
                                        x-model="certificate.issuer"
                                        placeholder="Contoh: Google"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                                <div>

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Tahun
                                    </label>

                                    <input
                                        type="number"
                                        :name="`certificates[${index}][year]`"
                                        x-model="certificate.year"
                                        min="1900"
                                        max="2100"
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                                <div class="sm:col-span-2">

                                    <label class="text-xs font-semibold text-[#526960]">
                                        Link Sertifikat
                                    </label>

                                    <input
                                        type="url"
                                        :name="`certificates[${index}][credential_url]`"
                                        x-model="certificate.credential_url"
                                        placeholder="https://..."
                                        class="mt-1.5 block w-full rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                                    >

                                </div>

                            </div>

                        </div>

                    </template>


                    <div
                        x-show="certificates.length === 0"
                        class="rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] p-8 text-center"
                    >

                        <i class="bi bi-award text-2xl text-[#A0AEA8]"></i>

                        <p class="mt-3 text-sm text-[#8A9B94]">
                            Belum ada sertifikat.
                        </p>

                        <button
                            type="button"
                            @click="addCertificate()"
                            class="mt-4 text-sm font-semibold text-[#0F6B3A]"
                        >
                            + Tambah sertifikat
                        </button>

                    </div>

                </div>

            </section>


            {{-- ================================================== --}}
            {{-- SKILLS --}}
            {{-- ================================================== --}}
            <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-stars"></i>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-[#123128]">
                                Keahlian
                            </h2>

                            <p class="mt-0.5 text-sm text-[#8A9B94]">
                                Tambahkan semua keahlian yang kamu kuasai.
                            </p>
                        </div>

                    </div>

                    <button
                        type="button"
                        @click="addSkill()"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#BFE7CF] bg-[#EAF7EF] px-4 py-2.5 text-sm font-semibold text-[#17663D] hover:bg-[#DDF3E6]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Tambah Keahlian
                    </button>

                </div>


                <div class="mt-6 grid gap-3 sm:grid-cols-2">

                    <template x-for="(skill, index) in skills" :key="skill._key">

                        <div class="flex items-center gap-3 rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-3">

                            <input
                                type="hidden"
                                :name="`skills[${index}][id]`"
                                x-model="skill.id"
                            >

                            <input
                                type="text"
                                :name="`skills[${index}][name]`"
                                x-model="skill.name"
                                required
                                placeholder="Contoh: Laravel"
                                class="min-w-0 flex-1 rounded-lg border border-[#D8E5DE] bg-white px-3 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            >

                            <button
                                type="button"
                                @click="removeSkill(index)"
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-red-500 hover:bg-red-50"
                            >
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>

                    </template>

                </div>


                <div
                    x-show="skills.length === 0"
                    class="mt-6 rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] p-8 text-center"
                >

                    <i class="bi bi-stars text-2xl text-[#A0AEA8]"></i>

                    <p class="mt-3 text-sm text-[#8A9B94]">
                        Belum ada keahlian.
                    </p>

                    <button
                        type="button"
                        @click="addSkill()"
                        class="mt-4 text-sm font-semibold text-[#0F6B3A]"
                    >
                        + Tambah keahlian
                    </button>

                </div>

            </section>


            {{-- ================================================== --}}
            {{-- LANGUAGES --}}
            {{-- ================================================== --}}
            <section class="rounded-2xl border border-[#DCE9E2] bg-white p-6 sm:p-7">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-translate"></i>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-[#123128]">
                                Bahasa
                            </h2>

                            <p class="mt-0.5 text-sm text-[#8A9B94]">
                                Tambahkan beberapa bahasa sekaligus.
                            </p>
                        </div>

                    </div>

                    <button
                        type="button"
                        @click="addLanguage()"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#BFE7CF] bg-[#EAF7EF] px-4 py-2.5 text-sm font-semibold text-[#17663D] hover:bg-[#DDF3E6]"
                    >
                        <i class="bi bi-plus-lg"></i>
                        Tambah Bahasa
                    </button>

                </div>


                <div class="mt-6 space-y-3">

                    <template x-for="(language, index) in languages" :key="language._key">

                        <div class="grid gap-3 rounded-xl border border-[#DCE9E2] bg-[#F8FCF9] p-4 sm:grid-cols-[1fr_200px_auto]">

                            <input
                                type="hidden"
                                :name="`languages[${index}][id]`"
                                x-model="language.id"
                            >

                            <input
                                type="text"
                                :name="`languages[${index}][language]`"
                                x-model="language.language"
                                required
                                placeholder="Contoh: Bahasa Indonesia"
                                class="rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            >

                            <select
                                :name="`languages[${index}][level]`"
                                x-model="language.level"
                                class="rounded-xl border border-[#D8E5DE] bg-white px-3.5 py-2.5 text-sm text-[#123128] outline-none focus:border-[#1E9E5A] focus:ring-4 focus:ring-[#EAF7EF]"
                            >

                                <option value="">
                                    Pilih tingkat
                                </option>

                                <option value="Dasar">
                                    Dasar
                                </option>

                                <option value="Menengah">
                                    Menengah
                                </option>

                                <option value="Mahir">
                                    Mahir
                                </option>

                                <option value="Native">
                                    Native
                                </option>

                            </select>

                            <button
                                type="button"
                                @click="removeLanguage(index)"
                                class="flex h-11 items-center justify-center rounded-xl border border-red-200 bg-white px-4 text-red-600 hover:bg-red-50"
                            >
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>

                    </template>

                </div>


                <div
                    x-show="languages.length === 0"
                    class="mt-6 rounded-xl border border-dashed border-[#D8E5DE] bg-[#F8FCF9] p-8 text-center"
                >

                    <i class="bi bi-translate text-2xl text-[#A0AEA8]"></i>

                    <p class="mt-3 text-sm text-[#8A9B94]">
                        Belum ada bahasa.
                    </p>

                    <button
                        type="button"
                        @click="addLanguage()"
                        class="mt-4 text-sm font-semibold text-[#0F6B3A]"
                    >
                        + Tambah bahasa
                    </button>

                </div>

            </section>


            {{-- ================================================== --}}
            {{-- SAVE BAR --}}
            {{-- ================================================== --}}
            <div class="sticky bottom-4 z-20">

                <div class="flex flex-col gap-3 rounded-2xl border border-[#DCE9E2] bg-white/95 p-4 shadow-lg backdrop-blur sm:flex-row sm:items-center sm:justify-between sm:px-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#0F6B3A]">
                            <i class="bi bi-cloud-check"></i>
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#123128]">
                                Semua perubahan disimpan sekaligus
                            </p>

                            <p class="mt-0.5 text-xs text-[#8A9B94]">
                                Profil, pengalaman, pendidikan, sertifikat, keahlian, dan bahasa.
                            </p>

                        </div>

                    </div>


                    <div class="flex flex-col gap-2 sm:flex-row">

                        <a
                            href="{{ route('freelancer.profile.show') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#D8E5DE] bg-white px-5 py-2.5 text-sm font-semibold text-[#526960] hover:bg-[#F8FCF9]"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0B542D]"
                        >
                            <i class="bi bi-check-lg"></i>
                            Simpan Perubahan
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>


    {{-- ========================================================== --}}
    {{-- ALPINE PROFILE EDITOR --}}
    {{-- ========================================================== --}}
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('profileEditor', (data) => ({

                experiences: data.experiences.map(item => ({
                    ...item,
                    _key: `experience-${item.id ?? crypto.randomUUID()}`
                })),

                educations: data.educations.map(item => ({
                    ...item,
                    _key: `education-${item.id ?? crypto.randomUUID()}`
                })),

                certificates: data.certificates.map(item => ({
                    ...item,
                    _key: `certificate-${item.id ?? crypto.randomUUID()}`
                })),

                skills: data.skills.map(item => ({
                    ...item,
                    _key: `skill-${item.id ?? crypto.randomUUID()}`
                })),

                languages: data.languages.map(item => ({
                    ...item,
                    _key: `language-${item.id ?? crypto.randomUUID()}`
                })),


                addExperience() {

                    this.experiences.push({
                        id: '',
                        position: '',
                        company: '',
                        start_year: '',
                        end_year: '',
                        description: '',
                        _key: `experience-${crypto.randomUUID()}`
                    });

                },


                removeExperience(index) {
                    this.experiences.splice(index, 1);
                },


                addEducation() {

                    this.educations.push({
                        id: '',
                        institution: '',
                        field_of_study: '',
                        start_year: '',
                        end_year: '',
                        _key: `education-${crypto.randomUUID()}`
                    });

                },


                removeEducation(index) {
                    this.educations.splice(index, 1);
                },


                addCertificate() {

                    this.certificates.push({
                        id: '',
                        name: '',
                        issuer: '',
                        year: '',
                        credential_url: '',
                        _key: `certificate-${crypto.randomUUID()}`
                    });

                },


                removeCertificate(index) {
                    this.certificates.splice(index, 1);
                },


                addSkill() {

                    this.skills.push({
                        id: '',
                        name: '',
                        _key: `skill-${crypto.randomUUID()}`
                    });

                },


                removeSkill(index) {
                    this.skills.splice(index, 1);
                },


                addLanguage() {

                    this.languages.push({
                        id: '',
                        language: '',
                        level: '',
                        _key: `language-${crypto.randomUUID()}`
                    });

                },


                removeLanguage(index) {
                    this.languages.splice(index, 1);
                }

            }));

        });
    </script>

</x-layouts.freelancer>