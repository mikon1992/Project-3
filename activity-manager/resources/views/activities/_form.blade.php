@csrf

<div class="grid">
    <div>
        <label for="category_id">Kategori</label>
        <select id="category_id" name="category_id" required>
            <option value="">Pilih kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $activity->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="code">Kode</label>
        <input id="code" name="code" value="{{ old('code', $activity->code ?? '') }}" maxlength="30" required>
    </div>
    <div>
        <label for="title">Judul</label>
        <input id="title" name="title" value="{{ old('title', $activity->title ?? '') }}" maxlength="150" required>
    </div>
    <div>
        <label for="location">Lokasi</label>
        <input id="location" name="location" value="{{ old('location', $activity->location ?? '') }}" maxlength="200" required>
    </div>
    <div>
        <label for="start_at">Mulai</label>
        <input id="start_at" type="datetime-local" name="start_at" value="{{ old('start_at', isset($activity) && $activity->start_at ? $activity->start_at->format('Y-m-d\TH:i') : '') }}" required>
    </div>
    <div>
        <label for="end_at">Selesai</label>
        <input id="end_at" type="datetime-local" name="end_at" value="{{ old('end_at', isset($activity) && $activity->end_at ? $activity->end_at->format('Y-m-d\TH:i') : '') }}" required>
    </div>
    <div>
        <label for="capacity">Kapasitas</label>
        <input id="capacity" type="number" name="capacity" min="1" max="500" value="{{ old('capacity', $activity->capacity ?? 1) }}" required>
    </div>
    <div>
        <label for="poster">Poster (opsional, max 2 MB)</label>
        <input id="poster" type="file" name="poster" accept="image/*">
    </div>
</div>

<div>
    <label for="description">Deskripsi</label>
    <textarea id="description" name="description" rows="6">{{ old('description', $activity->description ?? '') }}</textarea>
</div>

<div class="row" style="margin-top:12px">
    <button type="submit">{{ $submitLabel ?? 'Simpan' }}</button>
    <a class="btn btn-light" href="{{ route('activities.index') }}">Batal</a>
</div>
