<x-layouts.marketplace title="Profil Saya - ProKerja">

    @php
        $avatarUrl = $profile->avatar
            ? asset('storage/' . $profile->avatar)
            : null;

        $initial = strtoupper(
            substr($user->name ?: 'U', 0, 1)
        );
    @endphp

    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- Header --}}
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                        <i class="bi bi-person-circle"></i>
                        Area Client
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Profil Saya
                    </h1>

                    <p class="mt-1.5 text-sm leading-6 text-slate-500 sm:text-base">
                        Kelola informasi akun dan profil kamu di ProKerja.
                    </p>
                </div>

                {{-- Dashboard --}}
                <a
                    href="{{ route('client.dashboard') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                >
                    <i class="bi bi-grid"></i>
                    Dashboard
                </a>

            </div>

            {{-- Success --}}
            @if (session('success'))
                <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-700 shadow-sm">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-100">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <div class="pt-1">
                        <p class="font-semibold">
                            Berhasil
                        </p>

                        <p class="mt-0.5 text-emerald-600">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Main Profile Layout --}}
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_300px]">

                {{-- Main Profile Card --}}
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                    {{-- Profile Hero --}}
                    <div class="relative overflow-hidden border-b border-slate-100 bg-gradient-to-br from-blue-50 via-white to-white px-5 py-6 sm:px-7 sm:py-7">

                        {{-- Decorative background --}}
                        <div class="pointer-events-none absolute -right-16 -top-20 h-48 w-48 rounded-full bg-blue-100/60 blur-3xl"></div>
                        <div class="pointer-events-none absolute -bottom-20 left-1/3 h-40 w-40 rounded-full bg-indigo-100/40 blur-3xl"></div>

                        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex min-w-0 items-center gap-4 sm:gap-5">

                                {{-- Avatar --}}
                                <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-blue-100 ring-4 ring-white shadow-sm sm:h-24 sm:w-24">

                                    @if ($avatarUrl)
                                        <img
                                            src="{{ $avatarUrl }}"
                                            alt="{{ $user->name }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <span class="text-2xl font-bold text-blue-700 sm:text-3xl">
                                            {{ $initial }}
                                        </span>
                                    @endif

                                </div>

                                {{-- Identity --}}
                                <div class="min-w-0">

                                    <div class="mb-1.5 inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-semibold text-blue-700">
                                        <i class="bi bi-person-check"></i>
                                        Client
                                    </div>

                                    <h2 class="truncate text-xl font-bold text-slate-900 sm:text-2xl">
                                        {{ $user->name }}
                                    </h2>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Client ProKerja
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Bergabung sejak {{ $user->created_at?->translatedFormat('d F Y') }}
                                    </p>

                                </div>

                            </div>

                            {{-- Edit --}}
                            <a
                                href="{{ route('profile.edit') }}"
                                class="inline-flex shrink-0 items-center justify-center gap-2 rounded-2xl bg-[#2563EB] px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-md"
                            >
                                <i class="bi bi-pencil"></i>
                                Edit Profile
                            </a>

                        </div>

                    </div>

                    {{-- Profile Information --}}
                    <div class="p-5 sm:p-7">

                        <div class="mb-6">
                            <h3 class="text-base font-bold text-slate-900">
                                Informasi Profil
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Informasi dasar yang digunakan pada akun ProKerja kamu.
                            </p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">

                            {{-- Email --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 transition duration-200 hover:border-blue-100 hover:bg-blue-50/40">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                        <i class="bi bi-envelope"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Email
                                        </p>

                                        <p class="mt-1.5 break-all text-sm font-medium text-slate-700">
                                            {{ $user->email }}
                                        </p>
                                    </div>

                                </div>

                            </div>

                            {{-- Phone --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 transition duration-200 hover:border-blue-100 hover:bg-blue-50/40">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                                        <i class="bi bi-telephone"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Nomor HP
                                        </p>

                                        <p class="mt-1.5 text-sm font-medium text-slate-700">
                                            {{ $profile->phone ?: 'Belum diisi' }}
                                        </p>
                                    </div>

                                </div>

                            </div>

                            {{-- Location --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 transition duration-200 hover:border-blue-100 hover:bg-blue-50/40">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-violet-600">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Lokasi
                                        </p>

                                        <p class="mt-1.5 text-sm font-medium text-slate-700">
                                            {{ $profile->location ?: 'Belum diisi' }}
                                        </p>
                                    </div>

                                </div>

                            </div>

                            {{-- Account Type --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 transition duration-200 hover:border-blue-100 hover:bg-blue-50/40">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-600">
                                        <i class="bi bi-person"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Tipe Akun
                                        </p>

                                        <p class="mt-1.5 text-sm font-medium text-slate-700">
                                            Client
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- Bio --}}
                        <div class="mt-7 border-t border-slate-100 pt-7">

                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-card-text"></i>
                                </div>

                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">
                                        Tentang Saya
                                    </h3>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        Deskripsi singkat mengenai profil kamu.
                                    </p>
                                </div>
                            </div>

                            @if ($profile->bio)

                                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-4">
                                    <p class="whitespace-pre-line text-sm leading-7 text-slate-600">
                                        {{ $profile->bio }}
                                    </p>
                                </div>

                            @else

                                <div class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-5 text-center">

                                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>

                                    <p class="mt-3 text-sm font-medium text-slate-600">
                                        Bio belum ditambahkan
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Tambahkan bio agar profil kamu lebih lengkap.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

                {{-- Sidebar --}}
                <aside class="space-y-6">

                    {{-- Profile Completion / Quick Info --}}
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <div class="flex items-start gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                <i class="bi bi-person-vcard text-lg"></i>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-slate-900">
                                    Profil Client
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Pastikan informasi profil kamu selalu terbaru.
                                </p>
                            </div>

                        </div>

                        <div class="mt-5 space-y-3">

                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3.5 py-3">
                                <div class="flex items-center gap-2.5">
                                    <i class="bi bi-person text-slate-400"></i>
                                    <span class="text-sm text-slate-600">
                                        Nama
                                    </span>
                                </div>

                                <i class="bi bi-check-circle-fill text-emerald-500"></i>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3.5 py-3">
                                <div class="flex items-center gap-2.5">
                                    <i class="bi bi-envelope text-slate-400"></i>
                                    <span class="text-sm text-slate-600">
                                        Email
                                    </span>
                                </div>

                                <i class="bi bi-check-circle-fill text-emerald-500"></i>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3.5 py-3">
                                <div class="flex items-center gap-2.5">
                                    <i class="bi bi-telephone text-slate-400"></i>
                                    <span class="text-sm text-slate-600">
                                        Nomor HP
                                    </span>
                                </div>

                                @if ($profile->phone)
                                    <i class="bi bi-check-circle-fill text-emerald-500"></i>
                                @else
                                    <span class="text-[11px] font-medium text-amber-600">
                                        Belum diisi
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3.5 py-3">
                                <div class="flex items-center gap-2.5">
                                    <i class="bi bi-geo-alt text-slate-400"></i>
                                    <span class="text-sm text-slate-600">
                                        Lokasi
                                    </span>
                                </div>

                                @if ($profile->location)
                                    <i class="bi bi-check-circle-fill text-emerald-500"></i>
                                @else
                                    <span class="text-[11px] font-medium text-amber-600">
                                        Belum diisi
                                    </span>
                                @endif
                            </div>

                        </div>

                        <a
                            href="{{ route('profile.edit') }}"
                            class="mt-5 flex w-full items-center justify-center gap-2 rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 transition duration-200 hover:bg-blue-100"
                        >
                            Lengkapi Profile
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                    {{-- Security --}}
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">

                        <div class="flex items-start gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                <i class="bi bi-shield-check text-lg"></i>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-slate-900">
                                    Keamanan Akun
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Kelola password dan informasi akun melalui halaman edit profile.
                                </p>
                            </div>

                        </div>

                        <a
                            href="{{ route('profile.edit') }}"
                            class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
                        >
                            Kelola Profile
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                    {{-- Marketplace Info --}}
                    <div class="overflow-hidden rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-blue-50/60 p-5 shadow-sm sm:p-6">

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-blue-600 shadow-sm">
                            <i class="bi bi-stars text-lg"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-bold text-slate-900">
                            Gunakan ProKerja dengan nyaman
                        </h3>

                        <p class="mt-1.5 text-xs leading-5 text-slate-500">
                            Profil yang lengkap membantu pengalaman menggunakan marketplace menjadi lebih mudah.
                        </p>

                        <a
                            href="{{ route('client.dashboard') }}"
                            class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
                        >
                            Kembali ke Dashboard
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</x-layouts.marketplace>