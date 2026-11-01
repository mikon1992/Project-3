@extends('layouts.app')

@section('title', 'Rekap laporan | Rimba Siaga')

@section('content')
<div class="heading"><div><span class="eyebrow">RINGKASAN PEMANTAUAN</span><h1>Rekap laporan</h1><p class="sub">Data dihitung dari laporan yang tersimpan.</p></div></div>
<section class="panel"><form class="filters" method="GET" action="{{ route('reports.recap') }}"><select name="area_id"><option value="">Semua area</option>@foreach($filterAreas as $area)<option value="{{ $area->id }}" @selected(($filters['area_id'] ?? '') == $area->id)>{{ $area->name }}</option>@endforeach</select><select name="status"><option value="">Semua status</option>@foreach(['submitted' => 'Laporan baru', 'under_review' => 'Sedang ditinjau', 'flagged' => 'Perlu diteruskan', 'forwarded' => 'Sudah diteruskan', 'closed' => 'Selesai'] as $value => $label)<option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>@endforeach</select><button class="button" type="submit">Terapkan filter</button></form></section>
<div class="stat-grid"><div class="stat"><small>Total laporan</small><strong>{{ $summary['total'] }}</strong></div><div class="stat"><small>Laporan aktif</small><strong>{{ $summary['active'] }}</strong></div><div class="stat"><small>Selesai</small><strong>{{ $summary['closed'] }}</strong></div><div class="stat"><small>Sudah diteruskan</small><strong>{{ $summary['forwarded'] }}</strong></div></div>
<section class="panel table-wrap"><table><thead><tr><th>WILAYAH</th><th>TOTAL</th><th>BARU</th><th>DITINJAU</th><th>PERLU DITERUSKAN</th><th>DITERUSKAN</th><th>SELESAI</th></tr></thead><tbody>
    @foreach($rows as $row)
        <tr><td>{{ $row['area']->name }}</td><td>{{ $row['total'] }}</td><td>{{ $row['submitted'] }}</td><td>{{ $row['under_review'] }}</td><td>{{ $row['flagged'] }}</td><td>{{ $row['forwarded'] }}</td><td>{{ $row['closed'] }}</td></tr>
    @endforeach
</tbody></table></section>
@endsection