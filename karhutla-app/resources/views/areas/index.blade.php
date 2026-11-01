@extends('layouts.app')

@section('title', 'Kelola area | Rimba Siaga')

@section('content')
<div class="heading"><div><span class="eyebrow">DATA PENDUKUNG</span><h1>Kelola area</h1><p class="sub">Area nonaktif tidak muncul pada form laporan baru.</p></div></div>
<section class="panel">
    <h2>Tambah area</h2>
    <form method="POST" action="{{ route('areas.store') }}" class="form-grid">@csrf
        <label class="field">Nama area<input name="name" maxlength="100" required value="{{ old('name') }}"></label>
        <label class="field">Jenis area<select name="type" required><option value="Kecamatan">Kecamatan</option><option value="Kawasan">Kawasan</option><option value="Desa">Desa</option></select></label>
        <div class="field"><span>&nbsp;</span><button class="button" type="submit">Tambah area</button></div>
    </form>
</section>
<section class="panel table-wrap"><table><thead><tr><th>AREA</th><th>JENIS</th><th>JUMLAH LAPORAN</th><th>STATUS</th><th>AKSI</th></tr></thead><tbody>
    @foreach($areas as $area)
        <tr><td>{{ $area->name }}</td><td>{{ $area->type }}</td><td>{{ $area->reports_count }}</td><td>{{ $area->is_active ? 'Aktif' : 'Nonaktif' }}</td><td><form method="POST" action="{{ route('areas.update', $area) }}">@csrf @method('PUT')<input type="hidden" name="name" value="{{ $area->name }}"><input type="hidden" name="type" value="{{ $area->type }}"><input type="hidden" name="is_active" value="{{ $area->is_active ? 0 : 1 }}"><button class="button secondary" type="submit">{{ $area->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button></form></td></tr>
    @endforeach
</tbody></table></section>
@endsection
