<x-layouts.client>


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
@endphp


<div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">

    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

        {{-- Back --}}
        <a
            href="{{ route('client.orders.show', $order) }}"
            class="mb-5 inline-flex items-center gap-2 text-xs font-medium text-[#71837B] transition hover:text-[#0F6B3A]"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke detail order
        </a>


        {{-- Header --}}
        <div class="mb-6">

            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#1E9E5A]">
                Berikan review
            </p>

            <h1 class="mt-1 text-xl font-semibold tracking-tight text-[#123128] sm:text-2xl">
                Bagaimana pengalamanmu?
            </h1>

            <p class="mt-1 max-w-xl text-xs leading-5 text-[#71837B]">
                Review kamu membantu freelancer mendapatkan kepercayaan dari client berikutnya.
            </p>

        </div>


        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_300px]">


            {{-- Review Form --}}
            <div class="rounded-2xl border border-[#E1EAE5] bg-white shadow-[0_8px_30px_rgba(18,49,40,0.05)]">

                <div class="border-b border-[#E8EFEB] px-5 py-5 sm:px-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF7EF] text-[#1E9E5A]">
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#123128]">
                                Nilai pekerjaan
                            </h2>

                            <p class="mt-0.5 text-[10px] text-[#91A099]">
                                Bagikan penilaianmu secara jujur.
                            </p>

                        </div>

                    </div>

                </div>


                <form
                    action="{{ route('client.reviews.store', $order) }}"
                    method="POST"
                    class="px-5 py-6 sm:px-6"
                >

                    @csrf


                    {{-- Rating --}}
                    <div>

                        <label class="text-xs font-semibold text-[#355248]">
                            Rating
                        </label>

                        <p class="mt-1 text-[10px] text-[#91A099]">
                            Pilih rating dari 1 sampai 5 bintang.
                        </p>


                        <div class="mt-4 flex flex-wrap gap-2" id="rating-wrapper">

                            @for ($rating = 1; $rating <= 5; $rating++)

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="rating"
                                        value="{{ $rating }}"
                                        class="peer sr-only"
                                        {{ old('rating') == $rating ? 'checked' : '' }}
                                        required
                                    >

                                    <span
                                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-[#DDE8E1] bg-white text-[#CBD6D1] transition peer-checked:border-[#1E9E5A] peer-checked:bg-[#EAF7EF] peer-checked:text-[#1E9E5A] hover:border-[#B9D5C3] hover:text-[#1E9E5A]"
                                    >
                                        <i class="bi bi-star-fill"></i>
                                    </span>

                                </label>

                            @endfor

                        </div>


                        <div
                            id="rating-label"
                            class="mt-3 text-[11px] font-medium text-[#71837B]"
                        >
                            Belum memilih rating
                        </div>


                        @error('rating')

                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Comment --}}
                    <div class="mt-7">

                        <label
                            for="comment"
                            class="text-xs font-semibold text-[#355248]"
                        >
                            Ceritakan pengalamanmu
                        </label>

                        <p class="mt-1 text-[10px] text-[#91A099]">
                            Apa yang kamu sukai dari hasil pekerjaan freelancer?
                        </p>


                        <textarea
                            id="comment"
                            name="comment"
                            rows="7"
                            required
                            minlength="10"
                            maxlength="2000"
                            placeholder="Contoh: Hasil pekerjaan sesuai brief, komunikasi juga cepat dan mudah..."
                            class="mt-3 w-full rounded-xl border border-[#DCE7E1] bg-[#FAFCFB] px-4 py-3 text-sm leading-6 text-[#123128] outline-none placeholder:text-[#A0ADA7] transition focus:border-[#9ACCB0] focus:bg-white focus:ring-2 focus:ring-[#EAF7EF]"
                        >{{ old('comment') }}</textarea>


                        <div class="mt-2 flex items-center justify-between">

                            @error('comment')

                                <p class="text-xs text-red-600">
                                    {{ $message }}
                                </p>

                            @else

                                <span class="text-[10px] text-[#A0ADA7]">
                                    Minimal 10 karakter
                                </span>

                            @enderror

                            <span
                                id="comment-count"
                                class="text-[10px] text-[#A0ADA7]"
                            >
                                0/2000
                            </span>

                        </div>

                    </div>


                    {{-- Notice --}}
                    <div class="mt-6 rounded-xl border border-[#DCE9E1] bg-[#F5FBF7] px-4 py-3">

                        <div class="flex items-start gap-2.5">

                            <i class="bi bi-info-circle mt-0.5 text-sm text-[#1E9E5A]"></i>

                            <p class="text-[10px] leading-4 text-[#667D73]">
                                Review akan ditampilkan pada profil freelancer setelah berhasil dikirim.
                            </p>

                        </div>

                    </div>


                    {{-- Submit --}}
                    <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('client.orders.show', $order) }}"
                            class="flex h-11 items-center justify-center rounded-xl border border-[#DDE7E1] px-5 text-xs font-semibold text-[#667870] transition hover:bg-[#F7FAF8]"
                        >
                            Nanti saja
                        </a>

                        <button
                            type="submit"
                            class="flex h-11 items-center justify-center gap-2 rounded-xl bg-[#1E9E5A] px-6 text-xs font-semibold text-white shadow-sm transition hover:bg-[#0F6B3A]"
                        >
                            <i class="bi bi-send"></i>
                            Kirim Review
                        </button>

                    </div>

                </form>

            </div>


            {{-- Order Summary --}}
            <aside class="space-y-5">


                {{-- Freelancer --}}
                <div class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_6px_24px_rgba(18,49,40,0.04)]">

                    <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#91A099]">
                        Freelancer
                    </p>


                    <div class="mt-4 flex items-center gap-3">

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#EAF7EF]">

                            @if ($freelancerAvatar)

                                <img
                                    src="{{ $freelancerAvatar }}"
                                    alt="{{ $freelancerName }}"
                                    class="h-full w-full object-cover"
                                >

                            @else

                                <span class="text-sm font-semibold text-[#1E9E5A]">
                                    {{ $freelancerInitial }}
                                </span>

                            @endif

                        </div>


                        <div class="min-w-0">

                            <p class="truncate text-sm font-semibold text-[#123128]">
                                {{ $freelancerName }}
                            </p>

                            @if ($freelancer?->headline)

                                <p class="mt-0.5 line-clamp-2 text-[10px] leading-4 text-[#81918A]">
                                    {{ $freelancer->headline }}
                                </p>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- Order --}}
                <div class="rounded-2xl border border-[#E1EAE5] bg-white p-5 shadow-[0_6px_24px_rgba(18,49,40,0.04)]">

                    <p class="text-[9px] font-semibold uppercase tracking-[0.14em] text-[#91A099]">
                        Order selesai
                    </p>


                    <div class="mt-4">

                        <p class="text-xs font-medium leading-5 text-[#355248]">
                            {{ $order->items->first()?->service_title ?? 'Pesanan jasa' }}
                        </p>

                        <div class="mt-3 space-y-2.5">

                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[11px] text-[#81918A]">
                                    Order
                                </span>

                                <span class="text-[11px] font-medium text-[#355248]">
                                    {{ $order->order_number }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[11px] text-[#81918A]">
                                    Total
                                </span>

                                <span class="text-xs font-semibold text-[#123128]">
                                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between gap-3">

                                <span class="text-[11px] text-[#81918A]">
                                    Selesai
                                </span>

                                <span class="text-[11px] font-medium text-[#355248]">
                                    {{ $order->completed_at?->format('d M Y') ?? '-' }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const ratingInputs = document.querySelectorAll(
            'input[name="rating"]'
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
                'input[name="rating"]:checked'
            );

            if (!selected) {
                ratingLabel.textContent = 'Belum memilih rating';
                return;
            }

            ratingLabel.textContent =
                `${selected.value} dari 5 — ${ratingText[selected.value]}`;
        }


        function updateCommentCount() {

            commentCount.textContent =
                `${comment.value.length}/2000`;

        }


        ratingInputs.forEach(function (input) {

            input.addEventListener(
                'change',
                updateRating
            );

        });


        comment.addEventListener(
            'input',
            updateCommentCount
        );


        updateRating();
        updateCommentCount();

    });
</script>


</x-layouts.client>
