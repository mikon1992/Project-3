<?php

// -> app/Http/Controllers/ActivityController.php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ActivityController extends Controller
{
    public function index(): View
    {
        return view('activities.index', [
            'activities' => Activity::orderBy('activity_date')->get(),
        ]);
    }

    public function create(): View
    {
        return view('activities.create', ['activity' => new Activity()]);
    }

    public function store(ActivityRequest $request): RedirectResponse
    {
        Activity::create($request->validated());

        return redirect()->route('activities.index')->with('status', 'Aktivitas ditambahkan.');
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', ['activity' => $activity]);
    }

    public function update(ActivityRequest $request, Activity $activity): RedirectResponse
    {
        $activity->update($request->validated());

        return redirect()->route('activities.index')->with('status', 'Aktivitas diperbarui.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return redirect()->route('activities.index')->with('status', 'Aktivitas dihapus.');
    }
}
