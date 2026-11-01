<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function index(): View
    {
        $areas = Area::query()->withCount('reports')->orderBy('name')->get();

        return view('areas.index', compact('areas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:areas,name'],
            'type' => ['required', 'string', 'max:40'],
        ]);

        Area::create($data + ['is_active' => true]);

        return redirect()->route('areas.index')->with('success', 'Area berhasil ditambahkan.');
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('areas', 'name')->ignore($area->id)],
            'type' => ['required', 'string', 'max:40'],
            'is_active' => ['required', 'boolean'],
        ]);

        $area->update($data);

        return redirect()->route('areas.index')->with('success', 'Area berhasil diperbarui.');
    }
}
