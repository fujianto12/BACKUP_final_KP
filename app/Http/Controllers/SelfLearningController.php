<?php

namespace App\Http\Controllers;

use App\Models\Category;  // pastikan model Category ada
use Illuminate\View\View;

class SelfLearningController extends Controller
{
    public function index(): View
    {
        // Ambil semua data kategori dari database
        $categories = Category::with('modules')->get();

        // Kirim data ke view 'selflearning.index' dengan variabel $categories
        return view('client.selflearning', compact('categories'));
    }
}
