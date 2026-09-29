<x-layouts.freelancer title="Edit Profil">

<br>
<style>
    [x-cloak] {
        display: none !important;
    }

    @keyframes prokerjaProfileFadeUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .prokerja-profile-section {
        animation: prokerjaProfileFadeUp .42s ease-out both;
    }

    .prokerja-delay-1 {
        animation-delay: .04s;
    }

    .prokerja-delay-2 {
        animation-delay: .08s;
    }

    .prokerja-delay-3 {
        animation-delay: .12s;
    }

    .prokerja-delay-4 {
        animation-delay: .16s;
    }

    .prokerja-delay-5 {
        animation-delay: .20s;
    }

    .prokerja-input {
        width: 100%;
        min-width: 0;
        transition:
            border-color .2s ease,
            box-shadow .2s ease,
            background-color .2s ease;
    }

    .prokerja-input:focus {
        border-color: #2563EB;
        background-color: #FFFFFF;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .prokerja-upload {
        min-width: 0;
        transition:
            border-color .2s ease,
            background-color .2s ease;
    }

    .prokerja-upload:hover {
        border-color: #BFDBFE;
        background-color: #F8FAFF;
    }

    .prokerja-add-button {
        transition:
            transform .2s ease,
            background-color .2s ease,
            border-color .2s ease;
    }

    .prokerja-add-button:hover {
        transform: translateY(-1px);
    }

    .prokerja-danger-button {
        transition:
            background-color .2s ease,
            border-color .2s ease,
            color .2s ease;
    }

    .prokerja-save-bar {
        padding-bottom: env(safe-area-inset-bottom);
    }

    input,
    textarea,
    select,
    button {
        -webkit-tap-highlight-color: transparent;
    }

    @media (max-width: 1023px) {
        .prokerja-profile-section {
            animation-duration: .32s;
        }
    }

    @media (max-width: 640px) {
        .prokerja-profile-section {
            border-radius: 16px;
        }

        .prokerja-input {
            font-size: 16px;
        }

        .prokerja-upload input[type="file"] {
            max-width: 100%;
            overflow: hidden;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .prokerja-profile-section,
        .prokerja-input,
        .prokerja-upload,
        .prokerja-add-button,
        .prokerja-danger-button {
            animation: none !important;
            transition: none !important;
        }
    }
</style>


<div
    class="mx-auto w-full max-w-5xl px-3 pb-32 sm:px-4 lg:px-0"
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
    {{-- TOP ACTION --}}
    {{-- ====================================================== --}}
    <div class="mb-4 flex items-center justify-end sm:mb-5">
        <a
            href="{{ route('freelancer.profile.show') }}"
            class="inline-flex w-auto items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>


    {{-- ====================================================== --}}
    {{-- ERROR --}}
    {{-- ====================================================== --}}
    @if ($errors->any())

        <div
            class="prokerja-profile-section mb-4 flex items-start gap-3 rounded-2xl border border-red-100 bg-red-50 px-4 py-4 sm:mb-5 sm:px-5"
        >

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-red-600 shadow-sm">
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>

            <div class="min-w-0">

                <p class="text-sm font-semibold text-red-700">
                    Ada beberapa data yang perlu diperbaiki.
                </p>

                <ul class="mt-2 space-y-1 text-sm leading-5 text-red-600">
                    @foreach ($errors->all() as $error)
                        <li class="break-words">
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>

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
        class="space-y-4 sm:space-y-5"
    >

        @csrf
        @method('PATCH')


        {{-- ================================================== --}}
        {{-- PHOTO + COVER --}}
        {{-- ================================================== --}}
        <section
            class="grid gap-4 lg:grid-cols-2 lg:gap-5"
        >

            {{-- ================================================= --}}
            {{-- PHOTO --}}
            {{-- ================================================= --}}
            <div
                class="prokerja-profile-section prokerja-delay-1 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
            >

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i class="bi bi-person-bounding-box"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-base font-semibold text-slate-900">
                            Foto Profil
                        </h2>

                        <p class="mt-0.5 text-sm leading-5 text-slate-400">
                            Gunakan foto yang jelas dan profesional.
                        </p>

                    </div>

                </div>


                <div class="mt-5">

                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                        {{-- AVATAR --}}
                        <div class="mx-auto h-24 w-24 shrink-0 overflow-hidden rounded-full border-4 border-blue-50 bg-slate-50 ring-1 ring-blue-100 sm:mx-0 sm:h-28 sm:w-28">

                            @if ($freelancerProfile->avatar)

                                <img
                                    src="{{ asset('storage/' . $freelancerProfile->avatar) }}"
                                    alt="{{ $user->name }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <div class="flex h-full w-full items-center justify-center">

                                    <span class="text-3xl font-semibold text-blue-600">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>

                                </div>

                            @endif

                        </div>


                        {{-- UPLOAD --}}
                        <div class="min-w-0 flex-1">

                            <label class="text-sm font-semibold text-slate-700">
                                Upload foto baru
                            </label>

                            <div class="prokerja-upload mt-2 overflow-hidden rounded-xl border border-slate-200 bg-slate-50 p-2.5">

                                <input
                                    type="file"
                                    name="avatar"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="block w-full min-w-0 text-xs text-slate-500 file:mr-2 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2.5 file:text-xs file:font-semibold file:text-blue-700 hover:file:bg-blue-100 sm:text-sm"
                                >

                            </div>

                            <p class="mt-2 text-xs leading-5 text-slate-400">
                                JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- COVER --}}
            {{-- ================================================= --}}
            <div
                class="prokerja-profile-section prokerja-delay-1 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6"
            >

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i class="bi bi-card-image"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-base font-semibold text-slate-900">
                            Cover Profil
                        </h2>

                        <p class="mt-0.5 text-sm leading-5 text-slate-400">
                            Banner yang tampil di bagian atas profil.
                        </p>

                    </div>

                </div>


                @if ($freelancerProfile->cover_image)

                    <div class="mt-5 overflow-hidden rounded-xl border border-slate-200 bg-slate-100">

                        <img
                            src="{{ asset('storage/' . $freelancerProfile->cover_image) }}"
                            alt="Cover profil"
                            class="block h-32 w-full object-cover sm:h-44"
                        >

                    </div>

                @else

                    <div class="mt-5 flex h-32 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 sm:h-44">

                        <div class="text-center">

                            <i class="bi bi-image text-2xl text-slate-300"></i>

                            <p class="mt-2 text-xs text-slate-400">
                                Belum ada cover
                            </p>

                        </div>

                    </div>

                @endif


                <div class="mt-4">

                    <label class="text-sm font-semibold text-slate-700">
                        Upload cover baru
                    </label>

                    <div class="prokerja-upload mt-2 overflow-hidden rounded-xl border border-slate-200 bg-slate-50 p-2.5">

                        <input
                            type="file"
                            name="cover_image"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full min-w-0 text-xs text-slate-500 file:mr-2 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2.5 file:text-xs file:font-semibold file:text-blue-700 hover:file:bg-blue-100 sm:text-sm"
                        >

                    </div>

                    <p class="mt-2 text-xs leading-5 text-slate-400">
                        JPG, JPEG, PNG, atau WEBP. Maksimal 10 MB.
                    </p>

                </div>

            </div>

        </section>


        {{-- ================================================== --}}
        {{-- PROFILE INFORMATION --}}
        {{-- ================================================== --}}
        <section
            class="prokerja-profile-section prokerja-delay-2 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 lg:p-7"
        >

            <div class="flex items-start gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="bi bi-person-lines-fill"></i>
                </div>

                <div class="min-w-0">

                    <h2 class="text-base font-semibold text-slate-900">
                        Informasi Profil
                    </h2>

                    <p class="mt-0.5 text-sm leading-5 text-slate-400">
                        Informasi utama yang akan dilihat client.
                    </p>

                </div>

            </div>


            <div class="mt-5 grid gap-4 sm:gap-5 md:grid-cols-2">

                {{-- USERNAME --}}
                <div class="min-w-0">

                    <label
                        for="username"
                        class="text-sm font-semibold text-slate-700"
                    >
                        Username
                    </label>

                    <div class="relative mt-2">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold text-slate-400">
                            @
                        </span>

                        <input
                            id="username"
                            type="text"
                            name="username"
                            value="{{ old('username', $freelancerProfile->username) }}"
                            required
                            maxlength="50"
                            autocomplete="username"
                            class="prokerja-input rounded-xl border border-slate-200 bg-slate-50/70 py-3.5 pl-9 pr-4 text-slate-900 outline-none placeholder:text-slate-300"
                        >

                    </div>

                </div>


                {{-- HEADLINE --}}
                <div class="min-w-0">

                    <label
                        for="headline"
                        class="text-sm font-semibold text-slate-700"
                    >
                        Headline
                    </label>

                    <input
                        id="headline"
                        type="text"
                        name="headline"
                        value="{{ old('headline', $freelancerProfile->headline) }}"
                        placeholder="Contoh: Content Writer & SEO Specialist"
                        maxlength="255"
                        class="prokerja-input mt-2 rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-slate-900 outline-none placeholder:text-slate-300"
                    >

                </div>


                {{-- BIO --}}
                <div class="min-w-0 md:col-span-2">

                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                        <label
                            for="bio"
                            class="text-sm font-semibold text-slate-700"
                        >
                            Bio
                        </label>

                        <span class="text-[11px] text-slate-400">
                            Tentang diri dan kemampuan kamu
                        </span>

                    </div>

                    <textarea
                        id="bio"
                        name="bio"
                        rows="6"
                        placeholder="Ceritakan pengalaman, keahlian, dan layanan yang kamu tawarkan..."
                        class="prokerja-input mt-2 min-h-[150px] resize-y rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 leading-6 text-slate-900 outline-none placeholder:text-slate-300 sm:min-h-[160px]"
                    >{{ old('bio', $freelancerProfile->bio) }}</textarea>

                </div>


                {{-- LOCATION --}}
                <div class="min-w-0">

                    <label
                        for="location"
                        class="text-sm font-semibold text-slate-700"
                    >
                        Lokasi
                    </label>

                    <div class="relative mt-2">

                        <i class="bi bi-geo-alt pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                        <input
                            id="location"
                            type="text"
                            name="location"
                            value="{{ old('location', $freelancerProfile->location) }}"
                            placeholder="Contoh: Yogyakarta, Indonesia"
                            maxlength="255"
                            autocomplete="address-level2"
                            class="prokerja-input rounded-xl border border-slate-200 bg-slate-50/70 py-3.5 pl-11 pr-4 text-slate-900 outline-none placeholder:text-slate-300"
                        >

                    </div>

                </div>


                {{-- WEBSITE --}}
                <div class="min-w-0">

                    <label
                        for="website"
                        class="text-sm font-semibold text-slate-700"
                    >
                        Website
                    </label>

                    <div class="relative mt-2">

                        <i class="bi bi-globe2 pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                        <input
                            id="website"
                            type="url"
                            name="website"
                            value="{{ old('website', $freelancerProfile->website) }}"
                            placeholder="https://websitekamu.com"
                            class="prokerja-input rounded-xl border border-slate-200 bg-slate-50/70 py-3.5 pl-11 pr-4 text-slate-900 outline-none placeholder:text-slate-300"
                        >

                    </div>

                </div>

            </div>


            {{-- AVAILABILITY --}}
            <div class="mt-5 rounded-2xl border border-blue-100 bg-blue-50/70 p-4 sm:p-5">

                <div class="flex items-center justify-between gap-4">

                    <div class="min-w-0">

                        <p class="text-sm font-semibold text-slate-900">
                            Status tersedia
                        </p>

                        <p class="mt-1 max-w-xl text-xs leading-5 text-slate-500 sm:text-sm">
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

                        <div class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-blue-600"></div>

                        <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"></div>

                    </label>

                </div>

            </div>

        </section>


        {{-- ================================================== --}}
        {{-- EXPERIENCE --}}
        {{-- ================================================== --}}
        <section
            class="prokerja-profile-section prokerja-delay-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 lg:p-7"
        >

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-base font-semibold text-slate-900">
                            Pengalaman
                        </h2>

                        <p class="mt-0.5 text-sm leading-5 text-slate-400">
                            Tambahkan pengalaman profesional yang relevan.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    @click="addExperience()"
                    class="prokerja-add-button inline-flex w-auto shrink-0 items-center justify-center gap-2 self-start rounded-xl border border-blue-100 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-100 sm:self-auto"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Pengalaman
                </button>

            </div>


            <div class="mt-5 space-y-4">

                <template
                    x-for="(experience, index) in experiences"
                    :key="experience._key"
                >

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">

                        <input
                            type="hidden"
                            :name="`experiences[${index}][id]`"
                            x-model="experience.id"
                        >


                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <div class="inline-flex items-center gap-2 rounded-full bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-blue-600 ring-1 ring-slate-200">
                                    Pengalaman
                                    <span x-text="index + 1"></span>
                                </div>

                                <p class="mt-2 text-xs leading-5 text-slate-400">
                                    Informasi pekerjaan atau pengalaman profesional.
                                </p>

                            </div>


                            <button
                                type="button"
                                @click="removeExperience(index)"
                                class="prokerja-danger-button flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-red-100 bg-white text-red-500 hover:border-red-200 hover:bg-red-50"
                                title="Hapus pengalaman"
                            >
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>


                        <div class="mt-5 grid gap-4 md:grid-cols-2">

                            <div class="min-w-0">

                                <label class="text-xs font-semibold text-slate-600">
                                    Posisi
                                </label>

                                <input
                                    type="text"
                                    :name="`experiences[${index}][position]`"
                                    x-model="experience.position"
                                    required
                                    placeholder="Contoh: UI/UX Designer"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none placeholder:text-slate-300"
                                >

                            </div>


                            <div class="min-w-0">

                                <label class="text-xs font-semibold text-slate-600">
                                    Perusahaan
                                </label>

                                <input
                                    type="text"
                                    :name="`experiences[${index}][company]`"
                                    x-model="experience.company"
                                    placeholder="Contoh: ABC Studio"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none placeholder:text-slate-300"
                                >

                            </div>


                            <div class="min-w-0">

                                <label class="text-xs font-semibold text-slate-600">
                                    Tahun Mulai
                                </label>

                                <input
                                    type="number"
                                    :name="`experiences[${index}][start_year]`"
                                    x-model="experience.start_year"
                                    min="1900"
                                    max="2100"
                                    required
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none"
                                >

                            </div>


                            <div class="min-w-0">

                                <label class="text-xs font-semibold text-slate-600">
                                    Tahun Selesai
                                </label>

                                <input
                                    type="number"
                                    :name="`experiences[${index}][end_year]`"
                                    x-model="experience.end_year"
                                    min="1900"
                                    max="2100"
                                    placeholder="Kosongkan jika masih bekerja"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none placeholder:text-slate-300"
                                >

                            </div>


                            <div class="min-w-0 md:col-span-2">

                                <label class="text-xs font-semibold text-slate-600">
                                    Deskripsi
                                </label>

                                <textarea
                                    :name="`experiences[${index}][description]`"
                                    x-model="experience.description"
                                    rows="4"
                                    placeholder="Jelaskan tanggung jawab atau pengalaman kamu..."
                                    class="prokerja-input mt-1.5 min-h-[120px] resize-y rounded-xl border border-slate-200 bg-white px-3.5 py-3 leading-6 text-slate-900 outline-none placeholder:text-slate-300"
                                ></textarea>

                            </div>

                        </div>

                    </div>

                </template>


                <div
                    x-show="experiences.length === 0"
                    x-cloak
                    class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center"
                >

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                        <i class="bi bi-briefcase text-xl"></i>
                    </div>

                    <p class="mt-3 text-sm font-semibold text-slate-700">
                        Belum ada pengalaman
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Tambahkan pengalaman kerja untuk memperkuat profil kamu.
                    </p>

                    <button
                        type="button"
                        @click="addExperience()"
                        class="mt-4 text-sm font-semibold text-blue-600"
                    >
                        + Tambah pengalaman
                    </button>

                </div>

            </div>

        </section>


        {{-- ================================================== --}}
        {{-- EDUCATION --}}
        {{-- ================================================== --}}
        <section
            class="prokerja-profile-section prokerja-delay-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 lg:p-7"
        >

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-base font-semibold text-slate-900">
                            Pendidikan
                        </h2>

                        <p class="mt-0.5 text-sm leading-5 text-slate-400">
                            Tambahkan riwayat pendidikan kamu.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    @click="addEducation()"
                    class="prokerja-add-button inline-flex w-auto shrink-0 items-center justify-center gap-2 self-start rounded-xl border border-blue-100 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-100 sm:self-auto"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Pendidikan
                </button>

            </div>


            <div class="mt-5 space-y-4">

                <template
                    x-for="(education, index) in educations"
                    :key="education._key"
                >

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">

                        <input
                            type="hidden"
                            :name="`educations[${index}][id]`"
                            x-model="education.id"
                        >


                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <div class="inline-flex items-center gap-2 rounded-full bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-blue-600 ring-1 ring-slate-200">
                                    Pendidikan
                                    <span x-text="index + 1"></span>
                                </div>

                            </div>


                            <button
                                type="button"
                                @click="removeEducation(index)"
                                class="prokerja-danger-button flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-red-100 bg-white text-red-500 hover:border-red-200 hover:bg-red-50"
                                title="Hapus pendidikan"
                            >
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>


                        <div class="mt-5 grid gap-4 md:grid-cols-2">

                            <div class="min-w-0 md:col-span-2">

                                <label class="text-xs font-semibold text-slate-600">
                                    Institusi
                                </label>

                                <input
                                    type="text"
                                    :name="`educations[${index}][institution]`"
                                    x-model="education.institution"
                                    required
                                    placeholder="Contoh: Universitas Gadjah Mada"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none placeholder:text-slate-300"
                                >

                            </div>


                            <div class="min-w-0 md:col-span-2">

                                <label class="text-xs font-semibold text-slate-600">
                                    Bidang Studi
                                </label>

                                <input
                                    type="text"
                                    :name="`educations[${index}][field_of_study]`"
                                    x-model="education.field_of_study"
                                    placeholder="Contoh: Sistem Informasi"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none placeholder:text-slate-300"
                                >

                            </div>


                            <div class="min-w-0">

                                <label class="text-xs font-semibold text-slate-600">
                                    Tahun Mulai
                                </label>

                                <input
                                    type="number"
                                    :name="`educations[${index}][start_year]`"
                                    x-model="education.start_year"
                                    min="1900"
                                    max="2100"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none"
                                >

                            </div>


                            <div class="min-w-0">

                                <label class="text-xs font-semibold text-slate-600">
                                    Tahun Selesai
                                </label>

                                <input
                                    type="number"
                                    :name="`educations[${index}][end_year]`"
                                    x-model="education.end_year"
                                    min="1900"
                                    max="2100"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none"
                                >

                            </div>

                        </div>

                    </div>

                </template>


                <div
                    x-show="educations.length === 0"
                    x-cloak
                    class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center"
                >

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                        <i class="bi bi-mortarboard text-xl"></i>
                    </div>

                    <p class="mt-3 text-sm font-semibold text-slate-700">
                        Belum ada pendidikan
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Tambahkan sekolah atau perguruan tinggi kamu.
                    </p>

                    <button
                        type="button"
                        @click="addEducation()"
                        class="mt-4 text-sm font-semibold text-blue-600"
                    >
                        + Tambah pendidikan
                    </button>

                </div>

            </div>

        </section>


        {{-- ================================================== --}}
        {{-- CERTIFICATES --}}
        {{-- ================================================== --}}
        <section
            class="prokerja-profile-section prokerja-delay-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 lg:p-7"
        >

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i class="bi bi-award-fill"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-base font-semibold text-slate-900">
                            Sertifikat
                        </h2>

                        <p class="mt-0.5 text-sm leading-5 text-slate-400">
                            Tambahkan sertifikat dan kredensial profesional.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    @click="addCertificate()"
                    class="prokerja-add-button inline-flex w-auto shrink-0 items-center justify-center gap-2 self-start rounded-xl border border-blue-100 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-100 sm:self-auto"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Sertifikat
                </button>

            </div>


            <div class="mt-5 space-y-4">

                <template
                    x-for="(certificate, index) in certificates"
                    :key="certificate._key"
                >

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">

                        <input
                            type="hidden"
                            :name="`certificates[${index}][id]`"
                            x-model="certificate.id"
                        >


                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <div class="inline-flex items-center gap-2 rounded-full bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-blue-600 ring-1 ring-slate-200">
                                    Sertifikat
                                    <span x-text="index + 1"></span>
                                </div>

                            </div>


                            <button
                                type="button"
                                @click="removeCertificate(index)"
                                class="prokerja-danger-button flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-red-100 bg-white text-red-500 hover:border-red-200 hover:bg-red-50"
                                title="Hapus sertifikat"
                            >
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>


                        <div class="mt-5 grid gap-4 md:grid-cols-2">

                            <div class="min-w-0 md:col-span-2">

                                <label class="text-xs font-semibold text-slate-600">
                                    Nama Sertifikat
                                </label>

                                <input
                                    type="text"
                                    :name="`certificates[${index}][name]`"
                                    x-model="certificate.name"
                                    required
                                    placeholder="Contoh: Google UX Design Certificate"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none placeholder:text-slate-300"
                                >

                            </div>


                            <div class="min-w-0">

                                <label class="text-xs font-semibold text-slate-600">
                                    Penerbit
                                </label>

                                <input
                                    type="text"
                                    :name="`certificates[${index}][issuer]`"
                                    x-model="certificate.issuer"
                                    placeholder="Contoh: Google"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none placeholder:text-slate-300"
                                >

                            </div>


                            <div class="min-w-0">

                                <label class="text-xs font-semibold text-slate-600">
                                    Tahun
                                </label>

                                <input
                                    type="number"
                                    :name="`certificates[${index}][year]`"
                                    x-model="certificate.year"
                                    min="1900"
                                    max="2100"
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none"
                                >

                            </div>


                            <div class="min-w-0 md:col-span-2">

                                <label class="text-xs font-semibold text-slate-600">
                                    Link Sertifikat
                                </label>

                                <input
                                    type="url"
                                    :name="`certificates[${index}][credential_url]`"
                                    x-model="certificate.credential_url"
                                    placeholder="https://..."
                                    class="prokerja-input mt-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none placeholder:text-slate-300"
                                >

                            </div>

                        </div>

                    </div>

                </template>


                <div
                    x-show="certificates.length === 0"
                    x-cloak
                    class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center"
                >

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                        <i class="bi bi-award text-xl"></i>
                    </div>

                    <p class="mt-3 text-sm font-semibold text-slate-700">
                        Belum ada sertifikat
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Tambahkan sertifikat yang mendukung kompetensi kamu.
                    </p>

                    <button
                        type="button"
                        @click="addCertificate()"
                        class="mt-4 text-sm font-semibold text-blue-600"
                    >
                        + Tambah sertifikat
                    </button>

                </div>

            </div>

        </section>


        {{-- ================================================== --}}
        {{-- SKILLS --}}
        {{-- ================================================== --}}
        <section
            class="prokerja-profile-section prokerja-delay-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 lg:p-7"
        >

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i class="bi bi-stars"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-base font-semibold text-slate-900">
                            Keahlian
                        </h2>

                        <p class="mt-0.5 text-sm leading-5 text-slate-400">
                            Tambahkan semua keahlian yang kamu kuasai.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    @click="addSkill()"
                    class="prokerja-add-button inline-flex w-auto shrink-0 items-center justify-center gap-2 self-start rounded-xl border border-blue-100 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-100 sm:self-auto"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Keahlian
                </button>

            </div>


            <div class="mt-5 grid gap-3 sm:grid-cols-2">

                <template
                    x-for="(skill, index) in skills"
                    :key="skill._key"
                >

                    <div class="flex min-w-0 items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">

                        <input
                            type="hidden"
                            :name="`skills[${index}][id]`"
                            x-model="skill.id"
                        >


                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-blue-500 shadow-sm">
                            <i class="bi bi-lightning-charge"></i>
                        </div>


                        <input
                            type="text"
                            :name="`skills[${index}][name]`"
                            x-model="skill.name"
                            required
                            placeholder="Contoh: Laravel"
                            class="prokerja-input min-w-0 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-slate-900 outline-none placeholder:text-slate-300"
                        >


                        <button
                            type="button"
                            @click="removeSkill(index)"
                            class="prokerja-danger-button flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-red-500 hover:bg-red-50"
                            title="Hapus keahlian"
                        >
                            <i class="bi bi-trash"></i>
                        </button>

                    </div>

                </template>

            </div>


            <div
                x-show="skills.length === 0"
                x-cloak
                class="mt-5 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center"
            >

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                    <i class="bi bi-stars text-xl"></i>
                </div>

                <p class="mt-3 text-sm font-semibold text-slate-700">
                    Belum ada keahlian
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Tambahkan skill agar client mengetahui kemampuan kamu.
                </p>

                <button
                    type="button"
                    @click="addSkill()"
                    class="mt-4 text-sm font-semibold text-blue-600"
                >
                    + Tambah keahlian
                </button>

            </div>

        </section>


        {{-- ================================================== --}}
        {{-- LANGUAGES --}}
        {{-- ================================================== --}}
        <section
            class="prokerja-profile-section prokerja-delay-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 lg:p-7"
        >

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i class="bi bi-translate"></i>
                    </div>

                    <div class="min-w-0">

                        <h2 class="text-base font-semibold text-slate-900">
                            Bahasa
                        </h2>

                        <p class="mt-0.5 text-sm leading-5 text-slate-400">
                            Tambahkan bahasa dan tingkat kemahirannya.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    @click="addLanguage()"
                    class="prokerja-add-button inline-flex w-auto shrink-0 items-center justify-center gap-2 self-start rounded-xl border border-blue-100 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-100 sm:self-auto"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Bahasa
                </button>

            </div>


            <div class="mt-5 space-y-3">

                <template
                    x-for="(language, index) in languages"
                    :key="language._key"
                >

                    <div class="grid gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 md:grid-cols-[minmax(0,1fr)_200px_auto]">

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
                            class="prokerja-input min-w-0 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none placeholder:text-slate-300"
                        >


                        <select
                            :name="`languages[${index}][level]`"
                            x-model="language.level"
                            class="prokerja-input min-w-0 rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-slate-900 outline-none"
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
                            class="flex h-11 w-full items-center justify-center rounded-xl border border-red-100 bg-white px-4 text-red-500 hover:border-red-200 hover:bg-red-50 md:w-11"
                            title="Hapus bahasa"
                        >
                            <i class="bi bi-trash"></i>
                        </button>

                    </div>

                </template>

            </div>


            <div
                x-show="languages.length === 0"
                x-cloak
                class="mt-5 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center"
            >

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                    <i class="bi bi-translate text-xl"></i>
                </div>

                <p class="mt-3 text-sm font-semibold text-slate-700">
                    Belum ada bahasa
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Tambahkan bahasa yang kamu kuasai.
                </p>

                <button
                    type="button"
                    @click="addLanguage()"
                    class="mt-4 text-sm font-semibold text-blue-600"
                >
                    + Tambah bahasa
                </button>

            </div>

        </section>


        {{-- ================================================== --}}
        {{-- SAVE BAR --}}
        {{-- ================================================== --}}
        <div class="prokerja-save-bar sticky bottom-2 z-30 pt-1 sm:bottom-4">

            <div class="rounded-2xl border border-slate-200 bg-white/95 p-3 shadow-xl backdrop-blur-md sm:p-4">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div class="hidden min-w-0 items-center gap-3 sm:flex">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i class="bi bi-cloud-check"></i>
                        </div>

                        <div class="min-w-0">

                            <p class="text-sm font-semibold text-slate-800">
                                Simpan perubahan profil
                            </p>

                            <p class="mt-0.5 truncate text-xs text-slate-400">
                                Semua perubahan akan disimpan sekaligus.
                            </p>

                        </div>

                    </div>


                    <div class="flex w-full gap-2 sm:w-auto">

                        <a
                            href="{{ route('freelancer.profile.show') }}"
                            class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 sm:flex-none sm:px-5"
                        >
                            Batal
                        </a>


                        <button
                            type="submit"
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 sm:flex-none sm:px-6"
                        >
                            <i class="bi bi-check-lg"></i>
                            Simpan Perubahan
                        </button>

                    </div>

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

            experiences: data.experiences.map((item) => ({
                ...item,
                _key: `experience-${item.id ?? crypto.randomUUID()}`
            })),

            educations: data.educations.map((item) => ({
                ...item,
                _key: `education-${item.id ?? crypto.randomUUID()}`
            })),

            certificates: data.certificates.map((item) => ({
                ...item,
                _key: `certificate-${item.id ?? crypto.randomUUID()}`
            })),

            skills: data.skills.map((item) => ({
                ...item,
                _key: `skill-${item.id ?? crypto.randomUUID()}`
            })),

            languages: data.languages.map((item) => ({
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
