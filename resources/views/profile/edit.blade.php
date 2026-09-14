<x-layouts.client>
    @php
        $avatarUrl = $profile->avatar
            ? asset('storage/' . $profile->avatar)
            : null;

        $initial = strtoupper(
            substr($user->name ?: 'U', 0, 1)
        );
    @endphp

    <div class="min-h-screen bg-[#F8FAF9]">
        <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-[#1F2937]">
                    Profil Saya
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Kelola informasi akun dan profil kamu.
                </p>
            </div>

            {{-- Success --}}
            @if (session('success'))
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Validation --}}
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                    <p class="text-sm font-medium text-red-700">
                        Ada data yang perlu diperbaiki.
                    </p>

                    <ul class="mt-2 space-y-1 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Profile --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

                {{-- Profile header --}}
                <div class="border-b border-gray-100 px-5 py-5 sm:px-6">
                    <h2 class="text-base font-semibold text-[#1F2937]">
                        Informasi Profil
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Informasi ini digunakan di akun dan aktivitas kamu di JASAIN.
                    </p>
                </div>

                <form
                    action="{{ route('profile.update') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6 p-5 sm:p-6"
                >
                    @csrf
                    @method('PATCH')

                    {{-- Avatar --}}
                    <div>
                        <label class="mb-3 block text-sm font-medium text-gray-700">
                            Foto Profil
                        </label>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                            <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full bg-green-100">
                                @if ($avatarUrl)
                                    <img
                                        src="{{ $avatarUrl }}"
                                        alt="{{ $user->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <span class="text-2xl font-semibold text-green-700">
                                        {{ $initial }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex-1">
                                <input
                                    type="file"
                                    name="avatar"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="block w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-600 file:mr-4 file:border-0 file:bg-green-50 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-green-700 hover:file:bg-green-100"
                                >

                                <p class="mt-2 text-xs text-gray-500">
                                    JPG, PNG, atau WEBP. Maksimal 2 MB.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div>
                        <label
                            for="name"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Nama Lengkap
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >
                    </div>

                    {{-- Email --}}
                    <div>
                        <label
                            for="email"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Email
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >

                        @if ($user->email_verified_at)
                            <p class="mt-2 flex items-center gap-1.5 text-xs text-green-600">
                                <i class="bi bi-check-circle-fill"></i>
                                Email sudah terverifikasi.
                            </p>
                        @else
                            <p class="mt-2 text-xs text-amber-600">
                                Email belum terverifikasi.
                            </p>
                        @endif
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label
                            for="phone"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Nomor HP
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            value="{{ old('phone', $profile->phone) }}"
                            placeholder="Contoh: 081234567890"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >
                    </div>

                    {{-- Location --}}
                    <div>
                        <label
                            for="location"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Lokasi
                        </label>

                        <input
                            id="location"
                            name="location"
                            type="text"
                            value="{{ old('location', $profile->location) }}"
                            placeholder="Contoh: Kebumen, Jawa Tengah"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >
                    </div>

                    {{-- Bio --}}
                    <div>
                        <label
                            for="bio"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Bio
                        </label>

                        <textarea
                            id="bio"
                            name="bio"
                            rows="4"
                            maxlength="1000"
                            placeholder="Ceritakan sedikit tentang dirimu..."
                            class="w-full resize-none rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >{{ old('bio', $profile->bio) }}</textarea>

                        <p class="mt-2 text-xs text-gray-500">
                            Maksimal 1000 karakter.
                        </p>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end border-t border-gray-100 pt-5">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#22C55E] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#16A34A]"
                        >
                            <i class="bi bi-check-lg"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Password --}}
            <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white">

                <div class="border-b border-gray-100 px-5 py-5 sm:px-6">
                    <h2 class="text-base font-semibold text-[#1F2937]">
                        Ganti Password
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Gunakan password baru yang aman untuk akun kamu.
                    </p>
                </div>

                <form
                    action="{{ route('password.update') }}"
                    method="POST"
                    class="space-y-5 p-5 sm:p-6"
                >
                    @csrf
                    @method('PUT')

                    <div>
                        <label
                            for="current_password"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Password Saat Ini
                        </label>

                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >
                    </div>

                    <div>
                        <label
                            for="password"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Password Baru
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >
                    </div>

                    <div>
                        <label
                            for="password_confirmation"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Konfirmasi Password Baru
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >
                    </div>

                    <div class="flex justify-end border-t border-gray-100 pt-5">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            <i class="bi bi-shield-lock"></i>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-layouts.client>