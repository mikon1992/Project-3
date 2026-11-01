@extends('layouts.app')

@section('title', 'Detail laporan | Rimba Siaga')

@section('content')
<div class="heading"><div><span class="eyebrow">LAPORAN RS-{{ $report->id }}</span><h1>{{ $report->title }}</h1><p class="sub">{{ $report->area->name }} · {{ $report->occurred_at->format('d M Y H:i') }}</p></div><a class="button secondary" href="{{ route('reports.index') }}">Kembali</a></div>
<section class="panel">
    <div class="detail-grid">
        <div class="detail-item"><small>Status</small><strong>{{ ['submitted' => 'Laporan baru', 'under_review' => 'Sedang ditinjau', 'flagged' => 'Perlu diteruskan', 'forwarded' => 'Sudah diteruskan', 'closed' => 'Selesai'][$report->status] }}</strong></div>
        <div class="detail-item"><small>Tingkat kondisi</small><strong>{{ ucfirst($report->severity) }}</strong></div>
        <div class="detail-item"><small>Pelapor</small><strong>{{ auth()->user()->isPelapor() ? 'Anda' : $report->reporter->name }}</strong></div>
        <div class="detail-item"><small>Koordinat</small><strong>{{ $report->latitude }}, {{ $report->longitude }}</strong></div>
        <div class="detail-item"><small>Waktu kejadian</small><strong>{{ $report->occurred_at->format('d M Y H:i') }}</strong></div>
        <div class="detail-item"><small>Relawan peninjau</small><strong>{{ $report->reviewer?->name ?? 'Belum ditinjau' }}</strong></div>
    </div>
    <h3>Kondisi yang dilihat</h3>
    <p>{{ $report->description }}</p>
    @if($report->review_note)<div class="notice"><strong>Catatan peninjauan</strong><br>{{ $report->review_note }}@if($report->reviewed_at)<div class="meta">{{ $report->reviewed_at->format('d M Y H:i') }}</div>@endif</div>@endif
    @if($report->forwarding)<div class="notice"><strong>Informasi diteruskan kepada:</strong> {{ $report->forwarding->forwarded_to }}@if($report->forwarding->note)<br>{{ $report->forwarding->note }}@endif<div class="meta">{{ $report->forwarding->forwarded_at->format('d M Y H:i') }}</div></div>@endif
    @if($report->evidence_path)<a class="button secondary" href="{{ route('reports.evidence', $report) }}">Lihat bukti: {{ $report->evidence_original_name }}</a>@endif
    <div class="actions">
        @if(auth()->user()->isPelapor() && $report->status === 'submitted')
            <a class="button secondary" href="{{ route('reports.edit', $report) }}">Ubah laporan</a>
            <form method="POST" action="{{ route('reports.destroy', $report) }}">@csrf @method('DELETE')<button class="button danger" type="submit">Batalkan laporan</button></form>
        @endif
        @if(auth()->user()->isRelawan() && $report->status === 'submitted')
            <form method="POST" action="{{ route('reports.claim', $report) }}">@csrf<button class="button" type="submit">Ambil untuk ditinjau</button></form>
        @endif
        @if(auth()->user()->isRelawan() && $report->status === 'under_review' && $report->reviewer_id === auth()->id())
            <form method="POST" action="{{ route('reports.flag', $report) }}">@csrf<label class="field">Catatan peninjauan<textarea name="review_note" required maxlength="3000">{{ old('review_note', $report->review_note) }}</textarea></label><button class="button" type="submit">Tandai perlu diteruskan</button></form>
            <form method="POST" action="{{ route('reports.close-review', $report) }}">@csrf<label class="field">Catatan penutupan opsional<textarea name="review_note" maxlength="3000"></textarea></label><button class="button secondary" type="submit">Tutup proses komunitas</button></form>
        @endif
        @if(auth()->user()->isKoordinator() && $report->status === 'flagged')
            <form method="POST" action="{{ route('forwardings.store', $report) }}">@csrf<label class="field">Diteruskan kepada<input name="forwarded_to" maxlength="120" required></label><label class="field">Catatan opsional<textarea name="note" maxlength="3000"></textarea></label><button class="button" type="submit">Catat penerusan</button></form>
        @endif
        @if(auth()->user()->isKoordinator() && $report->status === 'forwarded')
            <form method="POST" action="{{ route('reports.close-forwarded', $report) }}">@csrf<button class="button" type="submit">Tutup proses komunitas</button></form>
        @endif
    </div>
</section>
<p class="footer-note">Peninjauan ini merupakan proses komunitas, bukan verifikasi resmi kejadian atau pernyataan api telah padam.</p>
@endsection
