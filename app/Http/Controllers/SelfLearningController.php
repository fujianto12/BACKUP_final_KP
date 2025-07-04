<?php

namespace App\Http\Controllers;

use App\Models\Category;  // pastikan model Category ada

class SelfLearningController extends Controller
{

    public function index()
    {
        $categories = \App\Models\Category::select('division')->distinct()->get();

        return view('client.selflearning', compact('categories'));
    }

     public function showSubdivisions($division)
    {
        $subdivisions = Category::where('division', $division)
            ->select('subDivision')
            ->distinct()
            ->get();

        return view('client.subdivisions', compact('subdivisions', 'division'));
    }
}
