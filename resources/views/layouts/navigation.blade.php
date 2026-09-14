<nav class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- Logo --}}
        <a
            href="{{ url('/') }}"
            class="flex items-center gap-3"
        >
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#2E3192] text-xs font-black text-white">
                MJ
            </div>

            <span class="text-sm font-extrabold tracking-tight text-slate-800">
                Marketplace Jasa
            </span>
        </a>


        {{-- Right menu --}}
        <div class="flex items-center gap-4">

            <span class="hidden text-sm text-slate-500 sm:block">
                {{ Auth::user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="rounded-lg px-3 py-2 text-xs font-bold text-slate-500 transition hover:bg-slate-100 hover:text-[#2E3192]"
                >
                    Keluar
                </button>
            </form>

        </div>

    </div>
</nav>