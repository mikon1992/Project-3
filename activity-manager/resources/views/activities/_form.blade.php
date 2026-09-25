<div>
    <label>Judul</label>
    <input type="text" name="title" value="{{ old('title', $activity->title ?? '') }}">
    @error('title') <p style="color:red;">{{ $message }}</p> @enderror
</div>

<div>
    <label>Deskripsi</label>
    <textarea name="description">{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description') <p style="color:red;">{{ $message }}</p> @enderror
</div>

<div>
    <label>Tanggal</label>
    <input type="date" name="activity_date" value="{{ old('activity_date', isset($activity) ? $activity->activity_date->format('Y-m-d') : '') }}">
    @error('activity_date') <p style="color:red;">{{ $message }}</p> @enderror
</div>

<div>
    <label>Kategori</label>
    <input type="text" name="category" value="{{ old('category', $activity->category ?? '') }}">
    @error('category') <p style="color:red;">{{ $message }}</p> @enderror
</div>

<div>
    <label>Status</label>
    <select name="status">
        @foreach (['Planned', 'Ongoing', 'Done'] as $status)
            <option value="{{ $status }}" @selected(old('status', $activity->status ?? 'Planned') === $status)>
                {{ $status }}
            </option>
        @endforeach
    </select>
    @error('status') <p style="color:red;">{{ $message }}</p> @enderror
</div>

<button type="submit">Simpan</button>