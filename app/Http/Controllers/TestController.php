<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestRequest;

class TestController extends Controller
{
    //  public function index()
    // {
    //     return view('client.test'); // Assuming you have a client/test.blade.php view
    // }

    // public function index()
    // {
    //     $categories = Category::with(['categoryQuestions.questionOptions'])->get();

    //     return view('client.test', compact('categories'));
    // }


     public function showByCategory(Category $category)
    {
        // Load questions dan options dalam 1 query
        $category->load('questions.options');

        // Kirim data kategori sebagai koleksi supaya view looping categories tetap konsisten
        return view('client.test', [
            'categories' => collect([$category])
        ]);
    }

    // Proses simpan jawaban
    // public function storeAnswers(Request $request, Category $category)
    // {
    //     $data = $request->validate([
    //         'questions' => 'required|array',
    //         'questions.*' => 'required|integer',
    //     ]);

    //     // Contoh logika simpan jawaban, bisa disesuaikan:
    //     // Simpan ke tabel jawaban user, hitung skor, dsb.

    //     // Redirect kembali ke halaman kuis dengan pesan sukses
    //     return redirect()->route('client.test.category', $category->id)
    //                      ->with('success', 'Jawaban berhasil dikirim!');
    // }

     public function storeAnswers(StoreTestRequest $request)
    {
        $options = Option::find(array_values($request->input('questions')));

        $result = auth()->user()->userResults()->create([
            'total_points' => $options->sum('points')
        ]);

        $questions = $options->mapWithKeys(function ($option) {
            return [$option->question_id => [
                        'option_id' => $option->id,
                        'points' => $option->points
                    ]
                ];
            })->toArray();

        $result->questions()->sync($questions);

        return redirect()->route('client.results.show', $result->id);
    }
}
