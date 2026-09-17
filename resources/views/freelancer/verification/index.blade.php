<x-layouts.freelancer title="Verifikasi Freelancer">

    <div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-6">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                    <i class="bi bi-patch-check text-lg"></i>
                </div>

                <div>
                    <h1 class="text-xl font-semibold tracking-tight text-[#123128]">
                        Verifikasi Freelancer
                    </h1>

                    <p class="mt-1 text-sm text-[#667D73]">
                        Verifikasi identitas dan rekening agar akun freelancer kamu lebih terpercaya.
                    </p>
                </div>
            </div>
        </div>

        {{-- FLASH SUCCESS --}}
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                <div class="flex items-start gap-3">
                    <i class="bi bi-check-circle-fill mt-0.5"></i>

                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        {{-- FLASH INFO --}}
        @if (session('info'))
            <div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                <div class="flex items-start gap-3">
                    <i class="bi bi-info-circle-fill mt-0.5"></i>

                    <div>
                        {{ session('info') }}
                    </div>
                </div>
            </div>
        @endif

        {{-- GLOBAL ERRORS --}}
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">
                <p class="font-semibold">
                    Periksa kembali data yang kamu masukkan.
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- STATUS --}}
        @if ($verification)
            <div class="mb-6 rounded-2xl border border-[#E4ECE7] bg-white p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#667D73]">
                            Status Verifikasi
                        </p>

                        <div class="mt-2 flex items-center gap-2">

                            @if ($verification->status === 'verified')

                                <span class="inline-flex items-center gap-2 rounded-full bg-[#EAF7EF] px-3 py-1.5 text-xs font-semibold text-[#15803D]">
                                    <i class="bi bi-patch-check-fill"></i>
                                    Terverifikasi
                                </span>

                            @elseif ($verification->status === 'pending')

                                <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                                    <i class="bi bi-hourglass-split"></i>
                                    Sedang Ditinjau
                                </span>

                            @else

                                <span class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Ditolak
                                </span>

                            @endif

                        </div>
                    </div>

                    @if ($verification->status === 'rejected')
                        <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 sm:max-w-md">
                            <p class="text-xs font-semibold text-red-800">
                                Alasan penolakan
                            </p>

                            <p class="mt-1 text-sm leading-6 text-red-700">
                                {{ $verification->rejection_reason ?: 'Tidak ada alasan yang diberikan.' }}
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        @endif

        {{-- VERIFIED MESSAGE --}}
        @if ($verification?->status === 'verified')

            <div class="rounded-2xl border border-green-200 bg-green-50 p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#16A34A]">
                        <i class="bi bi-shield-check text-xl"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Akun kamu sudah terverifikasi
                        </h2>

                        <p class="mt-1 text-sm leading-6 text-[#4B635A]">
                            Identitas freelancer dan data rekening kamu sudah berhasil diverifikasi oleh Admin.
                        </p>
                    </div>
                </div>
            </div>

        @elseif ($verification?->status === 'pending')

            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600">
                        <i class="bi bi-clock-history text-xl"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-[#123128]">
                            Pengajuan sedang ditinjau
                        </h2>

                        <p class="mt-1 text-sm leading-6 text-[#6B5A2A]">
                            Data kamu sedang diperiksa oleh Admin. Tunggu sampai proses review selesai.
                        </p>
                    </div>
                </div>
            </div>

        @else

            {{-- FORM --}}
            <div class="rounded-2xl border border-[#E4ECE7] bg-white">

                <div class="border-b border-[#EAF0EC] px-5 py-5">
                    <h2 class="text-base font-semibold text-[#123128]">
                        Data Verifikasi
                    </h2>

                    <p class="mt-1 text-sm text-[#71837B]">
                        Pastikan data yang diisi sesuai dengan dokumen dan rekening yang kamu gunakan.
                    </p>
                </div>

                <form
                    action="{{ route('freelancer.verification.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-7 p-5"
                >
                    @csrf

                    {{-- IDENTITAS --}}
                    <section>
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-[#123128]">
                                Identitas
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                Gunakan data identitas yang sesuai dengan dokumen resmi.
                            </p>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">

                            <div class="md:col-span-2">
                                <label
                                    for="full_name"
                                    class="mb-2 block text-sm font-medium text-[#314A40]"
                                >
                                    Nama lengkap
                                </label>

                                <input
                                    id="full_name"
                                    name="full_name"
                                    type="text"
                                    value="{{ old('full_name') }}"
                                    placeholder="Nama sesuai identitas"
                                    class="w-full rounded-xl border border-[#DCE7E1] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#9AA9A2] focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10"
                                    required
                                >

                                @error('full_name')
                                    <p class="mt-2 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="identity_type"
                                    class="mb-2 block text-sm font-medium text-[#314A40]"
                                >
                                    Jenis identitas
                                </label>

                                <select
                                    id="identity_type"
                                    name="identity_type"
                                    class="w-full rounded-xl border border-[#DCE7E1] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10"
                                    required
                                >
                                    <option value="KTP">
                                        KTP
                                    </option>
                                </select>

                                @error('identity_type')
                                    <p class="mt-2 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="identity_number"
                                    class="mb-2 block text-sm font-medium text-[#314A40]"
                                >
                                    Nomor identitas
                                </label>

                                <input
                                    id="identity_number"
                                    name="identity_number"
                                    type="text"
                                    inputmode="numeric"
                                    value="{{ old('identity_number') }}"
                                    placeholder="Masukkan nomor KTP"
                                    class="w-full rounded-xl border border-[#DCE7E1] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#9AA9A2] focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10"
                                    required
                                >

                                <p class="mt-2 text-xs leading-5 text-[#8A9992]">
                                    Nomor identitas disimpan dalam bentuk terenkripsi.
                                </p>

                                @error('identity_number')
                                    <p class="mt-2 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">

                                <label
                                    for="identity_document"
                                    class="mb-2 block text-sm font-medium text-[#314A40]"
                                >
                                    Foto dokumen identitas
                                </label>

                                <label
                                    for="identity_document"
                                    class="flex cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed border-[#CFE0D6] bg-[#F8FCF9] px-5 py-8 text-center transition hover:border-[#22C55E] hover:bg-[#F4FBF6]"
                                >
                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                        <i class="bi bi-cloud-arrow-up text-xl"></i>
                                    </div>

                                    <p class="mt-3 text-sm font-semibold text-[#314A40]">
                                        Klik untuk memilih foto KTP
                                    </p>

                                    <p class="mt-1 text-xs text-[#8A9992]">
                                        JPG, JPEG, atau PNG. Maksimal 4 MB.
                                    </p>

                                    <input
                                        id="identity_document"
                                        name="identity_document"
                                        type="file"
                                        accept=".jpg,.jpeg,.png"
                                        class="hidden"
                                        required
                                    >
                                </label>

                                @error('identity_document')
                                    <p class="mt-2 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </section>

                    {{-- BANK --}}
                    <section class="border-t border-[#EEF3F0] pt-7">
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-[#123128]">
                                Rekening Bank
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                Gunakan rekening yang sesuai dengan nama pemilik akun.
                            </p>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">

                            <div>
                                <label
                                    for="bank_name"
                                    class="mb-2 block text-sm font-medium text-[#314A40]"
                                >
                                    Nama bank
                                </label>

                                <input
                                    id="bank_name"
                                    name="bank_name"
                                    type="text"
                                    value="{{ old('bank_name') }}"
                                    placeholder="Contoh: BCA"
                                    class="w-full rounded-xl border border-[#DCE7E1] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#9AA9A2] focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10"
                                    required
                                >

                                @error('bank_name')
                                    <p class="mt-2 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="bank_account_name"
                                    class="mb-2 block text-sm font-medium text-[#314A40]"
                                >
                                    Nama pemilik rekening
                                </label>

                                <input
                                    id="bank_account_name"
                                    name="bank_account_name"
                                    type="text"
                                    value="{{ old('bank_account_name') }}"
                                    placeholder="Nama sesuai rekening"
                                    class="w-full rounded-xl border border-[#DCE7E1] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#9AA9A2] focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10"
                                    required
                                >

                                @error('bank_account_name')
                                    <p class="mt-2 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label
                                    for="bank_account_number"
                                    class="mb-2 block text-sm font-medium text-[#314A40]"
                                >
                                    Nomor rekening
                                </label>

                                <input
                                    id="bank_account_number"
                                    name="bank_account_number"
                                    type="text"
                                    inputmode="numeric"
                                    value="{{ old('bank_account_number') }}"
                                    placeholder="Masukkan nomor rekening"
                                    class="w-full rounded-xl border border-[#DCE7E1] bg-white px-4 py-3 text-sm text-[#123128] outline-none transition placeholder:text-[#9AA9A2] focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10"
                                    required
                                >

                                <p class="mt-2 text-xs leading-5 text-[#8A9992]">
                                    Nomor rekening disimpan dalam bentuk terenkripsi.
                                </p>

                                @error('bank_account_number')
                                    <p class="mt-2 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </section>

                    {{-- NOTICE --}}
                    <div class="rounded-xl border border-[#DCECE2] bg-[#F7FCF8] px-4 py-4">
                        <div class="flex items-start gap-3">
                            <i class="bi bi-shield-lock mt-0.5 text-[#1E9E5A]"></i>

                            <div>
                                <p class="text-sm font-semibold text-[#234137]">
                                    Data verifikasi bersifat privat
                                </p>

                                <p class="mt-1 text-xs leading-5 text-[#71837B]">
                                    Dokumen identitas dan nomor sensitif tidak ditampilkan sebagai file publik.
                                    Data akan digunakan untuk proses pemeriksaan akun freelancer.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- ACTION --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-[#EEF3F0] pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('freelancer.dashboard') }}"
                            class="inline-flex h-11 items-center justify-center rounded-xl border border-[#DCE7E1] px-5 text-sm font-semibold text-[#476158] transition hover:bg-[#F8FCF9]"
                        >
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-6 text-sm font-semibold text-white transition hover:bg-[#0C5A31]"
                        >
                            <i class="bi bi-send"></i>
                            Kirim Verifikasi
                        </button>

                    </div>

                </form>
            </div>

        @endif

    </div>

</x-layouts.freelancer>