<x-layouts.marketplace title="Edit Profile - ProKerja">

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
            <div class="mb-6">

                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                    <i class="bi bi-person-gear"></i>
                    Pengaturan Profil
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            Edit Profile
                        </h1>

                        <p class="mt-1.5 text-sm leading-6 text-slate-500 sm:text-base">
                            Kelola informasi akun dan keamanan profile kamu di ProKerja.
                        </p>
                    </div>

                    <a
                        href="{{ route('profile.edit') }}"
                        class="hidden"
                    >
                        Edit Profile
                    </a>

                </div>

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

            {{-- Validation --}}
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 shadow-sm">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-rose-700">
                                Ada data yang perlu diperbaiki.
                            </p>

                            <ul class="mt-2 space-y-1 text-sm text-rose-600">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-rose-400"></span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                </div>
            @endif

            {{-- Main Layout --}}
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_300px]">

                {{-- Main Content --}}
                <div class="space-y-6">

                    {{-- Profile Form --}}
                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        {{-- Header --}}
                        <div class="border-b border-slate-100 bg-gradient-to-r from-blue-50 via-white to-white px-5 py-6 sm:px-7">

                            <div class="flex items-start gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                                    <i class="bi bi-person-vcard text-lg"></i>
                                </div>

                                <div>
                                    <h2 class="text-base font-bold text-slate-900">
                                        Informasi Profil
                                    </h2>

                                    <p class="mt-1 text-sm leading-6 text-slate-500">
                                        Informasi ini digunakan pada akun dan aktivitas kamu di ProKerja.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <form
                            action="{{ route('profile.update') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="space-y-7 p-5 sm:p-7"
                        >

                            @csrf
                            @method('PATCH')

                            {{-- Avatar --}}
                            <div>

                                <div class="mb-3">
                                    <label class="block text-sm font-semibold text-slate-800">
                                        Foto Profil
                                    </label>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Gunakan foto yang jelas agar profil lebih mudah dikenali.
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 sm:p-5">

                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                                        {{-- Avatar --}}
                                        <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-blue-100 ring-4 ring-white shadow-sm">

                                            @if ($avatarUrl)
                                                <img
                                                    src="{{ $avatarUrl }}"
                                                    alt="{{ $user->name }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                <span class="text-2xl font-bold text-blue-700">
                                                    {{ $initial }}
                                                </span>
                                            @endif

                                        </div>

                                        <div class="min-w-0 flex-1">

                                            <label
                                                for="avatar"
                                                class="mb-2 block text-sm font-semibold text-slate-700"
                                            >
                                                Upload foto baru
                                            </label>

                                            <input
                                                id="avatar"
                                                type="file"
                                                name="avatar"
                                                accept="image/jpeg,image/png,image/webp"
                                                class="block w-full rounded-2xl border border-slate-300 bg-white text-sm text-slate-600 shadow-sm file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
                                            >

                                            <p class="mt-2 text-xs text-slate-400">
                                                JPG, PNG, atau WEBP. Maksimal 2 MB.
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            {{-- Basic Information --}}
                            <div class="border-t border-slate-100 pt-7">

                                <div class="mb-5">
                                    <h3 class="text-sm font-bold text-slate-900">
                                        Informasi Dasar
                                    </h3>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Pastikan data yang kamu masukkan sesuai dengan informasi terbaru.
                                    </p>
                                </div>

                                <div class="grid gap-5 sm:grid-cols-2">

                                    {{-- Name --}}
                                    <div class="sm:col-span-2">

                                        <label
                                            for="name"
                                            class="mb-2 block text-sm font-semibold text-slate-700"
                                        >
                                            Nama Lengkap
                                        </label>

                                        <div class="relative">

                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                                <i class="bi bi-person"></i>
                                            </div>

                                            <input
                                                id="name"
                                                name="name"
                                                type="text"
                                                value="{{ old('name', $user->name) }}"
                                                required
                                                class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition duration-200 placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                            >

                                        </div>

                                    </div>

                                    {{-- Email --}}
                                    <div class="sm:col-span-2">

                                        <label
                                            for="email"
                                            class="mb-2 block text-sm font-semibold text-slate-700"
                                        >
                                            Email
                                        </label>

                                        <div class="relative">

                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                                <i class="bi bi-envelope"></i>
                                            </div>

                                            <input
                                                id="email"
                                                name="email"
                                                type="email"
                                                value="{{ old('email', $user->email) }}"
                                                required
                                                class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition duration-200 placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                            >

                                        </div>

                                        @if ($user->email_verified_at)

                                            <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-emerald-600">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Email sudah terverifikasi.
                                            </p>

                                        @else

                                            <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-amber-600">
                                                <i class="bi bi-exclamation-circle"></i>
                                                Email belum terverifikasi.
                                            </p>

                                        @endif

                                    </div>

                                    {{-- Phone --}}
                                    <div>

                                        <label
                                            for="phone"
                                            class="mb-2 block text-sm font-semibold text-slate-700"
                                        >
                                            Nomor HP
                                        </label>

                                        <div class="relative">

                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                                <i class="bi bi-telephone"></i>
                                            </div>

                                            <input
                                                id="phone"
                                                name="phone"
                                                type="text"
                                                value="{{ old('phone', $profile->phone) }}"
                                                placeholder="081234567890"
                                                class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition duration-200 placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                            >

                                        </div>

                                    </div>

                                    {{-- Location --}}
                                    <div>

                                        <label
                                            for="location"
                                            class="mb-2 block text-sm font-semibold text-slate-700"
                                        >
                                            Lokasi
                                        </label>

                                        <div class="relative">

                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>

                                            <input
                                                id="location"
                                                name="location"
                                                type="text"
                                                value="{{ old('location', $profile->location) }}"
                                                placeholder="Kebumen, Jawa Tengah"
                                                class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition duration-200 placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                            >

                                        </div>

                                    </div>

                                    {{-- Bio --}}
                                    <div class="sm:col-span-2">

                                        <label
                                            for="bio"
                                            class="mb-2 block text-sm font-semibold text-slate-700"
                                        >
                                            Bio
                                        </label>

                                        <textarea
                                            id="bio"
                                            name="bio"
                                            rows="5"
                                            maxlength="1000"
                                            placeholder="Ceritakan sedikit tentang dirimu..."
                                            class="w-full resize-none rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition duration-200 placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                        >{{ old('bio', $profile->bio) }}</textarea>

                                        <p class="mt-2 text-xs text-slate-400">
                                            Maksimal 1000 karakter.
                                        </p>

                                    </div>

                                </div>

                            </div>

                            {{-- Submit --}}
                            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                                <a
                                    href="{{ route('profile.edit') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition duration-200 hover:bg-slate-50 hover:text-slate-800"
                                >
                                    Batal
                                </a>

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#2563EB] px-6 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-md"
                                >
                                    <i class="bi bi-check-lg"></i>
                                    Simpan Perubahan
                                </button>

                            </div>

                        </form>

                    </div>

                    {{-- Password --}}
                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 via-white to-white px-5 py-6 sm:px-7">

                            <div class="flex items-start gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                    <i class="bi bi-shield-lock text-lg"></i>
                                </div>

                                <div>
                                    <h2 class="text-base font-bold text-slate-900">
                                        Ganti Password
                                    </h2>

                                    <p class="mt-1 text-sm leading-6 text-slate-500">
                                        Gunakan password baru yang aman untuk menjaga akun kamu.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <form
                            action="{{ route('password.update') }}"
                            method="POST"
                            class="space-y-5 p-5 sm:p-7"
                        >

                            @csrf
                            @method('PUT')

                            {{-- Current Password --}}
                            <div>

                                <label
                                    for="current_password"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Password Saat Ini
                                </label>

                                <div class="relative">

                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <i class="bi bi-lock"></i>
                                    </div>

                                    <input
                                        id="current_password"
                                        name="current_password"
                                        type="password"
                                        required
                                        class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    >

                                </div>

                            </div>

                            {{-- New Password --}}
                            <div>

                                <label
                                    for="password"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Password Baru
                                </label>

                                <div class="relative">

                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <i class="bi bi-key"></i>
                                    </div>

                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        required
                                        class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    >

                                </div>

                            </div>

                            {{-- Confirmation --}}
                            <div>

                                <label
                                    for="password_confirmation"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Konfirmasi Password Baru
                                </label>

                                <div class="relative">

                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <i class="bi bi-key-fill"></i>
                                    </div>

                                    <input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        required
                                        class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    >

                                </div>

                            </div>

                            {{-- Password Submit --}}
                            <div class="flex justify-end border-t border-slate-100 pt-6">

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                                >
                                    <i class="bi bi-shield-lock"></i>
                                    Update Password
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

                {{-- Sidebar --}}
                <aside class="space-y-6 lg:sticky lg:top-6 lg:self-start">

                    {{-- Profile Preview --}}
                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                        <div class="bg-gradient-to-br from-blue-600 to-blue-700 px-5 py-6">

                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-100">
                                Preview Profile
                            </p>

                            <div class="mt-4 flex items-center gap-3">

                                <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white/20 ring-2 ring-white/30">

                                    @if ($avatarUrl)
                                        <img
                                            src="{{ $avatarUrl }}"
                                            alt="{{ $user->name }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <span class="text-xl font-bold text-white">
                                            {{ $initial }}
                                        </span>
                                    @endif

                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-bold text-white">
                                        {{ $user->name }}
                                    </p>

                                    <p class="mt-0.5 truncate text-xs text-blue-100">
                                        Client ProKerja
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="space-y-3 p-5">

                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-envelope"></i>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                        Email
                                    </p>

                                    <p class="truncate text-sm text-slate-700">
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                    <i class="bi bi-geo-alt"></i>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                                        Lokasi
                                    </p>

                                    <p class="truncate text-sm text-slate-700">
                                        {{ $profile->location ?: 'Belum diisi' }}
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Account Tips --}}
                    <div class="rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-blue-50/60 p-5 shadow-sm">

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-blue-600 shadow-sm">
                            <i class="bi bi-lightbulb text-lg"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-bold text-slate-900">
                            Tips Profile
                        </h3>

                        <ul class="mt-3 space-y-3">

                            <li class="flex items-start gap-2.5">
                                <i class="bi bi-check-circle-fill mt-0.5 text-xs text-emerald-500"></i>
                                <span class="text-xs leading-5 text-slate-500">
                                    Gunakan nama yang mudah dikenali.
                                </span>
                            </li>

                            <li class="flex items-start gap-2.5">
                                <i class="bi bi-check-circle-fill mt-0.5 text-xs text-emerald-500"></i>
                                <span class="text-xs leading-5 text-slate-500">
                                    Pastikan email dan nomor HP selalu aktif.
                                </span>
                            </li>

                            <li class="flex items-start gap-2.5">
                                <i class="bi bi-check-circle-fill mt-0.5 text-xs text-emerald-500"></i>
                                <span class="text-xs leading-5 text-slate-500">
                                    Gunakan password yang kuat dan tidak mudah ditebak.
                                </span>
                            </li>

                        </ul>

                    </div>

                    {{-- Security --}}
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-slate-900">
                                    Keamanan Akun
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Jangan membagikan password akun kamu kepada orang lain.
                                </p>
                            </div>

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</x-layouts.marketplace>