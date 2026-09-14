<x-layouts.client>

    <div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">

        <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">

            {{-- Header --}}
            <div class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

                <div>
                    <div class="flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#1E9E5A]"></span>
                        Komunikasi
                    </div>

                    <h1 class="mt-2 text-2xl font-semibold tracking-[-0.03em] text-[#123128] sm:text-[28px]">
                        Pesan
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-[#71837B]">
                        Diskusikan kebutuhan pekerjaanmu langsung dengan freelancer sebelum memulai pesanan.
                    </p>
                </div>

                @if($conversations->count())
                    <a
                        href="{{ route('marketplace.search') }}"
                        class="inline-flex h-10 shrink-0 items-center justify-center gap-2 rounded-xl border border-[#DCE8E1] bg-white px-4 text-xs font-semibold text-[#355248] shadow-[0_2px_8px_rgba(18,49,40,0.03)] transition duration-200 hover:border-[#B9DCC8] hover:bg-[#F7FBF8] hover:text-[#0F6B3A]"
                    >
                        <i class="bi bi-search text-[13px]"></i>
                        Cari freelancer
                    </a>
                @endif

            </div>


            {{-- Success --}}
            @if(session('success'))

                <div class="mb-6 overflow-hidden rounded-xl border border-[#CDEBD8] bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#EAF7EF]">
                            <i class="bi bi-check-lg text-sm font-semibold text-[#1E9E5A]"></i>
                        </div>

                        <p class="text-sm text-[#355248]">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- Error --}}
            @if(session('error'))

                <div class="mb-6 overflow-hidden rounded-xl border border-red-100 bg-white shadow-[0_4px_16px_rgba(18,49,40,0.04)]">

                    <div class="flex items-center gap-3 px-4 py-3.5">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-50">
                            <i class="bi bi-exclamation-lg text-sm font-semibold text-red-500"></i>
                        </div>

                        <p class="text-sm text-red-600">
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- Conversations --}}
            @if($conversations->count())

                <div class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_8px_30px_rgba(18,49,40,0.05)]">

                    {{-- List Header --}}
                    <div class="flex items-center justify-between border-b border-[#EDF2EF] px-5 py-4 sm:px-6">

                        <div>
                            <h2 class="text-sm font-semibold text-[#123128]">
                                Percakapan
                            </h2>

                            <p class="mt-0.5 text-[11px] text-[#8A9A93]">
                                {{ $conversations->count() }} percakapan
                            </p>
                        </div>

                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EAF7EF] text-[#1E9E5A]">
                            <i class="bi bi-chat-text text-sm"></i>
                        </div>

                    </div>


                    {{-- Conversation Rows --}}
                    <div class="divide-y divide-[#EDF2EF]">

                        @foreach($conversations as $conversation)

                            @php
                                $freelancer = $conversation->freelancerProfile;

                                $freelancerAvatar = $freelancer?->avatar
                                    ? asset('storage/' . $freelancer->avatar)
                                    : null;

                                $freelancerName = $freelancer?->user?->name ?? 'Freelancer';

                                $freelancerInitial = strtoupper(
                                    substr($freelancerName, 0, 1)
                                );
                            @endphp


                            <a
                                href="{{ route('client.messages.show', $conversation) }}"
                                class="group block px-5 py-5 transition duration-200 hover:bg-[#FBFDFC] sm:px-6"
                            >

                                <div class="flex items-center gap-4">

                                    {{-- Avatar --}}
                                    <div class="relative shrink-0">

                                        <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF] ring-4 ring-white">

                                            @if($freelancerAvatar)

                                                <img
                                                    src="{{ $freelancerAvatar }}"
                                                    alt="{{ $freelancerName }}"
                                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                                >

                                            @else

                                                <span class="text-sm font-semibold text-[#1E9E5A]">
                                                    {{ $freelancerInitial }}
                                                </span>

                                            @endif

                                        </div>

                                        {{-- Online indicator --}}
                                        <span class="absolute bottom-0.5 right-0.5 h-3.5 w-3.5 rounded-full border-[3px] border-white bg-[#35C978]"></span>

                                    </div>


                                    {{-- Content --}}
                                    <div class="min-w-0 flex-1">

                                        <div class="flex items-start justify-between gap-4">

                                            <div class="min-w-0">

                                                <h3 class="truncate text-sm font-semibold text-[#18382E] transition group-hover:text-[#0F6B3A]">
                                                    {{ $freelancerName }}
                                                </h3>

                                                <p class="mt-1 truncate text-xs font-medium text-[#71837B]">
                                                    {{ $conversation->service?->title ?? 'Percakapan umum' }}
                                                </p>

                                            </div>


                                            @if($conversation->last_message_at)

                                                <span class="shrink-0 whitespace-nowrap text-[10px] font-medium text-[#98A69F]">
                                                    {{ $conversation->last_message_at->diffForHumans() }}
                                                </span>

                                            @endif

                                        </div>


                                        <div class="mt-2.5 flex items-center justify-between gap-4">

                                            <div class="flex min-w-0 items-center gap-2">

                                                <span class="h-1 w-1 shrink-0 rounded-full bg-[#B7C5BE]"></span>

                                                <p class="truncate text-xs text-[#8A9992]">

                                                    @if($conversation->messages_count > 0)

                                                        {{ $conversation->messages_count }} pesan

                                                    @else

                                                        Belum ada pesan

                                                    @endif

                                                </p>

                                            </div>


                                            {{-- Arrow --}}
                                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-[#A3B0AA] transition duration-200 group-hover:bg-[#EAF7EF] group-hover:text-[#1E9E5A]">

                                                <i class="bi bi-arrow-up-right text-xs transition-transform duration-200 group-hover:translate-x-[1px] group-hover:-translate-y-[1px]"></i>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </a>

                        @endforeach

                    </div>

                </div>


            @else

                {{-- Empty State --}}
                <div class="overflow-hidden rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_8px_30px_rgba(18,49,40,0.05)]">

                    <div class="relative px-6 py-16 text-center sm:px-10 sm:py-20">

                        {{-- Decorative background --}}
                        <div class="pointer-events-none absolute inset-0 overflow-hidden">

                            <div class="absolute left-1/2 top-10 h-32 w-32 -translate-x-1/2 rounded-full bg-[#EAF7EF] opacity-60 blur-3xl"></div>

                        </div>


                        <div class="relative">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-[#D8EBDD] bg-[#F3FAF5] text-[#1E9E5A] shadow-sm">

                                <i class="bi bi-chat-square-text text-[23px]"></i>

                            </div>


                            <p class="mt-6 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#1E9E5A]">
                                Belum ada aktivitas
                            </p>


                            <h2 class="mt-2 text-xl font-semibold tracking-[-0.02em] text-[#123128]">
                                Mulai percakapan pertamamu
                            </h2>


                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#7A8C84]">
                                Hubungi freelancer dari halaman jasa untuk menanyakan detail pekerjaan,
                                berdiskusi tentang kebutuhanmu, dan mendapatkan penawaran.
                            </p>


                            <a
                                href="{{ route('marketplace.search') }}"
                                class="mt-7 inline-flex h-11 items-center gap-2 rounded-xl bg-[#1E9E5A] px-5 text-xs font-semibold text-white shadow-[0_5px_18px_rgba(30,158,90,0.18)] transition duration-200 hover:bg-[#0F6B3A] hover:shadow-[0_7px_22px_rgba(30,158,90,0.22)]"
                            >
                                <i class="bi bi-search"></i>
                                Cari jasa
                                <i class="bi bi-arrow-right text-[11px]"></i>
                            </a>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-layouts.client>