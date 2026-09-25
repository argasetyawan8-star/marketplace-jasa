<x-layouts.marketplace>

    @php
        $freelancer = $order->freelancerProfile;
        $freelancerUser = $freelancer?->user;

        $freelancerName = $freelancerUser?->name ?? 'Freelancer';

        $freelancerAvatar = $freelancer?->avatar
            ? asset('storage/' . $freelancer->avatar)
            : null;

        $freelancerInitial = strtoupper(
            substr($freelancerName, 0, 1)
        );

        $serviceTitle = $order->items->first()?->service_title ?? 'Pesanan jasa';
    @endphp

    <div
        id="prokerjaa-review-page"
        class="min-h-[calc(100vh-72px)] bg-[#F5F8FC]"
    >

        <div class="mx-auto max-w-6xl px-4 py-5 sm:px-6 sm:py-7 lg:px-8 lg:py-9">

            {{-- Back --}}
            <a
                href="{{ route('client.orders.show', $order) }}"
                class="group mb-5 inline-flex items-center gap-2 text-[11px] font-semibold text-slate-500 transition hover:text-blue-600 sm:mb-6"
            >
                <span
                    class="flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white transition group-hover:border-blue-200 group-hover:bg-blue-50"
                >
                    <i class="bi bi-arrow-left text-xs"></i>
                </span>

                Kembali ke detail order
            </a>


            {{-- Header --}}
            <div class="mb-6 sm:mb-7">

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-11 sm:w-11"
                    >
                        <i class="bi bi-star-fill text-sm"></i>
                    </div>

                    <div class="min-w-0">

                        <p
                            class="text-[10px] font-bold uppercase tracking-[0.16em] text-blue-600"
                        >
                            Berikan review
                        </p>

                        <h1
                            class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl"
                        >
                            Bagaimana pengalamanmu?
                        </h1>

                        <p
                            class="mt-1 max-w-xl text-xs leading-5 text-slate-500 sm:text-[13px]"
                        >
                            Review kamu membantu freelancer mendapatkan kepercayaan
                            dari client berikutnya.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Main Grid --}}
            <div
                class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_310px] lg:gap-6"
            >

                {{-- =========================
                    REVIEW FORM
                ========================== --}}
                <div
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_10px_35px_rgba(15,23,42,0.05)]"
                >

                    {{-- Card Header --}}
                    <div
                        class="border-b border-slate-100 px-5 py-5 sm:px-6"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
                            >
                                <i class="bi bi-stars"></i>
                            </div>

                            <div>

                                <h2
                                    class="text-sm font-bold text-slate-900"
                                >
                                    Nilai pekerjaan
                                </h2>

                                <p
                                    class="mt-0.5 text-[10px] text-slate-400"
                                >
                                    Bagikan penilaianmu secara jujur.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Form --}}
                    <form
                        action="{{ route('client.reviews.store', $order) }}"
                        method="POST"
                        class="px-5 py-6 sm:px-6 sm:py-7"
                    >
                        @csrf


                        {{-- Rating --}}
                        <div>

                            <label
                                class="text-xs font-bold text-slate-700"
                            >
                                Rating
                            </label>

                            <p
                                class="mt-1 text-[10px] leading-4 text-slate-400"
                            >
                                Pilih rating dari 1 sampai 5 bintang.
                            </p>


                            <div
                                id="rating-wrapper"
                                class="mt-4 flex gap-2"
                            >

                                @for ($rating = 1; $rating <= 5; $rating++)

                                    <label
                                        class="group cursor-pointer"
                                    >

                                        <input
                                            type="radio"
                                            name="rating"
                                            value="{{ $rating }}"
                                            class="peer sr-only"
                                            {{ old('rating') == $rating ? 'checked' : '' }}
                                            required
                                        >

                                        <span
                                            class="
                                                flex h-11 w-11 items-center justify-center
                                                rounded-xl border border-slate-200
                                                bg-white text-slate-300
                                                shadow-sm
                                                transition-all duration-200
                                                hover:-translate-y-0.5
                                                hover:border-blue-200
                                                hover:bg-blue-50
                                                hover:text-blue-500
                                                peer-checked:border-blue-500
                                                peer-checked:bg-blue-50
                                                peer-checked:text-blue-600
                                                peer-checked:shadow-[0_4px_12px_rgba(37,99,235,0.12)]
                                            "
                                        >
                                            <i class="bi bi-star-fill text-sm"></i>
                                        </span>

                                    </label>

                                @endfor

                            </div>


                            {{-- Rating label --}}
                            <div
                                id="rating-label"
                                class="mt-3 text-[11px] font-semibold text-slate-500"
                            >
                                Belum memilih rating
                            </div>


                            @error('rating')
                                <p class="mt-2 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Comment --}}
                        <div class="mt-7">

                            <div class="flex items-center justify-between gap-3">

                                <div>

                                    <label
                                        for="comment"
                                        class="text-xs font-bold text-slate-700"
                                    >
                                        Ceritakan pengalamanmu
                                    </label>

                                    <p
                                        class="mt-1 text-[10px] leading-4 text-slate-400"
                                    >
                                        Apa yang kamu sukai dari hasil pekerjaan freelancer?
                                    </p>

                                </div>

                                <span
                                    class="hidden rounded-full bg-slate-50 px-2 py-1 text-[9px] font-medium text-slate-400 sm:inline-flex"
                                >
                                    Maks. 2000
                                </span>

                            </div>


                            <div class="relative mt-3">

                                <textarea
                                    id="comment"
                                    name="comment"
                                    rows="7"
                                    required
                                    minlength="10"
                                    maxlength="2000"
                                    placeholder="Contoh: Hasil pekerjaan sesuai brief, komunikasi juga cepat dan mudah..."
                                    class="
                                        w-full resize-none rounded-xl
                                        border border-slate-200
                                        bg-slate-50
                                        px-4 py-3.5
                                        text-sm leading-6 text-slate-800
                                        outline-none
                                        placeholder:text-slate-400
                                        transition
                                        focus:border-blue-400
                                        focus:bg-white
                                        focus:ring-4
                                        focus:ring-blue-50
                                    "
                                >{{ old('comment') }}</textarea>

                            </div>


                            <div
                                class="mt-2 flex items-center justify-between gap-3"
                            >

                                <div>

                                    @error('comment')

                                        <p
                                            class="text-xs font-medium text-red-600"
                                        >
                                            {{ $message }}
                                        </p>

                                    @else

                                        <span
                                            class="text-[10px] text-slate-400"
                                        >
                                            Minimal 10 karakter
                                        </span>

                                    @enderror

                                </div>


                                <span
                                    id="comment-count"
                                    class="text-[10px] font-medium text-slate-400"
                                >
                                    0/2000
                                </span>

                            </div>

                        </div>


                        {{-- Notice --}}
                        <div
                            class="mt-6 rounded-xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                        >

                            <div class="flex items-start gap-2.5">

                                <div
                                    class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-white text-blue-600 shadow-sm"
                                >
                                    <i class="bi bi-info-circle text-xs"></i>
                                </div>

                                <div>

                                    <p
                                        class="text-[10px] font-semibold text-slate-700"
                                    >
                                        Review kamu akan dipublikasikan
                                    </p>

                                    <p
                                        class="mt-0.5 text-[10px] leading-4 text-slate-500"
                                    >
                                        Review akan ditampilkan pada profil freelancer
                                        setelah berhasil dikirim.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Submit --}}
                        <div
                            class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end"
                        >

                            <a
                                href="{{ route('client.orders.show', $order) }}"
                                class="
                                    flex h-11 items-center justify-center
                                    rounded-xl border border-slate-200
                                    bg-white px-5
                                    text-xs font-bold text-slate-600
                                    transition
                                    hover:border-slate-300
                                    hover:bg-slate-50
                                "
                            >
                                Nanti saja
                            </a>


                            <button
                                type="submit"
                                class="
                                    group flex h-11 items-center justify-center gap-2
                                    rounded-xl bg-blue-600 px-6
                                    text-xs font-bold text-white
                                    shadow-[0_6px_18px_rgba(37,99,235,0.18)]
                                    transition-all
                                    hover:-translate-y-0.5
                                    hover:bg-blue-700
                                    hover:shadow-[0_8px_22px_rgba(37,99,235,0.24)]
                                    active:translate-y-0
                                "
                            >

                                <i
                                    class="bi bi-send transition-transform group-hover:translate-x-0.5"
                                ></i>

                                Kirim Review

                            </button>

                        </div>

                    </form>

                </div>



                {{-- =========================
                    SIDEBAR
                ========================== --}}
                <aside class="space-y-5">


                    {{-- Freelancer Card --}}
                    <div
                        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_8px_28px_rgba(15,23,42,0.04)]"
                    >

                        <div class="flex items-center justify-between">

                            <p
                                class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400"
                            >
                                Freelancer
                            </p>

                            <span
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-600"
                            >
                                <i class="bi bi-person text-xs"></i>
                            </span>

                        </div>


                        <div class="mt-4 flex items-center gap-3">

                            {{-- Avatar --}}
                            <div
                                class="
                                    flex h-12 w-12 shrink-0
                                    items-center justify-center
                                    overflow-hidden rounded-full
                                    bg-blue-50
                                    ring-4 ring-slate-50
                                "
                            >

                                @if ($freelancerAvatar)

                                    <img
                                        src="{{ $freelancerAvatar }}"
                                        alt="{{ $freelancerName }}"
                                        class="h-full w-full object-cover"
                                    >

                                @else

                                    <span
                                        class="text-sm font-bold text-blue-600"
                                    >
                                        {{ $freelancerInitial }}
                                    </span>

                                @endif

                            </div>


                            {{-- Freelancer Info --}}
                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-bold text-slate-900"
                                >
                                    {{ $freelancerName }}
                                </p>

                                @if ($freelancer?->headline)

                                    <p
                                        class="mt-0.5 line-clamp-2 text-[10px] leading-4 text-slate-500"
                                    >
                                        {{ $freelancer->headline }}
                                    </p>

                                @else

                                    <p
                                        class="mt-0.5 text-[10px] text-slate-400"
                                    >
                                        Freelancer ProKerjaa
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>



                    {{-- Order Summary --}}
                    <div
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_8px_28px_rgba(15,23,42,0.04)]"
                    >

                        {{-- Summary Header --}}
                        <div
                            class="border-b border-slate-100 px-5 py-4"
                        >

                            <div class="flex items-center justify-between">

                                <div>

                                    <p
                                        class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-400"
                                    >
                                        Order selesai
                                    </p>

                                    <p
                                        class="mt-1 text-xs font-bold text-slate-900"
                                    >
                                        Ringkasan pesanan
                                    </p>

                                </div>

                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600"
                                >
                                    <i class="bi bi-check2-circle text-sm"></i>
                                </div>

                            </div>

                        </div>


                        <div class="px-5 py-5">

                            {{-- Service --}}
                            <div>

                                <p
                                    class="text-xs font-semibold leading-5 text-slate-700"
                                >
                                    {{ $serviceTitle }}
                                </p>

                            </div>


                            {{-- Divider --}}
                            <div
                                class="my-4 border-t border-dashed border-slate-200"
                            ></div>


                            {{-- Order Number --}}
                            <div
                                class="flex items-center justify-between gap-4"
                            >

                                <span
                                    class="text-[11px] text-slate-400"
                                >
                                    Order
                                </span>

                                <span
                                    class="max-w-[170px] truncate text-right text-[11px] font-semibold text-slate-700"
                                >
                                    {{ $order->order_number }}
                                </span>

                            </div>


                            {{-- Total --}}
                            <div
                                class="mt-3 flex items-center justify-between gap-4"
                            >

                                <span
                                    class="text-[11px] text-slate-400"
                                >
                                    Total
                                </span>

                                <span
                                    class="text-xs font-bold text-slate-900"
                                >
                                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                </span>

                            </div>


                            {{-- Completed --}}
                            <div
                                class="mt-3 flex items-center justify-between gap-4"
                            >

                                <span
                                    class="text-[11px] text-slate-400"
                                >
                                    Selesai
                                </span>

                                <span
                                    class="text-[11px] font-semibold text-slate-700"
                                >
                                    {{ $order->completed_at?->format('d M Y') ?? '-' }}
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Trust Note --}}
                    <div
                        class="rounded-2xl border border-slate-200 bg-white p-4"
                    >

                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600"
                            >
                                <i class="bi bi-shield-check text-sm"></i>
                            </div>

                            <div>

                                <p
                                    class="text-[10px] font-bold text-slate-700"
                                >
                                    Review yang jujur
                                </p>

                                <p
                                    class="mt-1 text-[10px] leading-4 text-slate-400"
                                >
                                    Bantu client lain menemukan freelancer
                                    yang sesuai dengan kebutuhan mereka.
                                </p>

                            </div>

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </div>


    {{-- =========================
        SCRIPT
    ========================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const ratingInputs = document.querySelectorAll(
                '#prokerjaa-review-page input[name="rating"]'
            );

            const ratingLabel = document.getElementById(
                'rating-label'
            );

            const comment = document.getElementById(
                'comment'
            );

            const commentCount = document.getElementById(
                'comment-count'
            );


            const ratingText = {
                1: 'Sangat tidak puas',
                2: 'Kurang puas',
                3: 'Cukup puas',
                4: 'Puas',
                5: 'Sangat puas',
            };


            function updateRating() {

                const selected = document.querySelector(
                    '#prokerjaa-review-page input[name="rating"]:checked'
                );

                if (!selected) {

                    ratingLabel.textContent =
                        'Belum memilih rating';

                    return;
                }

                ratingLabel.textContent =
                    `${selected.value} dari 5 — ${ratingText[selected.value]}`;
            }


            function updateCommentCount() {

                if (!comment || !commentCount) {
                    return;
                }

                commentCount.textContent =
                    `${comment.value.length}/2000`;

                if (comment.value.length >= 1900) {

                    commentCount.classList.remove(
                        'text-slate-400'
                    );

                    commentCount.classList.add(
                        'text-amber-600'
                    );

                } else {

                    commentCount.classList.remove(
                        'text-amber-600'
                    );

                    commentCount.classList.add(
                        'text-slate-400'
                    );
                }
            }


            ratingInputs.forEach(function (input) {

                input.addEventListener(
                    'change',
                    updateRating
                );

            });


            if (comment) {

                comment.addEventListener(
                    'input',
                    updateCommentCount
                );

            }


            updateRating();
            updateCommentCount();

        });
    </script>


    {{-- =========================
        PAGE-SCOPED RESPONSIVE CSS
    ========================== --}}
    <style>
        #prokerjaa-review-page {
            -webkit-font-smoothing: antialiased;
        }

        #prokerjaa-review-page textarea {
            scrollbar-width: thin;
        }

        #prokerjaa-review-page input[type="radio"]:focus-visible + span {
            outline: 2px solid #93c5fd;
            outline-offset: 3px;
        }

        @media (max-width: 640px) {

            #prokerjaa-review-page {
                min-height: calc(100vh - 64px);
            }

            #prokerjaa-review-page textarea {
                min-height: 170px;
            }

            #prokerjaa-review-page #rating-wrapper {
                width: 100%;
            }

            #prokerjaa-review-page #rating-wrapper label {
                flex: 1;
            }

            #prokerjaa-review-page #rating-wrapper span {
                width: 100%;
            }

        }
    </style>

</x-layouts.marketplace>