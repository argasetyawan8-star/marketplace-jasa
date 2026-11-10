
<x-layouts.freelancer title="Pengajuan Freelancer - ProKerja">
    @php
        $user = auth()->user();

        $onboardingSession = session('prokerja_freelancer_onboarding', []);

        $status = $verification?->status
            ?? session('prokerja_freelancer_status');

        $onboardingDefaults = [
            'name' => $user?->name,
            'username' => $freelancerProfile?->username,
            'headline' => $freelancerProfile?->headline,
            'location' => $freelancerProfile?->location,
            'phone' => $user?->phone,
            'identity_type' => $verification?->identity_type,
            'identity_number' => $verification?->identity_number,
            'identity_document_private' => $verification?->identity_document_path,
            'bank_name' => $verification?->bank_name,
            'bank_account_name' => $verification?->bank_account_name,
            'bank_account_number' => $verification?->bank_account_number,
        ];

        $onboardingDefaults = array_filter(
            $onboardingDefaults,
            fn ($value) => $value !== null
        );

        $onboarding = array_merge(
            $onboardingDefaults,
            is_array($onboardingSession) ? $onboardingSession : []
        );

        $step = max(
            1,
            min((int) request('step', session('prokerja_freelancer_onboarding_step', 1)), 5)
        );

        $steps = [
            1 => ['title' => 'Profil Freelancer', 'description' => 'Informasi profil'],
            2 => ['title' => 'Verifikasi Identitas', 'description' => 'Data KTP'],
            3 => ['title' => 'Informasi Kontak', 'description' => 'Kontak dan alamat'],
            4 => ['title' => 'Rekening Bank', 'description' => 'Informasi rekening'],
            5 => ['title' => 'Portfolio', 'description' => 'Kirim pengajuan'],
        ];

        $isPending = $status === 'pending';
        $isRejected = $status === 'rejected';

        if ($isPending) {
            $step = 5;
        }

        $currentStep = $steps[$step] ?? $steps[1];

        $hasIdentityDocument = filled(data_get($onboarding, 'identity_document'))
            || filled($verification?->identity_document_path);

        $rejectionReason = $verification?->rejection_reason;

        $inputClass = 'w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10';
        $labelClass = 'mb-2 block text-sm font-semibold text-slate-700';
        $helpClass = 'mt-1.5 text-xs leading-5 text-slate-500';
    @endphp

    <div class="min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl">

            {{-- HEADER --}}
            <div class="mb-8">
                <a
                    href="{{ route('marketplace.home') }}"
                    class="mb-5 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600"
                >
                    <span aria-hidden="true">&larr;</span>
                    Kembali ke beranda
                </a>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-blue-600">
                            ProKerja Freelancer
                        </p>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            {{ $isRejected ? 'Perbaiki Pengajuan Freelancer' : 'Pengajuan Freelancer' }}
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">
                            Lengkapi informasi profil, identitas, kontak, rekening bank,
                            dan portfolio untuk mengajukan diri sebagai freelancer.
                        </p>
                    </div>

                    @if ($isPending)
                        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                            Sedang diperiksa
                        </span>
                    @elseif ($isRejected)
                        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700">
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            Perlu diperbaiki
                        </span>
                    @else
                        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                            Belum diajukan
                        </span>
                    @endif
                </div>
            </div>

            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div role="status" class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div role="alert" class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4">
                    <p class="font-semibold text-red-800">
                        Ada data yang perlu diperiksa.
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- REJECTION REASON --}}
            @if ($isRejected)
                <section class="mb-6 overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">
                    <div class="flex items-start gap-3 border-b border-red-100 bg-red-50 p-5 sm:p-6">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-lg text-red-700">
                            !
                        </div>

                        <div>
                            <h2 class="font-bold text-red-900">
                                Pengajuan perlu diperbaiki
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-red-800">
                                Admin telah meninjau pengajuan kamu. Periksa alasan di bawah,
                                perbaiki data yang diperlukan, lalu kirim ulang pengajuan.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6">
                        <p class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Alasan penolakan dari admin
                        </p>

                        <div class="whitespace-pre-line rounded-xl border border-red-100 bg-red-50/50 p-4 text-sm leading-7 text-slate-700">{{ $rejectionReason ?: 'Alasan penolakan belum tersedia. Silakan periksa kembali data pengajuan kamu.' }}</div>

                        @if ($verification?->reviewed_at)
                            <p class="mt-3 text-xs text-slate-500">
                                Ditinjau pada
                                {{ $verification->reviewed_at->format('d M Y, H:i') }}
                            </p>
                        @endif
                    </div>
                </section>
            @endif

            {{-- PENDING SCREEN --}}
            @if ($isPending)
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 p-6 sm:p-8">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-50 text-3xl text-amber-600">
                            &#9203;
                        </div>

                        <div class="mt-5 text-center">
                            <h2 class="text-xl font-bold text-slate-900">
                                Pengajuan sedang ditinjau
                            </h2>

                            <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-slate-500">
                                Data kamu sudah dikirim. Saat ini admin sedang memeriksa
                                kelengkapan dan kesesuaian informasi yang diberikan.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 sm:p-8">
                        <h3 class="mb-4 font-bold text-slate-900">
                            Ringkasan pengajuan
                        </h3>

                        <dl class="divide-y divide-slate-100">
                            <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm text-slate-500">Nama lengkap</dt>
                                <dd class="break-words text-sm font-medium text-slate-800 sm:col-span-2">
                                    {{ $verification?->full_name ?: data_get($onboarding, 'name', $user?->name) ?: '-' }}
                                </dd>
                            </div>

                            <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm text-slate-500">Jenis identitas</dt>
                                <dd class="text-sm font-medium text-slate-800 sm:col-span-2">
                                    {{ $verification?->identity_type ?: data_get($onboarding, 'identity_type', '-') }}
                                </dd>
                            </div>

                            <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm text-slate-500">Nomor identitas</dt>
                                <dd class="break-words text-sm font-medium text-slate-800 sm:col-span-2">
                                    {{ $verification?->identity_number ?: data_get($onboarding, 'identity_number', '-') }}
                                </dd>
                            </div>

                            <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm text-slate-500">Rekening bank</dt>
                                <dd class="break-words text-sm font-medium text-slate-800 sm:col-span-2">
                                    {{ $verification?->bank_name ?: data_get($onboarding, 'bank_name', '-') }}
                                </dd>
                            </div>

                            <div class="grid gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm text-slate-500">Status</dt>
                                <dd class="text-sm font-semibold text-amber-700 sm:col-span-2">
                                    Menunggu pemeriksaan admin
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50 p-4 text-sm leading-6 text-blue-800">
                            Kamu tidak perlu mengirim pengajuan berulang kali.
                            Tunggu notifikasi hasil pemeriksaan dari admin.
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a
                                href="{{ route('marketplace.home') }}"
                                class="inline-flex min-h-11 items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                Kembali ke beranda
                            </a>

                            <a
                                href="{{ route('notifications.index') }}"
                                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Lihat notifikasi
                            </a>
                        </div>
                    </div>
                </section>
            @else
                {{-- STEP NAVIGATION --}}
                <section class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
                    <div class="mb-5 flex items-center justify-between gap-3">
                        <div>
                            <h2 class="font-bold text-slate-900">
                                Tahapan pengajuan
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Langkah {{ $step }} dari 5
                            </p>
                        </div>

                        <span class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700">
                            {{ (int) (($step / 5) * 100) }}%
                        </span>
                    </div>

                    <div class="mb-5 h-2 overflow-hidden rounded-full bg-slate-100">
                        <div
                            class="h-full rounded-full bg-blue-600 transition-all duration-300"
                            style="width: {{ ($step / 5) * 100 }}%"
                        ></div>
                    </div>

                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-5">
                        @foreach ($steps as $number => $item)
                            <a
                                href="{{ route('freelancer.onboarding', ['step' => $number]) }}"
                                class="flex items-center gap-3 rounded-xl border p-3 transition sm:flex-col sm:items-start sm:gap-2
                                    {{ $step === $number
                                        ? 'border-blue-300 bg-blue-50'
                                        : ($step > $number
                                            ? 'border-emerald-200 bg-emerald-50/50'
                                            : 'border-slate-100 bg-white hover:border-slate-200 hover:bg-slate-50') }}"
                            >
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-bold
                                    {{ $step === $number
                                        ? 'bg-blue-600 text-white'
                                        : ($step > $number
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-slate-100 text-slate-500') }}">
                                    {{ $step > $number ? '✓' : $number }}
                                </span>

                                <span class="min-w-0">
                                    <span class="block text-xs font-bold text-slate-800">
                                        {{ $item['title'] }}
                                    </span>

                                    <span class="mt-1 block text-xs text-slate-500">
                                        {{ $item['description'] }}
                                    </span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- FORM --}}
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 p-5 sm:p-7">
                        <p class="text-xs font-bold uppercase tracking-wider text-blue-600">
                            Langkah {{ $step }}
                        </p>

                        <h2 class="mt-2 text-xl font-bold text-slate-900">
                            {{ $currentStep['title'] }}
                        </h2>

                        <p class="mt-1 text-sm leading-6 text-slate-500">
                            {{ $currentStep['description'] }}. Pastikan informasi yang kamu isi benar.
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('freelancer.onboarding.update') }}"
                        enctype="multipart/form-data"
                        class="p-5 sm:p-7"
                    >
                        @csrf

                        <input type="hidden" name="step" value="{{ $step }}">

                        {{-- STEP 1 --}}
                        @if ($step === 1)
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="name" class="{{ $labelClass }}">
                                        Nama lengkap
                                    </label>

                                    <input
                                        id="name"
                                        name="name"
                                        type="text"
                                        required
                                        maxlength="255"
                                        autocomplete="name"
                                        value="{{ old('name', data_get($onboarding, 'name', $user?->name)) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="Masukkan nama lengkap"
                                    >
                                </div>

                                <div>
                                    <label for="username" class="{{ $labelClass }}">
                                        Username freelancer
                                    </label>

                                    <input
                                        id="username"
                                        name="username"
                                        type="text"
                                        required
                                        maxlength="100"
                                        autocomplete="username"
                                        value="{{ old('username', data_get($onboarding, 'username', $freelancerProfile?->username)) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="contoh: argadesign"
                                    >

                                    <p class="{{ $helpClass }}">
                                        Username harus unik.
                                    </p>
                                </div>

                                <div>
                                    <label for="location" class="{{ $labelClass }}">
                                        Lokasi
                                    </label>

                                    <input
                                        id="location"
                                        name="location"
                                        type="text"
                                        required
                                        maxlength="255"
                                        value="{{ old('location', data_get($onboarding, 'location', $freelancerProfile?->location)) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="Kota atau kabupaten"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="headline" class="{{ $labelClass }}">
                                        Headline profesional
                                    </label>

                                    <input
                                        id="headline"
                                        name="headline"
                                        type="text"
                                        required
                                        maxlength="255"
                                        value="{{ old('headline', data_get($onboarding, 'headline', $freelancerProfile?->headline)) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="Contoh: Web Developer dan UI Designer"
                                    >

                                    <p class="{{ $helpClass }}">
                                        Jelaskan secara singkat keahlian utama kamu.
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- STEP 2 --}}
                        @if ($step === 2)
                            <div class="space-y-5">
                                <div>
                                    <label for="identity_type" class="{{ $labelClass }}">
                                        Jenis identitas
                                    </label>

                                    <select
                                        id="identity_type"
                                        name="identity_type"
                                        required
                                        class="{{ $inputClass }}"
                                    >
                                        <option value="KTP"
                                            @selected(old('identity_type', data_get($onboarding, 'identity_type', 'KTP')) === 'KTP')>
                                            KTP
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="identity_number" class="{{ $labelClass }}">
                                        Nomor identitas
                                    </label>

                                    <input
                                        id="identity_number"
                                        name="identity_number"
                                        type="text"
                                        required
                                        minlength="8"
                                        maxlength="30"
                                        inputmode="numeric"
                                        value="{{ old('identity_number', data_get($onboarding, 'identity_number', $verification?->identity_number)) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="Masukkan nomor identitas"
                                    >

                                    <p class="{{ $helpClass }}">
                                        Periksa kembali nomor identitas sebelum melanjutkan.
                                    </p>
                                </div>

                                @if ($hasIdentityDocument)
                                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                                        <p class="font-semibold text-emerald-800">
                                            Dokumen identitas sudah tercatat
                                        </p>

                                        <p class="mt-1 text-sm leading-6 text-emerald-700">
                                            Jika ingin mengganti dokumen, pilih file baru di bawah.
                                            Jika tidak, controller perlu mempertahankan dokumen yang tersimpan
                                            ketika formulir dikirim tanpa unggahan baru.
                                        </p>
                                    </div>
                                @endif

                                <div>
                                    <label for="identity_document" class="{{ $labelClass }}">
                                        Foto KTP {{ $hasIdentityDocument ? '(opsional jika dokumen lama dipertahankan)' : '(wajib)' }}
                                    </label>

                                    <input
                                        id="identity_document"
                                        name="identity_document"
                                        type="file"
                                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                        {{ $hasIdentityDocument ? '' : 'required' }}
                                        class="block w-full rounded-xl border border-slate-200 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-3 file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
                                    >

                                    <p class="{{ $helpClass }}">
                                        Format JPG, JPEG, atau PNG. Ukuran maksimal 4 MB.
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- STEP 3 --}}
                        @if ($step === 3)
                            <div class="space-y-5">
                                <div>
                                    <label for="phone" class="{{ $labelClass }}">
                                        Nomor HP aktif
                                    </label>

                                    <input
                                        id="phone"
                                        name="phone"
                                        type="tel"
                                        required
                                        maxlength="30"
                                        autocomplete="tel"
                                        value="{{ old('phone', data_get($onboarding, 'phone', $user?->phone)) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="Contoh: 08xxxxxxxxxx"
                                    >
                                </div>

                                <div>
                                    <label for="city" class="{{ $labelClass }}">
                                        Kota
                                    </label>

                                    <input
                                        id="city"
                                        name="city"
                                        type="text"
                                        required
                                        maxlength="100"
                                        value="{{ old('city', data_get($onboarding, 'city')) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="Kota tempat tinggal"
                                    >
                                </div>

                                <div>
                                    <label for="address" class="{{ $labelClass }}">
                                        Alamat lengkap
                                    </label>

                                    <textarea
                                        id="address"
                                        name="address"
                                        rows="4"
                                        required
                                        maxlength="1000"
                                        class="{{ $inputClass }}"
                                        placeholder="Masukkan alamat lengkap"
                                    >{{ old('address', data_get($onboarding, 'address')) }}</textarea>
                                </div>
                            </div>
                        @endif

                        {{-- STEP 4 --}}
                        @if ($step === 4)
                            <div class="space-y-5">
                                <div>
                                    <label for="bank_name" class="{{ $labelClass }}">
                                        Nama bank
                                    </label>

                                    <input
                                        id="bank_name"
                                        name="bank_name"
                                        type="text"
                                        required
                                        maxlength="100"
                                        value="{{ old('bank_name', data_get($onboarding, 'bank_name', $verification?->bank_name)) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="Contoh: BCA, BRI, Mandiri"
                                    >
                                </div>

                                <div>
                                    <label for="bank_account_name" class="{{ $labelClass }}">
                                        Nama pemilik rekening
                                    </label>

                                    <input
                                        id="bank_account_name"
                                        name="bank_account_name"
                                        type="text"
                                        required
                                        maxlength="255"
                                        value="{{ old('bank_account_name', data_get($onboarding, 'bank_account_name', $verification?->bank_account_name)) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="Nama sesuai buku rekening"
                                    >
                                </div>

                                <div>
                                    <label for="bank_account_number" class="{{ $labelClass }}">
                                        Nomor rekening
                                    </label>

                                    <input
                                        id="bank_account_number"
                                        name="bank_account_number"
                                        type="text"
                                        required
                                        minlength="5"
                                        maxlength="50"
                                        inputmode="numeric"
                                        value="{{ old('bank_account_number', data_get($onboarding, 'bank_account_number', $verification?->bank_account_number)) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="Masukkan nomor rekening"
                                    >
                                </div>

                                <div class="rounded-xl border border-blue-100 bg-blue-50 p-4 text-sm leading-6 text-blue-800">
                                    Pastikan rekening menggunakan data yang benar agar proses verifikasi
                                    dan pembayaran dapat berjalan lancar.
                                </div>
                            </div>
                        @endif

                        {{-- STEP 5 --}}
                        @if ($step === 5)
                            <div class="space-y-5">
                                <div>
                                    <label for="portfolio_url" class="{{ $labelClass }}">
                                        URL portfolio
                                    </label>

                                    <input
                                        id="portfolio_url"
                                        name="portfolio_url"
                                        type="url"
                                        required
                                        maxlength="500"
                                        value="{{ old('portfolio_url', data_get($onboarding, 'portfolio_url')) }}"
                                        class="{{ $inputClass }}"
                                        placeholder="https://portfolio-kamu.com"
                                    >

                                    <p class="{{ $helpClass }}">
                                        Gunakan tautan portfolio yang bisa diperiksa oleh admin.
                                    </p>
                                </div>

                                <div>
                                    <label for="portfolio_description" class="{{ $labelClass }}">
                                        Deskripsi portfolio
                                    </label>

                                    <textarea
                                        id="portfolio_description"
                                        name="portfolio_description"
                                        rows="5"
                                        required
                                        maxlength="3000"
                                        class="{{ $inputClass }}"
                                        placeholder="Jelaskan pengalaman, keahlian, dan contoh pekerjaan kamu..."
                                    >{{ old('portfolio_description', data_get($onboarding, 'portfolio_description')) }}</textarea>
                                </div>

                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <p class="font-semibold text-slate-800">
                                        Sebelum mengirim pengajuan
                                    </p>

                                    <ul class="mt-3 space-y-2 text-sm leading-6 text-slate-600">
                                        <li>✓ Periksa kembali profil dan informasi kontak.</li>
                                        <li>✓ Pastikan identitas dan rekening bank benar.</li>
                                        <li>✓ Pastikan tautan portfolio dapat diakses.</li>
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- ACTIONS --}}
                        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                @if ($step > 1)
                                    <a
                                        href="{{ route('freelancer.onboarding', ['step' => $step - 1]) }}"
                                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                    >
                                        &larr; Langkah sebelumnya
                                    </a>
                                @endif
                            </div>

                            <button
                                type="submit"
                                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/20"
                            >
                                @if ($step < 5)
                                    Simpan dan lanjutkan
                                    <span aria-hidden="true">&rarr;</span>
                                @else
                                    {{ $isRejected ? 'Kirim Ulang Pengajuan' : 'Kirim Pengajuan' }}
                                @endif
                            </button>
                        </div>
                    </form>
                </section>
            @endif

            <p class="mt-6 text-center text-xs leading-5 text-slate-400">
                Data identitas dan rekening digunakan untuk proses verifikasi pengajuan freelancer ProKerja.
            </p>
        </div>
    </div>
</x-layouts.freelancer>