<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function __construct(private ActivityService $activityService)
    {
    }

    public function index(Request $request): View
    {
        $activities = Activity::query()
            ->with('category')
            ->search($request->string('search')->toString())
            ->byCategory($request->input('category_id'))
            ->byStatus($request->input('status'))
            ->sortByStartAt($request->input('sort', 'latest'))
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('activities.index', compact('activities', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('activities.create', compact('categories'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $this->activityService->create(
            $request->safe()->except('poster'),
            $request->file('poster')
        );

        return to_route('activities.index')
            ->with('success', 'Activity berhasil dibuat sebagai draft.');
    }

    public function show(Activity $activity): View
    {
        $activity->load(['category', 'registrations' => fn ($query) => $query->latest()]);

        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        $categories = Category::orderBy('name')->get();

        return view('activities.edit', compact('activity', 'categories'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {
        $this->activityService->update(
            $activity,
            $request->safe()->except('poster'),
            $request->file('poster')
        );

        return to_route('activities.show', $activity)
            ->with('success', 'Activity berhasil diperbarui.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $this->activityService->delete($activity);

        return to_route('activities.index')
            ->with('success', 'Activity dipindahkan ke trash.');
    }

    public function publish(Activity $activity): RedirectResponse
    {
        $this->activityService->publish($activity);

        return back()->with('success', 'Activity berhasil dipublikasikan.');
    }

    public function complete(Activity $activity): RedirectResponse
    {
        $this->activityService->complete($activity);

        return back()->with('success', 'Activity ditandai completed.');
    }

    public function trash(): View
    {
        $activities = Activity::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(10);

        return view('activities.trash', compact('activities'));
    }

    public function restore(int $activity): RedirectResponse
    {
        $this->activityService->restore($activity);

        return to_route('activities.trash')
            ->with('success', 'Activity berhasil direstore.');
    }
}
