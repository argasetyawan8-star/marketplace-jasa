<x-layouts.admin title="Detail Verifikasi Freelancer">

    <div class="min-h-screen bg-[#F8FCF9] px-4 py-6 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-5xl">

            {{-- HEADER --}}
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <a
                        href="{{ route('admin.verifications.index') }}"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-[#1E9E5A] hover:text-[#0F6B3A]"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke verifikasi
                    </a>

                    <h1 class="mt-3 text-2xl font-semibold tracking-tight text-[#123128]">
                        Detail Verifikasi
                    </h1>

                    <p class="mt-1 text-sm text-[#71837B]">
                        Periksa data freelancer sebelum mengambil keputusan.
                    </p>
                </div>

                @if ($verification->status === 'pending')

                    <span class="inline-flex w-fit items-center gap-2 rounded-full bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700">
                        <i class="bi bi-hourglass-split"></i>
                        Menunggu Review
                    </span>

                @elseif ($verification->status === 'verified')

                    <span class="inline-flex w-fit items-center gap-2 rounded-full bg-green-50 px-3 py-2 text-xs font-semibold text-green-700">
                        <i class="bi bi-patch-check-fill"></i>
                        Terverifikasi
                    </span>

                @else

                    <span class="inline-flex w-fit items-center gap-2 rounded-full bg-red-50 px-3 py-2 text-xs font-semibold text-red-700">
                        <i class="bi bi-x-circle-fill"></i>
                        Ditolak
                    </span>

                @endif

            </div>

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- ERRORS --}}
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">
                    <p class="font-semibold">
                        Periksa kembali data.
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- PROFILE --}}
            <section class="rounded-2xl border border-[#E2EBE5] bg-white p-5 sm:p-6">

                <div class="flex items-center gap-4">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#EAF7EF] text-lg font-semibold text-[#1E9E5A]">
                        {{
                            strtoupper(
                                substr(
                                    $verification->freelancerProfile?->user?->name
                                    ?? $verification->full_name,
                                    0,
                                    1
                                )
                            )
                        }}
                    </div>

                    <div class="min-w-0">

                        <p class="text-lg font-semibold text-[#18382E]">
                            {{ $verification->freelancerProfile?->user?->name ?? $verification->full_name }}
                        </p>

                        <p class="mt-1 text-sm text-[#89968F]">
                            {{ $verification->freelancerProfile?->user?->email ?? '-' }}
                        </p>

                    </div>

                </div>

            </section>

            <div class="mt-5 grid gap-5 lg:grid-cols-2">

                {{-- IDENTITY --}}
                <section class="rounded-2xl border border-[#E2EBE5] bg-white p-5 sm:p-6">

                    <div class="flex items-center gap-3 border-b border-[#EDF2EF] pb-4">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                            <i class="bi bi-person-vcard"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#18382E]">
                                Data Identitas
                            </h2>

                            <p class="text-xs text-[#89968F]">
                                Data yang dikirim freelancer
                            </p>
                        </div>

                    </div>

                    <dl class="mt-5 space-y-4">

                        <div>
                            <dt class="text-xs text-[#89968F]">
                                Nama lengkap
                            </dt>

                            <dd class="mt-1 text-sm font-medium text-[#30483F]">
                                {{ $verification->full_name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-[#89968F]">
                                Jenis identitas
                            </dt>

                            <dd class="mt-1 text-sm font-medium text-[#30483F]">
                                {{ $verification->identity_type }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-[#89968F]">
                                Nomor identitas
                            </dt>

                            <dd class="mt-1 break-all text-sm font-medium text-[#30483F]">
                                {{ $verification->identity_number }}
                            </dd>
                        </div>

                    </dl>

                </section>

                {{-- BANK --}}
                <section class="rounded-2xl border border-[#E2EBE5] bg-white p-5 sm:p-6">

                    <div class="flex items-center gap-3 border-b border-[#EDF2EF] pb-4">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                            <i class="bi bi-bank"></i>
                        </div>

                        <div>
                            <h2 class="text-sm font-semibold text-[#18382E]">
                                Rekening Bank
                            </h2>

                            <p class="text-xs text-[#89968F]">
                                Data rekening untuk withdrawal
                            </p>
                        </div>

                    </div>

                    <dl class="mt-5 space-y-4">

                        <div>
                            <dt class="text-xs text-[#89968F]">
                                Bank
                            </dt>

                            <dd class="mt-1 text-sm font-medium text-[#30483F]">
                                {{ $verification->bank_name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-[#89968F]">
                                Nama pemilik
                            </dt>

                            <dd class="mt-1 text-sm font-medium text-[#30483F]">
                                {{ $verification->bank_account_name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-[#89968F]">
                                Nomor rekening
                            </dt>

                            <dd class="mt-1 break-all text-sm font-medium text-[#30483F]">
                                {{ $verification->bank_account_number }}
                            </dd>
                        </div>

                    </dl>

                </section>

                {{-- DOCUMENT --}}
                <section class="rounded-2xl border border-[#E2EBE5] bg-white p-5 sm:p-6 lg:col-span-2">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                                <i class="bi bi-file-earmark-image"></i>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-[#18382E]">
                                    Dokumen Identitas
                                </h2>

                                <p class="text-xs text-[#89968F]">
                                    Dokumen hanya dapat diakses Admin melalui route private.
                                </p>
                            </div>

                        </div>

                        @if ($verification->identity_document_path)

                            <a
                                href="{{ route('admin.verifications.document', $verification) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-[#DCE7E1] px-4 text-xs font-semibold text-[#466057] transition hover:border-[#BFD9C8] hover:bg-[#F4FAF6] hover:text-[#1E9E5A]"
                            >
                                <i class="bi bi-eye"></i>
                                Lihat Dokumen
                            </a>

                        @endif

                    </div>

                    @if ($verification->rejection_reason)

                        <div class="mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-4">

                            <p class="text-xs font-semibold text-red-800">
                                Alasan penolakan
                            </p>

                            <p class="mt-1 text-sm leading-6 text-red-700">
                                {{ $verification->rejection_reason }}
                            </p>

                        </div>

                    @endif

                </section>

            </div>

            {{-- REVIEW --}}
            @if ($verification->status === 'pending')

                <section class="mt-5 rounded-2xl border border-[#E2EBE5] bg-white p-5 sm:p-6">

                    <div class="border-b border-[#EDF2EF] pb-4">

                        <h2 class="text-sm font-semibold text-[#18382E]">
                            Keputusan Admin
                        </h2>

                        <p class="mt-1 text-xs text-[#89968F]">
                            Pilih tindakan setelah memeriksa data identitas dan rekening.
                        </p>

                    </div>

                    <div class="mt-5 flex flex-col gap-3 sm:flex-row">

                        {{-- APPROVE --}}
                        <form
                            action="{{ route('admin.verifications.approve', $verification) }}"
                            method="POST"
                            class="sm:flex-1"
                        >
                            @csrf

                            <button
                                type="submit"
                                onclick="return confirm('Verifikasi freelancer ini?')"
                                class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#0C5A31]"
                            >
                                <i class="bi bi-patch-check"></i>
                                Verifikasi Freelancer
                            </button>
                        </form>

                        {{-- REJECT --}}
                        <div class="sm:flex-1">

                            <form
                                action="{{ route('admin.verifications.reject', $verification) }}"
                                method="POST"
                                class="space-y-3"
                            >
                                @csrf

                                <textarea
                                    name="rejection_reason"
                                    rows="3"
                                    placeholder="Alasan penolakan..."
                                    class="w-full rounded-xl border border-[#DCE7E1] bg-white px-4 py-3 text-sm text-[#30483F] outline-none placeholder:text-[#9AA9A2] focus:border-red-400 focus:ring-2 focus:ring-red-100"
                                    required
                                >{{ old('rejection_reason') }}</textarea>

                                <button
                                    type="submit"
                                    onclick="return confirm('Tolak pengajuan verifikasi ini?')"
                                    class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-5 text-sm font-semibold text-red-700 transition hover:bg-red-100"
                                >
                                    <i class="bi bi-x-circle"></i>
                                    Tolak Pengajuan
                                </button>

                            </form>

                        </div>

                    </div>

                </section>

            @else

                <section class="mt-5 rounded-2xl border border-[#E2EBE5] bg-white p-5 sm:p-6">

                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <p class="text-xs text-[#89968F]">
                                Direview pada
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#30483F]">
                                {{ $verification->reviewed_at?->format('d M Y H:i') ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-[#89968F]">
                                Reviewer
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#30483F]">
                                {{ $verification->reviewer?->name ?? '-' }}
                            </p>
                        </div>

                    </div>

                </section>

            @endif

        </div>

    </div>

</x-layouts.admin>