<x-layouts.marketplace>
    <div class="min-h-[calc(100vh-72px)] bg-[#F8FCF9]">
        <div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8">
            <a href="{{ route('client.jobs.show', $job) }}" class="inline-flex items-center gap-2 text-xs text-[#71837B] hover:text-[#0F6B3A]"><i class="bi bi-arrow-left"></i>Kembali ke Job</a>
            <div class="mt-5 rounded-2xl border border-[#E0EBE4] bg-white p-5 sm:p-7">
                <p class="text-[10px] font-semibold uppercase tracking-[.15em] text-[#1E9E5A]">Job Board</p>
                <h1 class="mt-1 text-2xl font-semibold text-[#123128]">Edit Job</h1>

                @if($errors->any())
                    <div class="mt-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-xs text-red-600">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
                @endif

                <form method="POST" action="{{ route('client.jobs.update', $job) }}" class="mt-6 space-y-5">
                    @csrf
                    @method('PATCH')
                    <div><label class="text-xs font-semibold text-[#123128]">Judul pekerjaan</label><input name="title" value="{{ old('title',$job->title) }}" required class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm outline-none focus:border-[#1E9E5A]"></div>
                    <div class="grid gap-4 sm:grid-cols-2"><div><label class="text-xs font-semibold text-[#123128]">Kategori</label><select name="category_id" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] bg-white px-3 text-sm"> <option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$job->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></div><div><label class="text-xs font-semibold text-[#123128]">Subkategori</label><select name="subcategory_id" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] bg-white px-3 text-sm"><option value="">Pilih subkategori</option>@foreach($categories as $category)@foreach($category->subcategories as $subcategory)<option value="{{ $subcategory->id }}" @selected(old('subcategory_id',$job->subcategory_id)==$subcategory->id)>{{ $category->name }} — {{ $subcategory->name }}</option>@endforeach @endforeach</select></div></div>
                    <div><label class="text-xs font-semibold text-[#123128]">Detail pekerjaan</label><textarea name="description" rows="7" required class="mt-2 w-full rounded-xl border border-[#DDE7E1] px-3 py-3 text-sm leading-6 outline-none focus:border-[#1E9E5A]">{{ old('description',$job->description) }}</textarea></div>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4"><div><label class="text-xs font-semibold text-[#123128]">Budget minimum</label><input type="number" name="budget_min" value="{{ old('budget_min',$job->budget_min) }}" min="0" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm"></div><div><label class="text-xs font-semibold text-[#123128]">Budget maksimum</label><input type="number" name="budget_max" value="{{ old('budget_max',$job->budget_max) }}" min="0" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm"></div><div><label class="text-xs font-semibold text-[#123128]">Durasi (hari)</label><input type="number" name="duration_days" value="{{ old('duration_days',$job->duration_days) }}" min="1" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm"></div><div><label class="text-xs font-semibold text-[#123128]">Deadline</label><input type="date" name="deadline" value="{{ old('deadline',$job->deadline?->format('Y-m-d')) }}" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm"></div></div>
                    <div><label class="text-xs font-semibold text-[#123128]">Lokasi</label><input name="location" value="{{ old('location',$job->location) }}" class="mt-2 h-11 w-full rounded-xl border border-[#DDE7E1] px-3 text-sm"></div>
                    <div class="flex justify-end border-t border-[#EDF2EF] pt-5"><button class="h-11 rounded-xl bg-[#0F6B3A] px-5 text-xs font-semibold text-white hover:bg-[#1E9E5A]">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.marketplace>
