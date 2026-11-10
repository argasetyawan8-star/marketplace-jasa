<x-layouts.marketplace>
    <div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">
        <div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8">
            <a href="{{ route('client.jobs.index') }}" class="inline-flex items-center gap-2 text-xs text-[#71837B] hover:text-[#0F6B3A]"><i class="bi bi-arrow-left"></i>Kembali</a>
            <div class="mt-5 rounded-2xl border border-[#E0EBE4] bg-white p-5 sm:p-7">
                <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">Job Board</p>
                <h1 class="mt-1 text-2xl font-semibold text-[#123128]">Buat Job</h1>
                <p class="mt-1 text-sm text-[#71837B]">Jelaskan kebutuhan pekerjaanmu supaya freelancer bisa mengajukan proposal.</p>

                @if($errors->any())
                    <div class="mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-xs text-red-600">
                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('client.jobs.store') }}" class="mt-6 space-y-5">
                    @csrf
                    <div>
                        <label class="text-xs font-semibold text-[#123128]">Judul pekerjaan</label>
                        <input name="title" value="{{ old('title') }}" required placeholder="Contoh: Desain logo untuk brand baru" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm outline-none focus:border-[#1E9E5A]">
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-xs font-semibold text-[#123128]">Kategori</label>
                            <select name="category_id" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] bg-white px-3 text-sm outline-none focus:border-[#1E9E5A]">
                                <option value="">Pilih kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-[#123128]">Subkategori</label>
                            <select name="subcategory_id" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] bg-white px-3 text-sm outline-none focus:border-[#1E9E5A]">
                                <option value="">Pilih subkategori</option>
                                @foreach($categories as $category)
                                    @foreach($category->subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" @selected(old('subcategory_id') == $subcategory->id)>{{ $category->name }} — {{ $subcategory->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-[#123128]">Detail pekerjaan</label>
                        <textarea name="description" rows="7" required placeholder="Jelaskan kebutuhan, target, referensi, dan hasil yang diharapkan..." class="mt-2 w-full rounded-xl border border-[#DDE7E1] px-3 py-3 text-sm leading-6 outline-none focus:border-[#1E9E5A]">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div><label class="text-xs font-semibold text-[#123128]">Budget minimum</label><input type="number" name="budget_min" value="{{ old('budget_min') }}" min="0" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm outline-none focus:border-[#1E9E5A]"></div>
                        <div><label class="text-xs font-semibold text-[#123128]">Budget maksimum</label><input type="number" name="budget_max" value="{{ old('budget_max') }}" min="0" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm outline-none focus:border-[#1E9E5A]"></div>
                        <div><label class="text-xs font-semibold text-[#123128]">Durasi (hari)</label><input type="number" name="duration_days" value="{{ old('duration_days') }}" min="1" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm outline-none focus:border-[#1E9E5A]"></div>
                        <div><label class="text-xs font-semibold text-[#123128]">Deadline</label><input type="date" name="deadline" value="{{ old('deadline') }}" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm outline-none focus:border-[#1E9E5A]"></div>
                    </div>

                    <div><label class="text-xs font-semibold text-[#123128]">Lokasi <span class="font-normal text-[#81918B]">(opsional)</span></label><input name="location" value="{{ old('location') }}" placeholder="Contoh: Remote / Yogyakarta" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm outline-none focus:border-[#1E9E5A]"></div>

                    <div class="flex flex-col gap-3 border-t border-[#EDF2EF] pt-5 sm:flex-row sm:justify-end">
                        <button name="action" value="draft" class="h-11 rounded-xl border border-[#DDE7E1] px-5 text-xs font-semibold text-[#355248] hover:bg-[#F8FCF9]">Simpan Draft</button>
                        <button name="action" value="publish" class="h-11 rounded-xl bg-[#0F6B3A] px-5 text-xs font-semibold text-white hover:bg-[#1E9E5A]">Publikasikan Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.marketplace>
