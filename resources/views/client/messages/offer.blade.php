{{-- =========================================================
     PROKERJA OFFER CARD
     Responsive + Chat Friendly
     ========================================================= --}}

<div
    class="prokerja-offer-card w-full max-w-[620px] overflow-hidden rounded-2xl border border-[#D7E3F4] bg-white shadow-[0_4px_18px_rgba(15,23,42,0.06)]"
>
    {{-- =====================================================
         OFFER HEADER
         ====================================================== --}}
    <div class="border-b border-[#E8EEF7] bg-[#F8FBFF] px-4 py-4 sm:px-5">
        <div class="flex items-start justify-between gap-3">

            {{-- LEFT --}}
            <div class="min-w-0 flex-1">

                <div class="mb-2 flex items-center gap-2">
                    <span
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#E6F0FF] text-[#2563EB]"
                    >
                        <i class="bi bi-file-earmark-text text-[15px]"></i>
                    </span>

                    <span
                        class="text-[11px] font-bold uppercase tracking-[0.08em] text-[#2563EB]"
                    >
                        Penawaran
                    </span>
                </div>

                <h3
                    class="break-words text-[16px] font-bold leading-6 text-[#172033] sm:text-[17px]"
                >
                    {{ $offer->title }}
                </h3>

            </div>

            {{-- STATUS --}}
            @php
                $statusConfig = match ($offer->status) {
                    'sent' => [
                        'label' => 'Menunggu',
                        'class' => 'bg-[#EFF6FF] text-[#2563EB] border-[#BFDBFE]',
                    ],
                    'accepted' => [
                        'label' => 'Diterima',
                        'class' => 'bg-[#ECFDF5] text-[#047857] border-[#A7F3D0]',
                    ],
                    'rejected' => [
                        'label' => 'Ditolak',
                        'class' => 'bg-[#FEF2F2] text-[#DC2626] border-[#FECACA]',
                    ],
                    default => [
                        'label' => ucfirst($offer->status),
                        'class' => 'bg-[#F8FAFC] text-[#64748B] border-[#E2E8F0]',
                    ],
                };
            @endphp

            <span
                class="shrink-0 rounded-full border px-2.5 py-1 text-[10px] font-bold sm:px-3 sm:text-[11px] {{ $statusConfig['class'] }}"
            >
                {{ $statusConfig['label'] }}
            </span>

        </div>
    </div>


    {{-- =====================================================
         OFFER BODY
         ====================================================== --}}
    <div class="p-4 sm:p-5">

        {{-- DESCRIPTION --}}
        @if ($offer->description)
            <div class="mb-5">
                <p
                    class="whitespace-pre-line break-words text-[13px] leading-6 text-[#64748B]"
                >
                    {{ $offer->description }}
                </p>
            </div>
        @endif


        {{-- =================================================
             OFFER SUMMARY
             ================================================== --}}
        <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-3">

            {{-- HARGA --}}
            <div
                class="rounded-xl border border-[#E5EDF8] bg-[#F8FBFF] px-3.5 py-3"
            >
                <div class="mb-1 flex items-center gap-1.5">
                    <i class="bi bi-wallet2 text-[12px] text-[#64748B]"></i>

                    <p class="text-[10px] font-semibold uppercase tracking-wide text-[#94A3B8]">
                        Harga
                    </p>
                </div>

                <p
                    class="break-words text-[15px] font-extrabold leading-5 text-[#172033]"
                >
                    Rp {{ number_format($offer->price, 0, ',', '.') }}
                </p>
            </div>


            {{-- PENGERJAAN --}}
            <div
                class="rounded-xl border border-[#E5EDF8] bg-[#F8FBFF] px-3.5 py-3"
            >
                <div class="mb-1 flex items-center gap-1.5">
                    <i class="bi bi-clock text-[12px] text-[#64748B]"></i>

                    <p class="text-[10px] font-semibold uppercase tracking-wide text-[#94A3B8]">
                        Pengerjaan
                    </p>
                </div>

                <p
                    class="text-[15px] font-extrabold leading-5 text-[#172033]"
                >
                    {{ $offer->delivery_days }}
                    <span class="text-[12px] font-semibold text-[#64748B]">
                        hari
                    </span>
                </p>
            </div>


            {{-- REVISI --}}
            <div
                class="rounded-xl border border-[#E5EDF8] bg-[#F8FBFF] px-3.5 py-3"
            >
                <div class="mb-1 flex items-center gap-1.5">
                    <i class="bi bi-arrow-repeat text-[12px] text-[#64748B]"></i>

                    <p class="text-[10px] font-semibold uppercase tracking-wide text-[#94A3B8]">
                        Revisi
                    </p>
                </div>

                <p
                    class="text-[15px] font-extrabold leading-5 text-[#172033]"
                >
                    {{ $offer->revision_count }}
                    <span class="text-[12px] font-semibold text-[#64748B]">
                        kali
                    </span>
                </p>
            </div>

        </div>


        {{-- =================================================
             ACTIONS
             ================================================== --}}
        @if ($offer->status === 'sent')

            <div
                class="mt-5 grid grid-cols-1 gap-2.5 sm:grid-cols-2"
            >

                {{-- ACCEPT --}}
                <form
                    action="{{ route('client.offers.accept', $offer) }}"
                    method="POST"
                    class="min-w-0"
                >
                    @csrf

                    <button
                        type="submit"
                        class="group flex w-full items-center justify-center gap-2 rounded-xl bg-[#2563EB] px-4 py-3 text-[12px] font-bold text-white shadow-[0_5px_14px_rgba(37,99,235,0.20)] transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#1D4ED8] active:translate-y-0"
                    >
                        <i
                            class="bi bi-check-circle text-[14px] transition-transform duration-200 group-hover:scale-110"
                        ></i>

                        <span>Terima Penawaran</span>
                    </button>
                </form>


                {{-- REJECT --}}
                <form
                    action="{{ route('client.offers.reject', $offer) }}"
                    method="POST"
                    class="min-w-0"
                >
                    @csrf

                    <button
                        type="submit"
                        class="group flex w-full items-center justify-center gap-2 rounded-xl border border-[#FECACA] bg-white px-4 py-3 text-[12px] font-bold text-[#DC2626] transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#FEF2F2] active:translate-y-0"
                    >
                        <i
                            class="bi bi-x-circle text-[14px] transition-transform duration-200 group-hover:scale-110"
                        ></i>

                        <span>Tolak</span>
                    </button>
                </form>

            </div>

        @elseif ($offer->accepted_at)

            {{-- ACCEPTED --}}
            <div
                class="mt-4 flex items-start gap-2.5 rounded-xl border border-[#A7F3D0] bg-[#ECFDF5] px-3.5 py-3"
            >
                <i
                    class="bi bi-check-circle-fill mt-0.5 shrink-0 text-[14px] text-[#059669]"
                ></i>

                <p class="text-[12px] font-medium leading-5 text-[#047857]">
                    Penawaran diterima pada
                    <span class="font-bold">
                        {{ $offer->accepted_at->format('d M Y H:i') }}
                    </span>.
                </p>
            </div>

        @elseif ($offer->rejected_at)

            {{-- REJECTED --}}
            <div
                class="mt-4 flex items-start gap-2.5 rounded-xl border border-[#FECACA] bg-[#FEF2F2] px-3.5 py-3"
            >
                <i
                    class="bi bi-x-circle-fill mt-0.5 shrink-0 text-[14px] text-[#DC2626]"
                ></i>

                <p class="text-[12px] font-medium leading-5 text-[#B91C1C]">
                    Penawaran ditolak pada
                    <span class="font-bold">
                        {{ $offer->rejected_at->format('d M Y H:i') }}
                    </span>.
                </p>
            </div>

        @endif

    </div>
</div>


{{-- =========================================================
     OFFER RESPONSIVE FIX
     ========================================================= --}}
<style>
    #prokerja-chat-page .prokerja-offer-card {
        width: 100%;
        max-width: 620px;
        min-width: 0;
        box-sizing: border-box;
    }

    #prokerja-chat-page .prokerja-offer-card * {
        min-width: 0;
        box-sizing: border-box;
    }

    #prokerja-chat-page .prokerja-offer-card h3,
    #prokerja-chat-page .prokerja-offer-card p {
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    @media (max-width: 640px) {
        #prokerja-chat-page .prokerja-offer-card {
            max-width: 100%;
            border-radius: 16px;
        }

        #prokerja-chat-page .prokerja-offer-card .grid {
            grid-template-columns: 1fr;
        }

        #prokerja-chat-page .prokerja-offer-card button {
            min-height: 44px;
        }
    }
</style>