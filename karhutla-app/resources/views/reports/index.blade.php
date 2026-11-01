@extends('layouts.app')

@section('title', 'Laporan Karhutla | Rimba Siaga')

@section('content')
<div class="heading">
    <div><span class="eyebrow">PEMANTAUAN INFORMASI KOMUNITAS</span><h1>Laporan Karhutla</h1><p class="sub">Informasi masyarakat yang sedang dipantau relawan.</p></div>
    @if(auth()->user()->isPelapor())<a class="button" href="{{ route('reports.create') }}">＋ Buat laporan</a>@endif
</div>
<div class="stat-grid">
    <div class="stat"><small>Total laporan</small><strong>{{ $reports->total() }}</strong></div>
    <div class="stat"><small>Aktif di halaman ini</small><strong>{{ $reports->getCollection()->where('status', '!=', 'closed')->count() }}</strong></div>
    <div class="stat"><small>Selesai di halaman ini</small><strong>{{ $reports->getCollection()->where('status', 'closed')->count() }}</strong></div>
    <div class="stat"><small>Halaman</small><strong>{{ $reports->currentPage() }} / {{ $reports->lastPage() }}</strong></div>
</div>
<section class="panel">
    <form class="filters" method="GET" action="{{ route('reports.index') }}">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul atau deskripsi">
        <select name="area_id"><option value="">Semua area</option>@foreach($areas as $area)<option value="{{ $area->id }}" @selected(request('area_id') == $area->id)>{{ $area->name }}</option>@endforeach</select>
        <select name="status"><option value="">Semua status</option>@foreach(['submitted' => 'Laporan baru', 'under_review' => 'Sedang ditinjau', 'flagged' => 'Perlu diteruskan', 'forwarded' => 'Sudah diteruskan', 'closed' => 'Selesai'] as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select>
        <select name="severity"><option value="">Semua tingkat</option>@foreach(['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat'] as $value => $label)<option value="{{ $value }}" @selected(request('severity') === $value)>{{ $label }}</option>@endforeach</select>
        <button class="button" type="submit">Terapkan filter</button>
    </form>
    <div class="table-wrap"><table><thead><tr><th>LAPORAN</th><th>WILAYAH</th><th>TINGKAT</th><th>STATUS</th><th>WAKTU</th></tr></thead><tbody>
        @forelse($reports as $report)
            <tr><td><a href="{{ route('reports.show', $report) }}">{{ $report->title }}</a><div class="meta">RS-{{ $report->id }}@if(!auth()->user()->isPelapor()) · {{ $report->reporter->name }}@endif</div></td><td>{{ $report->area->name }}</td><td><span class="badge {{ $report->severity }}">{{ ucfirst($report->severity) }}</span></td><td>{{ ['submitted' => 'Laporan baru', 'under_review' => 'Sedang ditinjau', 'flagged' => 'Perlu diteruskan', 'forwarded' => 'Sudah diteruskan', 'closed' => 'Selesai'][$report->status] }}</td><td>{{ $report->occurred_at->format('d M Y H:i') }}</td></tr>
        @empty
            <tr><td colspan="5">Belum ada laporan yang sesuai filter.</td></tr>
        @endforelse
    </tbody></table></div>
    <div class="pagination"><span>{{ $reports->firstItem() ?? 0 }}–{{ $reports->lastItem() ?? 0 }} dari {{ $reports->total() }}</span>{{ $reports->links() }}</div>
</section>
<p class="footer-note">Informasi ini merupakan laporan masyarakat dan bukan penetapan resmi kejadian kebakaran.</p>
@endsection
