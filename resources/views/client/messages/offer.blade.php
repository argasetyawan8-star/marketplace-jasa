<div class="border border-green-200 bg-green-50 rounded-2xl p-5">

    <div class="flex items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-green-700 mb-2">
                <i class="bi bi-file-earmark-text"></i>
                <span class="text-sm font-medium">
                    Penawaran
                </span>
            </div>

            <h3 class="text-lg font-semibold text-gray-900">
                {{ $offer->title }}
            </h3>
        </div>

        <span class="text-sm font-medium px-3 py-1 rounded-full
            @if($offer->status === 'sent')
                bg-white text-green-700 border border-green-200
            @elseif($offer->status === 'accepted')
                bg-green-600 text-white
            @elseif($offer->status === 'rejected')
                bg-red-100 text-red-700
            @else
                bg-gray-100 text-gray-600
            @endif
        ">
            {{ ucfirst($offer->status) }}
        </span>
    </div>

    @if ($offer->description)
        <p class="mt-4 text-sm leading-6 text-gray-600 whitespace-pre-line">
            {{ $offer->description }}
        </p>
    @endif

    <div class="mt-5 grid grid-cols-2 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-xl p-4 border border-green-100">
            <p class="text-xs text-gray-500">Harga</p>
            <p class="mt-1 text-lg font-semibold text-gray-900">
                Rp {{ number_format($offer->price, 0, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded-xl p-4 border border-green-100">
            <p class="text-xs text-gray-500">Pengerjaan</p>
            <p class="mt-1 text-lg font-semibold text-gray-900">
                {{ $offer->delivery_days }} hari
            </p>
        </div>

        <div class="bg-white rounded-xl p-4 border border-green-100 col-span-2 md:col-span-1">
            <p class="text-xs text-gray-500">Revisi</p>
            <p class="mt-1 text-lg font-semibold text-gray-900">
                {{ $offer->revision_count }} kali
            </p>
        </div>

    </div>

    @if ($offer->status === 'sent')
        <div class="mt-5 flex flex-col sm:flex-row gap-3">

            <form
                action="{{ route('client.offers.accept', $offer) }}"
                method="POST"
                class="flex-1"
            >
                @csrf

                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-green-500 hover:bg-green-600 text-white text-sm font-medium transition"
                >
                    <i class="bi bi-check-circle"></i>
                    Terima Penawaran
                </button>
            </form>

            <form
                action="{{ route('client.offers.reject', $offer) }}"
                method="POST"
                class="flex-1"
            >
                @csrf

                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 text-sm font-medium transition"
                >
                    <i class="bi bi-x-circle"></i>
                    Tolak
                </button>
            </form>

        </div>
    @elseif ($offer->accepted_at)
        <div class="mt-4 text-sm text-green-700">
            Penawaran diterima pada
            {{ $offer->accepted_at->format('d M Y H:i') }}.
        </div>
    @elseif ($offer->rejected_at)
        <div class="mt-4 text-sm text-red-600">
            Penawaran ditolak pada
            {{ $offer->rejected_at->format('d M Y H:i') }}.
        </div>
    @endif

</div>