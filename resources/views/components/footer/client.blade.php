<footer class="border-t border-[#E3EBE6] bg-white">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Main Footer --}}
        <div class="grid gap-10 py-10 sm:grid-cols-2 lg:grid-cols-4 lg:py-12">

            {{-- Brand --}}
            <div class="sm:col-span-2 lg:col-span-1">

                <a
                    href="{{ route('marketplace.home') }}"
                    class="group inline-flex items-center gap-2.5"
                >

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#1E9E5A] text-white shadow-[0_4px_12px_rgba(30,158,90,0.12)] transition duration-200 group-hover:bg-[#0F6B3A]"
                    >
                        <span class="text-[15px] font-semibold">
                            J
                        </span>
                    </div>

                    <div>

                        <p class="text-[16px] font-semibold tracking-[-0.035em] text-[#123128]">
                            JASAIN
                        </p>

                        <p class="-mt-0.5 text-[8px] font-medium uppercase tracking-[0.16em] text-[#899890]">
                            Marketplace Jasa
                        </p>

                    </div>

                </a>


                <p class="mt-4 max-w-xs text-xs leading-6 text-[#7B8C84]">
                    Temukan freelancer terpercaya untuk membantu berbagai kebutuhan
                    pekerjaanmu dengan lebih mudah dan nyaman.
                </p>

            </div>


            {{-- Marketplace --}}
            <div>

                <h3 class="text-xs font-semibold text-[#18382E]">
                    Marketplace
                </h3>

                <div class="mt-4 space-y-3">

                    <a
                        href="{{ route('marketplace.search') }}"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Cari jasa
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                    <a
                        href="{{ route('marketplace.home') }}"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Beranda
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                    <a
                        href="{{ route('client.favorites.index') }}"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Jasa favorit
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                </div>

            </div>


            {{-- Akun --}}
            <div>

                <h3 class="text-xs font-semibold text-[#18382E]">
                    Akun saya
                </h3>

                <div class="mt-4 space-y-3">

                    <a
                        href="{{ route('client.dashboard') }}"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Dashboard
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                    <a
                        href="{{ route('client.orders.index') }}"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Pesanan
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                    <a
                        href="{{ route('client.messages.index') }}"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Pesan
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                    <a
                        href="{{ route('profile.show') }}"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Profil
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                </div>

            </div>


            {{-- Bantuan --}}
            <div>

                <h3 class="text-xs font-semibold text-[#18382E]">
                    Bantuan
                </h3>

                <div class="mt-4 space-y-3">

                    <a
                        href="#"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Pusat bantuan
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                    <a
                        href="#"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Syarat & ketentuan
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                    <a
                        href="#"
                        class="group flex items-center gap-2 text-xs text-[#7B8C84] transition duration-200 hover:text-[#1E9E5A]"
                    >
                        Kebijakan privasi
                        <i class="bi bi-arrow-up-right text-[9px] opacity-0 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:opacity-100"></i>
                    </a>

                </div>

            </div>

        </div>


        {{-- Bottom Footer --}}
        <div class="flex flex-col gap-5 border-t border-[#E7EEE9] py-5 sm:flex-row sm:items-center sm:justify-between">

            <p class="text-[10px] leading-5 text-[#919F99]">
                © {{ date('Y') }} JASAIN. Semua hak dilindungi.
            </p>


            <div class="flex items-center gap-2">

                <a
                    href="#"
                    aria-label="Instagram"
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-[#899890] transition duration-200 hover:bg-[#EAF7EF] hover:text-[#1E9E5A]"
                >
                    <i class="bi bi-instagram text-[13px]"></i>
                </a>

                <a
                    href="#"
                    aria-label="Facebook"
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-[#899890] transition duration-200 hover:bg-[#EAF7EF] hover:text-[#1E9E5A]"
                >
                    <i class="bi bi-facebook text-[13px]"></i>
                </a>

                <a
                    href="#"
                    aria-label="LinkedIn"
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-[#899890] transition duration-200 hover:bg-[#EAF7EF] hover:text-[#1E9E5A]"
                >
                    <i class="bi bi-linkedin text-[13px]"></i>
                </a>

            </div>

        </div>

    </div>

</footer>