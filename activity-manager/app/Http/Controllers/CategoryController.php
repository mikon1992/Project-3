<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('activities')
            ->orderBy('name')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', 'unique:categories,slug'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        Category::create($data);

        return to_route('categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', 'unique:categories,slug,' . $category->id],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $category->update($data);

        return to_route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->activities()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh Activity.');
        }

        try {
            $category->delete();
        } catch (QueryException $e) {
            // FK restrict tetap menjadi pertahanan jika ada perubahan data bersamaan.
            return back()->with('error', 'Kategori gagal dihapus karena masih direferensikan oleh Activity.');
        }

        return to_route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
