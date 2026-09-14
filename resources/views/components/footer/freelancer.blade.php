<footer class="border-t border-gray-200 bg-white">

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <div class="flex items-center gap-2.5">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#22C55E]">

                        <span class="text-sm font-bold text-white">
                            J
                        </span>

                    </div>

                    <div>

                        <p class="text-sm font-semibold text-gray-900">
                            JASAIN
                        </p>

                        <p class="text-[10px] text-gray-400">
                            Marketplace Jasa
                        </p>

                    </div>

                </div>

                <p class="mt-3 text-xs text-gray-400">
                    Kelola jasa, pesanan, dan penghasilanmu di JASAIN.
                </p>

            </div>


            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs">

                <a
                    href="{{ route('marketplace.home') }}"
                    class="text-gray-500 transition hover:text-[#16A34A]"
                >
                    Beranda
                </a>

                <a
                    href="{{ route('freelancer.dashboard') }}"
                    class="text-gray-500 transition hover:text-[#16A34A]"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('freelancer.profile.show') }}"
                    class="text-gray-500 transition hover:text-[#16A34A]"
                >
                    Profil
                </a>

            </div>

        </div>


        <div class="mt-6 border-t border-gray-100 pt-5">

            <p class="text-xs text-gray-400">
                © {{ date('Y') }} JASAIN. All rights reserved.
            </p>

        </div>

    </div>

</footer>