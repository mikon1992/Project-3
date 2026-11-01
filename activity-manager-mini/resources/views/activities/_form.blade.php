{{-- -> resources/views/activities/_form.blade.php  (kolom-kolom form, dipakai create dan edit) --}}
<p>
    <label>Judul<br>
        <input type="text" name="title" value="{{ old('title', $activity->title) }}" required>
    </label>
</p>
<p>
    <label>Deskripsi<br>
        <textarea name="description" rows="3">{{ old('description', $activity->description) }}</textarea>
    </label>
</p>
<p>
    <label>Tanggal<br>
        <input type="date" name="activity_date"
               value="{{ old('activity_date', $activity->activity_date?->format('Y-m-d')) }}" required>
    </label>
</p>
<p>
    <label>Kategori<br>
        <select name="category" required>
            @foreach (['Workshop', 'Seminar', 'Meeting', 'Tugas', 'Presentasi'] as $c)
                <option value="{{ $c }}" @selected(old('category', $activity->category) === $c)>{{ $c }}</option>
            @endforeach
        </select>
    </label>
</p>
<p>
    <label>Status<br>
        <select name="status" required>
            @foreach (['Planned', 'Ongoing', 'Done'] as $s)
                <option value="{{ $s }}" @selected(old('status', $activity->status ?? 'Planned') === $s)>{{ $s }}</option>
            @endforeach
        </select>
    </label>
</p>
