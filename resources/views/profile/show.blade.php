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
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h1 class="text-2xl font-semibold text-[#1F2937]">
                        Profil Saya
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Lihat informasi akun dan profil kamu.
                    </p>

                </div>


                {{-- Dashboard --}}
                <a
                    href="{{ route('client.dashboard') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700"
                >

                    <i class="bi bi-grid"></i>

                    Dashboard

                </a>

            </div>


            {{-- Success --}}
            @if (session('success'))

                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Profile Card --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

                {{-- Profile Header --}}
                <div class="border-b border-gray-100 px-5 py-6 sm:px-6">

                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-4">

                            {{-- Avatar --}}
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


                            {{-- Name --}}
                            <div class="min-w-0">

                                <h2 class="truncate text-xl font-semibold text-gray-900">
                                    {{ $user->name }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Client JASAIN
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    Bergabung sejak {{ $user->created_at?->translatedFormat('d F Y') }}
                                </p>

                            </div>

                        </div>


                        {{-- Edit --}}
                        <a
                            href="{{ route('profile.edit') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#22C55E] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#16A34A]"
                        >

                            <i class="bi bi-pencil"></i>

                            Edit Profile

                        </a>

                    </div>

                </div>


                {{-- Information --}}
                <div class="p-5 sm:p-6">

                    <div class="grid gap-6 sm:grid-cols-2">


                        {{-- Email --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                Email
                            </p>

                            <div class="mt-2 flex items-center gap-2">

                                <i class="bi bi-envelope text-gray-400"></i>

                                <p class="text-sm text-gray-700">
                                    {{ $user->email }}
                                </p>

                            </div>

                        </div>


                        {{-- Phone --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                Nomor HP
                            </p>

                            <div class="mt-2 flex items-center gap-2">

                                <i class="bi bi-telephone text-gray-400"></i>

                                <p class="text-sm text-gray-700">

                                    {{ $profile->phone ?: 'Belum diisi' }}

                                </p>

                            </div>

                        </div>


                        {{-- Location --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                Lokasi
                            </p>

                            <div class="mt-2 flex items-center gap-2">

                                <i class="bi bi-geo-alt text-gray-400"></i>

                                <p class="text-sm text-gray-700">

                                    {{ $profile->location ?: 'Belum diisi' }}

                                </p>

                            </div>

                        </div>


                        {{-- Account --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                Tipe Akun
                            </p>

                            <div class="mt-2 flex items-center gap-2">

                                <i class="bi bi-person text-gray-400"></i>

                                <p class="text-sm text-gray-700">
                                    Client
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Bio --}}
                    <div class="mt-8 border-t border-gray-100 pt-6">

                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Tentang Saya
                        </p>

                        @if ($profile->bio)

                            <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600">
                                {{ $profile->bio }}
                            </p>

                        @else

                            <p class="mt-3 text-sm text-gray-400">
                                Kamu belum menambahkan bio.
                            </p>

                        @endif

                    </div>

                </div>

            </div>


            {{-- Account Information --}}
            <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">

                        <i class="bi bi-shield-check text-lg"></i>

                    </div>


                    <div>

                        <h3 class="text-sm font-semibold text-gray-900">
                            Keamanan Akun
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-gray-500">
                            Untuk mengubah password atau informasi profil,
                            gunakan halaman edit profile.
                        </p>

                        <a
                            href="{{ route('profile.edit') }}"
                            class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-green-600 hover:text-green-700"
                        >

                            Kelola Profile

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-layouts.client>
