<?php

namespace App\Http\Controllers\Admin;

use App\Models\Module;
use App\Models\Category;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index()
    {
        $categories = Category::with('modules')->get(); // ambil kategori beserta modulnya
        return view('admin.modules.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.modules.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Module::create($validated);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil ditambahkan');
    }

    public function edit(Module $module)
    {
        $categories = Category::all();
        return view('admin.modules.edit', compact('module', 'categories'));
    }

    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $module->update($validated);

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diperbarui');
    }

    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dihapus');
    }

    public function massDestroy(Request $request)
    {
        Module::whereIn('id', $request->ids)->delete();
        return response()->noContent();
    }
    // public function show($id)
    // {
    //     $module = Module::findOrFail($id);
    //     return view('client.showModul', compact('module'));
    // }

     // Contoh method yang menampilkan modul
    public function show(Module $module) // Atau nama method lain yang Anda gunakan
    {
        $user = Auth::user(); // Dapatkan user yang sedang login

        // Dapatkan atau buat record QuizAttempt untuk user dan kategori ini
        // Menggunakan firstOrCreate untuk memastikan record selalu ada
        $quizAttempt = QuizAttempt::firstOrCreate(
            ['user_id' => $user->id, 'category_id' => $module->category->id],
            ['attempts_left' => 3, 'last_attempt_at' => null] // Default jika baru dibuat
        );

        // Jangan lupa untuk melewatkan $quizAttempt ke view
        return view('showmodul', compact('module', 'quizAttempt'));
    }
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.content' => 'required|string',
        ]);

        $categoryId = $request->input('category_id');
        $modulesData = $request->input('modules');

        foreach ($modulesData as $moduleData) {
            Module::create([
                'category_id' => $categoryId,
                'title' => $moduleData['title'],
                'content' => $moduleData['content'],
            ]);
        }

        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil ditambahkan.');
    }

    public function showModule($id)
    {
        $module = Module::with('category.modules')->findOrFail($id);

        $category = $module->category;

        $firstCategories = Category::first(); // contoh ambil kategori pertama, sesuaikan logika Anda

        return view('client.showModul', compact('module', 'category', 'firstCategories'));
    }
}
