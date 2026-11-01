@php($editing = isset($report))
<form class="panel" method="POST" enctype="multipart/form-data" action="{{ $editing ? route('reports.update', $report) : route('reports.store') }}">
    @csrf
    @if($editing)@method('PUT')@endif
    <label class="field">Wilayah kejadian
        <select name="area_id" id="area_id" required><option value="">Pilih area</option>@foreach($areas as $area)<option value="{{ $area->id }}" @selected(old('area_id', $report->area_id ?? '') == $area->id)>{{ $area->name }}</option>@endforeach</select>
    </label>
    <div id="area-summary" class="notice" hidden></div>
    <label class="field">Judul laporan
        <input name="title" maxlength="120" required value="{{ old('title', $report->title ?? '') }}">
    </label>
    <label class="field">Kondisi yang terlihat
        <textarea name="description" maxlength="5000" required>{{ old('description', $report->description ?? '') }}</textarea>
    </label>
    <div class="form-grid">
        <label class="field">Waktu kejadian<input type="datetime-local" name="occurred_at" required value="{{ old('occurred_at', isset($report) ? $report->occurred_at->format('Y-m-d\TH:i') : '') }}"></label>
        <label class="field">Tingkat kondisi<select name="severity" required><option value="">Pilih tingkat</option>@foreach(['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat'] as $value => $label)<option value="{{ $value }}" @selected(old('severity', $report->severity ?? '') === $value)>{{ $label }}</option>@endforeach</select></label>
        <label class="field">Latitude<input type="number" name="latitude" min="-90" max="90" step="any" required value="{{ old('latitude', $report->latitude ?? '') }}"></label>
        <label class="field">Longitude<input type="number" name="longitude" min="-180" max="180" step="any" required value="{{ old('longitude', $report->longitude ?? '') }}"></label>
    </div>
    <label class="field">Bukti pendukung (opsional, JPG/JPEG/PNG/PDF, maksimal 2 MB)
        <input type="file" name="evidence" accept=".jpg,.jpeg,.png,.pdf">
        @if($editing && $report->evidence_original_name)<span class="meta">Bukti saat ini: {{ $report->evidence_original_name }}</span>@endif
    </label>
    <div class="actions"><button class="button" type="submit">{{ $editing ? 'Simpan perubahan' : 'Kirim laporan' }}</button><a class="button secondary" href="{{ $editing ? route('reports.show', $report) : route('reports.index') }}">Batal</a></div>
</form>
