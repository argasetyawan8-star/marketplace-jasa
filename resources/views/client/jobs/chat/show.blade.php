<x-layouts.marketplace>

    @php
        $proposal = $conversation->proposal;

        $freelancer = $conversation->freelancerProfile;

        $freelancerUser = $freelancer?->user;

        $freelancerName =
            $proposal?->display_name
            ?: $freelancerUser?->name
            ?: 'Freelancer';

        $freelancerAvatar = $freelancer?->avatar
            ? asset('storage/' . $freelancer->avatar)
            : null;

        $freelancerInitial = strtoupper(
            mb_substr($freelancerName, 0, 1)
        );
    @endphp

    <main class="min-h-[calc(100vh-72px)] bg-[#F8FAFC]">

        <section class="mx-auto max-w-6xl px-4 py-5 sm:px-6 sm:py-7 lg:px-8">

            {{-- Back --}}
            <div class="mb-5">
                <a
                    href="{{ route('client.jobs.show', $job) }}"
                    class="group inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#2563EB]"
                >
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm transition group-hover:border-blue-100 group-hover:bg-blue-50 group-hover:text-[#2563EB]">
                        <i class="bi bi-arrow-left"></i>
                    </span>

                    Kembali ke Job
                </a>
            </div>

            {{-- Chat Card --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                {{-- =====================================================
                    CHAT HEADER
                ====================================================== --}}
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-4 py-4 sm:px-6">

                    <div class="flex min-w-0 items-center gap-3">

                        {{-- Avatar --}}
                        <div class="relative shrink-0">

                            <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-blue-50 text-sm font-bold text-[#2563EB] ring-1 ring-blue-100">

                                @if($freelancerAvatar)

                                    <img
                                        src="{{ $freelancerAvatar }}"
                                        alt="{{ $freelancerName }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    {{ $freelancerInitial }}

                                @endif

                            </div>

                            {{-- Online indicator --}}
                            <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full border-2 border-white bg-emerald-500"></span>

                        </div>

                        {{-- Freelancer Info --}}
                        <div class="min-w-0">

                            <div class="flex items-center gap-2">

                                <p class="truncate text-sm font-bold text-slate-900 sm:text-base">
                                    {{ $freelancerName }}
                                </p>

                                <span class="hidden rounded-full bg-blue-50 px-2 py-0.5 text-[9px] font-semibold text-[#2563EB] sm:inline-flex">
                                    Freelancer
                                </span>

                            </div>

                            <p class="mt-0.5 truncate text-xs text-slate-500">
                                {{ $job->title }}
                            </p>

                        </div>

                    </div>

                    {{-- Chat Label --}}
                    <div class="hidden shrink-0 items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 sm:flex">

                        <span class="h-1.5 w-1.5 rounded-full bg-[#2563EB]"></span>

                        <span class="text-[10px] font-semibold uppercase tracking-wider text-[#2563EB]">
                            Job Chat
                        </span>

                    </div>

                </div>


                {{-- =====================================================
                    PROPOSAL SUMMARY
                ====================================================== --}}
                <div class="border-b border-slate-100 bg-slate-50/70 px-4 py-4 sm:px-6">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-2">

                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-white text-[#2563EB] shadow-sm ring-1 ring-slate-200">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                                    Proposal
                                </p>

                                <p class="text-xs font-semibold text-slate-800">
                                    Penawaran freelancer
                                </p>
                            </div>

                        </div>

                        <div class="flex flex-wrap items-center gap-2">

                            {{-- Price --}}
                            <div class="rounded-xl border border-blue-100 bg-blue-50 px-3 py-2">

                                <p class="text-[9px] font-medium uppercase tracking-wider text-blue-500">
                                    Harga
                                </p>

                                <p class="mt-0.5 text-sm font-bold text-[#2563EB]">
                                    Rp {{ number_format((float) $proposal->price, 0, ',', '.') }}
                                </p>

                            </div>

                            {{-- Duration --}}
                            <div class="rounded-xl border border-slate-200 bg-white px-3 py-2">

                                <p class="text-[9px] font-medium uppercase tracking-wider text-slate-400">
                                    Durasi
                                </p>

                                <p class="mt-0.5 text-sm font-semibold text-slate-700">
                                    {{ $proposal->delivery_days }} hari
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    MESSAGES
                ====================================================== --}}
                <div
                    id="job-chat-messages"
                    class="h-[55vh] min-h-[420px] space-y-5 overflow-y-auto bg-white px-4 py-5 sm:px-6"
                >

                    @forelse($conversation->messages as $message)

                        @php
                            $mine = $message->user_id === auth()->id();
                        @endphp

                        <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }}">

                            <div class="max-w-[88%] sm:max-w-[70%]">

                                {{-- Message --}}
                                <div
                                    class="
                                        rounded-2xl px-4 py-3 text-sm leading-6 shadow-sm
                                        transition
                                        {{ $mine
                                            ? 'rounded-br-md bg-[#2563EB] text-white shadow-blue-100'
                                            : 'rounded-bl-md border border-slate-200 bg-slate-50 text-slate-700'
                                        }}
                                    "
                                >
                                    {{ $message->body }}
                                </div>

                                {{-- Time --}}
                                <p
                                    class="
                                        mt-1.5 px-1 text-[10px] text-slate-400
                                        {{ $mine ? 'text-right' : '' }}
                                    "
                                >
                                    {{ $message->created_at->format('H:i') }}
                                </p>

                            </div>

                        </div>

                    @empty

                        {{-- Empty Chat --}}
                        <div class="flex h-full min-h-[380px] items-center justify-center px-6 text-center">

                            <div class="max-w-sm">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-xl text-[#2563EB]">
                                    <i class="bi bi-chat-square-text"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-bold text-slate-900">
                                    Mulai diskusi
                                </h3>

                                <p class="mt-1.5 text-xs leading-5 text-slate-500">
                                    Diskusikan detail pekerjaan, kebutuhan,
                                    deadline, dan penawaran dengan freelancer.
                                </p>

                                <div class="mt-4 inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1.5 text-[10px] font-medium text-slate-500">
                                    <i class="bi bi-shield-check text-blue-500"></i>
                                    Tetap komunikasikan pekerjaan melalui ProKerja
                                </div>

                            </div>

                        </div>

                    @endforelse

                </div>


                {{-- =====================================================
                    COMPOSER
                ====================================================== --}}
                <div class="border-t border-slate-100 bg-slate-50/70 px-4 py-4 sm:px-6">

                    @if(session('success'))

                        <div class="mb-3 flex items-center gap-2 rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-2.5 text-xs font-medium text-emerald-700">

                            <i class="bi bi-check-circle"></i>

                            <span>
                                {{ session('success') }}
                            </span>

                        </div>

                    @endif

                    <form
                        method="POST"
                        action="{{ route('client.jobs.chat.messages.store', [$job, $conversation]) }}"
                        class="flex items-end gap-2 sm:gap-3"
                    >

                        @csrf

                        {{-- Message Input --}}
                        <div class="relative flex-1">

                            <textarea
                                name="body"
                                rows="2"
                                required
                                maxlength="5000"
                                placeholder="Tulis pesan untuk freelancer..."
                                class="min-h-[48px] w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-3 pr-12 text-sm leading-5 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#2563EB] focus:ring-4 focus:ring-blue-50"
                            ></textarea>

                        </div>

                        {{-- Send --}}
                        <button
                            type="submit"
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#2563EB] text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-blue-100"
                            title="Kirim pesan"
                        >
                            <i class="bi bi-send-fill text-sm"></i>
                        </button>

                    </form>

                    <div class="mt-2 flex items-center justify-between gap-3">

                        <p class="text-[10px] text-slate-400">
                            Maksimal 5.000 karakter
                        </p>

                        <p class="hidden items-center gap-1 text-[10px] text-slate-400 sm:flex">
                            <i class="bi bi-shield-check text-emerald-500"></i>
                            Percakapan aman di ProKerja
                        </p>

                    </div>

                </div>

            </div>

        </section>

    </main>


    {{-- Auto Scroll --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const box = document.getElementById('job-chat-messages');

            if (box) {
                box.scrollTop = box.scrollHeight;
            }
        });
    </script>

</x-layouts.marketplace>