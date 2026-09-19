<x-layouts.admin title="Pembatalan Order">

    @php
        $statusLabels = [
            'pending_freelancer' => 'Menunggu Freelancer',
            'approved_by_freelancer' => 'Disetujui Freelancer',
            'rejected_by_freelancer' => 'Ditolak Freelancer',
            'mediation_pending' => 'Menunggu Mediasi',
            'approved_by_admin' => 'Disetujui Admin',
            'rejected_by_admin' => 'Ditolak Admin',
        ];
    @endphp

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div>

            <h1 class="text-2xl font-semibold text-[#123128]">
                Pembatalan Order
            </h1>

            <p class="mt-1 text-sm text-[#71837B]">
                Tinjau proses pembatalan dan mediasi antara client dengan freelancer.
            </p>

        </div>

        {{-- Statistics --}}
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-2xl border border-[#DDE9E2] bg-white p-5 shadow-sm">

                <p class="text-xs font-medium text-[#899991]">
                    Semua
                </p>

                <p class="mt-2 text-2xl font-semibold text-[#123128]">
                    {{ $counts['all'] }}
                </p>

            </div>

            <div class="rounded-2xl border border-[#CFE0F1] bg-[#F3F8FC] p-5">

                <p class="text-xs font-medium text-[#587593]">
                    Menunggu Mediasi
                </p>

                <p class="mt-2 text-2xl font-semibold text-[#315D87]">
                    {{ $counts['mediation_pending'] }}
                </p>

            </div>

            <div class="rounded-2xl border border-[#CDE7D7] bg-[#EAF7EF] p-5">

                <p class="text-xs font-medium text-[#587C68]">
                    Disetujui Admin
                </p>

                <p class="mt-2 text-2xl font-semibold text-[#168A4D]">
                    {{ $counts['approved_by_admin'] }}
                </p>

            </div>

            <div class="rounded-2xl border border-red-100 bg-red-50 p-5">

                <p class="text-xs font-medium text-red-500">
                    Ditolak Admin
                </p>

                <p class="mt-2 text-2xl font-semibold text-red-700">
                    {{ $counts['rejected_by_admin'] }}
                </p>

            </div>

        </div>

        {{-- Filter --}}
        <form
            method="GET"
            class="grid gap-3 rounded-2xl border border-[#DDE9E2] bg-white p-4 shadow-sm sm:grid-cols-[1fr_240px_auto]"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nomor order, nama, atau email..."
                class="h-11 rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 text-sm text-[#123128] outline-none transition placeholder:text-[#9AA8A1] focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
            >

            <select
                name="status"
                class="h-11 rounded-xl border border-[#D8E5DD] bg-[#F8FCF9] px-4 text-sm text-[#123128] outline-none transition focus:border-[#1E9E5A] focus:ring-2 focus:ring-[#EAF7EF]"
            >
                <option value="">
                    Semua status
                </option>

                @foreach($statusLabels as $value => $label)

                    <option
                        value="{{ $value }}"
                        @selected(request('status') === $value)
                    >
                        {{ $label }}
                    </option>

                @endforeach

            </select>

            <button
                type="submit"
                class="h-11 rounded-xl bg-[#0F6B3A] px-5 text-sm font-semibold text-white transition hover:bg-[#1E9E5A]"
            >
                Filter
            </button>

        </form>

        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-[#DDE9E2] bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="border-b border-[#E8EEE9] bg-[#F8FCF9]">

                        <tr>

                            <th class="px-5 py-4 text-left font-semibold text-[#52675D]">
                                Order
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-[#52675D]">
                                Pemohon
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-[#52675D]">
                                Peran
                            </th>

                            <th class="px-5 py-4 text-left font-semibold text-[#52675D]">
                                Status
                            </th>

                            <th class="px-5 py-4 text-right font-semibold text-[#52675D]">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-[#EDF2EF]">

                        @forelse($cancellations as $cancellation)

                            @php

                                $statusClass = match ($cancellation->status) {

                                    'pending_freelancer' =>
                                        'bg-[#FFF9EA] text-[#815A08]',

                                    'approved_by_freelancer' =>
                                        'bg-[#EAF7EF] text-[#168A4D]',

                                    'rejected_by_freelancer' =>
                                        'bg-red-50 text-red-700',

                                    'mediation_pending' =>
                                        'bg-[#F3F8FC] text-[#315D87]',

                                    'approved_by_admin' =>
                                        'bg-[#EAF7EF] text-[#168A4D]',

                                    'rejected_by_admin' =>
                                        'bg-red-50 text-red-700',

                                    default =>
                                        'bg-gray-50 text-gray-600',
                                };

                                $roleClass = match ($cancellation->requester_role) {

                                    'client' =>
                                        'bg-[#EEF5FF] text-[#315A91]',

                                    'freelancer' =>
                                        'bg-[#F4EEFF] text-[#7048A8]',

                                    default =>
                                        'bg-gray-50 text-gray-600',
                                };

                            @endphp

                            <tr class="transition hover:bg-[#FAFCFB]">

                                {{-- Order --}}
                                <td class="px-5 py-4 align-top">

                                    <p class="font-semibold text-[#123128]">
                                        {{ $cancellation->order?->order_number ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-xs text-[#899991]">
                                        {{ $cancellation->created_at?->format('d M Y H:i') }}
                                    </p>

                                </td>

                                {{-- Requester --}}
                                <td class="px-5 py-4 align-top">

                                    <p class="font-medium text-[#123128]">
                                        {{ $cancellation->requester?->name ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-xs text-[#899991]">
                                        {{ $cancellation->requester?->email ?? '-' }}
                                    </p>

                                </td>

                                {{-- Role --}}
                                <td class="px-5 py-4 align-top">

                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $roleClass }}">
                                        {{ ucfirst($cancellation->requester_role) }}
                                    </span>

                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4 align-top">

                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">
                                        {{ $statusLabels[$cancellation->status] ?? ucfirst(str_replace('_', ' ', $cancellation->status)) }}
                                    </span>

                                </td>

                                {{-- Action --}}
                                <td class="px-5 py-4 text-right align-top">

                                    <a
                                        href="{{ route('admin.cancellations.show', $cancellation) }}"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#0F6B3A] transition hover:text-[#1E9E5A]"
                                    >
                                        Detail
                                        <i class="bi bi-arrow-right"></i>
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-5 py-14 text-center"
                                >

                                    <div class="flex flex-col items-center">

                                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#F3F7F4] text-[#7E9187]">
                                            <i class="bi bi-inbox text-lg"></i>
                                        </div>

                                        <p class="mt-3 text-sm font-medium text-[#52675D]">
                                            Belum ada data pembatalan
                                        </p>

                                        <p class="mt-1 text-xs text-[#899991]">
                                            Data pengajuan dan mediasi akan muncul di sini.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if($cancellations->hasPages())

                <div class="border-t border-[#EDF2EF] px-5 py-4">
                    {{ $cancellations->links() }}
                </div>

            @endif

        </div>

    </div>

</x-layouts.admin>