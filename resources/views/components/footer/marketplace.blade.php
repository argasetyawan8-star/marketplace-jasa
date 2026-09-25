<footer class="border-t border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        <div class="flex flex-col items-center justify-between gap-6 sm:flex-row">

            {{-- Logo ProKerja --}}
            <a
                href="{{ Route::has('marketplace.home') ? route('marketplace.home') : url('/') }}"
                class="group flex items-center gap-3"
            >
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#2563EB] text-white shadow-sm transition duration-200 group-hover:scale-105 group-hover:bg-blue-700"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M12 3v18"/>
                        <path d="M5 8h14"/>
                        <path d="M7 8c0 4 2 6 5 6s5-2 5-6"/>
                        <path d="M5 18h14"/>
                    </svg>
                </div>

                <div class="leading-none">
                    <div class="text-lg font-extrabold tracking-tight text-slate-900">
                        ProKerja
                    </div>

                    <div class="mt-1 text-[10px] font-medium uppercase tracking-[0.16em] text-slate-400">
                        Marketplace Jasa
                    </div>
                </div>
            </a>


            {{-- Social Media --}}
            <div class="flex items-center gap-2">

                {{-- Instagram --}}
                <a
                    href="#"
                    aria-label="Instagram ProKerja"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect x="3" y="3" width="18" height="18" rx="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r=".8" fill="currentColor" stroke="none"/>
                    </svg>
                </a>


                {{-- Facebook --}}
                <a
                    href="#"
                    aria-label="Facebook ProKerja"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                    >
                        <path d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.6 1.7-1.6h1.8V3.8c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V10H8v3h2.3v8h3.2Z"/>
                    </svg>
                </a>


                {{-- TikTok --}}
                <a
                    href="#"
                    aria-label="TikTok ProKerja"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M15 4c.2 2 1.3 3.3 3.5 3.5V11c-1.4-.1-2.7-.5-3.7-1.2v5.4a5.2 5.2 0 1 1-4.5-5.1v3.4a1.9 1.9 0 1 0 1.4 1.8V4H15Z"/>
                    </svg>
                </a>


                {{-- LinkedIn --}}
                <a
                    href="#"
                    aria-label="LinkedIn ProKerja"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition duration-200 hover:border-blue-200 hover:bg-blue-50 hover:text-[#2563EB]"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                    >
                        <path d="M6.5 8.2A1.7 1.7 0 1 0 6.5 4.8a1.7 1.7 0 0 0 0 3.4ZM5 19h3V9.8H5V19Zm5 0h3v-5.1c0-1.4.3-2.7 2-2.7s1.9 1.5 1.9 2.8V19H20v-5.7c0-2.8-.6-4.9-4-4.9-1.6 0-2.6.9-3 1.6h-.1V9.8h-2.9V19Z"/>
                    </svg>
                </a>

            </div>

        </div>


        {{-- Copyright --}}
        <div class="mt-6 border-t border-slate-100 pt-5 text-center">
            <p class="text-xs text-slate-400 sm:text-sm">
                © {{ date('Y') }} ProKerja. Semua hak dilindungi.
            </p>
        </div>

    </div>
</footer>