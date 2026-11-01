<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Report;
use App\Services\ReportStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Report::class);

        $query = Report::query()->with(['area', 'reporter'])->latest();

        if (Auth::user()->isPelapor()) {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $query->when($request->filled('area_id'), fn ($builder) => $builder->where('area_id', $request->integer('area_id')))
            ->when($request->filled('status'), fn ($builder) => $builder->where('status', $request->string('status')->toString()))
            ->when($request->filled('severity'), fn ($builder) => $builder->where('severity', $request->string('severity')->toString()));

        $reports = $query->paginate(10)->withQueryString();
        $areas = Area::query()->where('is_active', true)->orderBy('name')->get();

        return view('reports.index', compact('reports', 'areas'));
    }

    public function create(): View
    {
        Gate::authorize('create', Report::class);

        $areas = Area::query()->where('is_active', true)->orderBy('name')->get();

        return view('reports.create', compact('areas'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Report::class);

        $data = $request->validate([
            'area_id' => ['required', 'integer', Rule::exists('areas', 'id')->where('is_active', true)],
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:5000'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'occurred_at' => ['required', 'date'],
            'severity' => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'evidence' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        unset($data['evidence']);

        $duplicate = Report::query()
            ->where('user_id', Auth::id())
            ->where('area_id', $data['area_id'])
            ->where('status', '!=', 'closed')
            ->whereBetween('occurred_at', [
                Carbon::parse($data['occurred_at'])->subMinutes(60),
                Carbon::parse($data['occurred_at'])->addMinutes(60),
            ])
            ->exists();

        if ($duplicate) {
            return back()->withErrors([
                'occurred_at' => 'Masih ada laporan aktif Anda di area ini dalam rentang 60 menit.',
            ])->withInput();
        }

        $report = new Report($data);
        $report->user_id = Auth::id();
        $report->status = 'submitted';

        if ($request->hasFile('evidence')) {
            $file = $request->file('evidence');
            $report->evidence_path = $file->store('evidence', 'local');
            $report->evidence_original_name = $file->getClientOriginalName();
        }

        $report->save();

        return redirect()->route('reports.show', $report)->with('success', 'Laporan berhasil dikirim.');
    }

    public function show(Report $report): View
    {
        Gate::authorize('view', $report);
        $report->load(['area', 'reporter', 'reviewer', 'forwarding.coordinator']);

        return view('reports.show', compact('report'));
    }

    public function edit(Report $report): View
    {
        Gate::authorize('update', $report);
        $areas = Area::query()->where('is_active', true)->orderBy('name')->get();

        return view('reports.edit', compact('report', 'areas'));
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        Gate::authorize('update', $report);

        $data = $request->validate([
            'area_id' => ['required', 'integer', Rule::exists('areas', 'id')->where('is_active', true)],
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:5000'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'occurred_at' => ['required', 'date'],
            'severity' => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'evidence' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        unset($data['evidence']);

        $duplicate = Report::query()
            ->where('id', '!=', $report->id)
            ->where('user_id', Auth::id())
            ->where('area_id', $data['area_id'])
            ->where('status', '!=', 'closed')
            ->whereBetween('occurred_at', [
                Carbon::parse($data['occurred_at'])->subMinutes(60),
                Carbon::parse($data['occurred_at'])->addMinutes(60),
            ])
            ->exists();

        if ($duplicate) {
            return back()->withErrors([
                'occurred_at' => 'Masih ada laporan aktif Anda di area ini dalam rentang 60 menit.',
            ])->withInput();
        }

        $report->fill($data);

        if ($request->hasFile('evidence')) {
            if ($report->evidence_path) {
                Storage::disk('local')->delete($report->evidence_path);
            }

            $file = $request->file('evidence');
            $report->evidence_path = $file->store('evidence', 'local');
            $report->evidence_original_name = $file->getClientOriginalName();
        }

        $report->save();

        return redirect()->route('reports.show', $report)->with('success', 'Perubahan laporan berhasil disimpan.');
    }

    public function destroy(Report $report): RedirectResponse
    {
        Gate::authorize('delete', $report);

        if ($report->evidence_path) {
            Storage::disk('local')->delete($report->evidence_path);
        }

        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dibatalkan.');
    }

    public function evidence(Report $report)
    {
        Gate::authorize('view', $report);
        abort_unless($report->evidence_path && Storage::disk('local')->exists($report->evidence_path), 404);

        return Storage::disk('local')->download($report->evidence_path, $report->evidence_original_name);
    }

    public function claim(Report $report): RedirectResponse
    {
        Gate::authorize('review', $report);
        abort_unless($report->status === 'submitted', 409);

        $report->reviewer_id = Auth::id();
        $report->save();
        app(ReportStatusService::class)->change($report, 'under_review');

        return back()->with('success', 'Laporan diambil untuk ditinjau.');
    }

    public function flag(Request $request, Report $report): RedirectResponse
    {
        Gate::authorize('review', $report);
        abort_unless($report->status === 'under_review' && $report->reviewer_id === Auth::id(), 403);

        $data = $request->validate([
            'review_note' => ['required', 'string', 'max:3000'],
        ]);

        $report->review_note = $data['review_note'];
        $report->reviewed_at = now();
        $report->save();
        app(ReportStatusService::class)->change($report, 'flagged');

        return back()->with('success', 'Laporan ditandai perlu diteruskan.');
    }

    public function closeReview(Request $request, Report $report): RedirectResponse
    {
        Gate::authorize('close', $report);
        abort_unless($report->reviewer_id === Auth::id(), 403);

        $data = $request->validate([
            'review_note' => ['nullable', 'string', 'max:3000'],
        ]);

        if (filled($data['review_note'] ?? null)) {
            $report->review_note = $data['review_note'];
            $report->save();
        }

        app(ReportStatusService::class)->change($report, 'closed');

        return back()->with('success', 'Proses laporan komunitas telah ditutup.');
    }
}
