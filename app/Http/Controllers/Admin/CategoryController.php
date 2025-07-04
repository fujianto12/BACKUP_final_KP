<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(): View
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }


    public function create(): View
    {
        $divisions = Category::select('division')->distinct()->pluck('division');
        $subDivisions = Category::select('subDivision')->distinct()->pluck('subDivision');

        return view('admin.categories.create', compact('divisions', 'subDivisions'));
    }


    public function store(CategoryRequest $request): RedirectResponse
    {

        Category::create($request->validated());

        return redirect()->route('admin.categories.index')->with([
            'message' => 'Berhasil dibuat !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Category $category): View
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with([
            'message' => 'Berhasil Di Updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return back()->with([
            'message' => 'Kategori Berhasil di hapus !',
            'alert-type' => 'danger'
        ]);
    }

    public function massDestroy()
    {
        Category::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

    public function search(Request $request)
    {
        $term = $request->get('q');

        $categories = Category::where('subDivision', 'like', '%' . $term . '%')
            ->get();

        return response()->json($categories->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->subDivision,
            ];
        }));
    }
}
