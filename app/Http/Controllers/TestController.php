<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Category;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

    // public function startQuiz(Category $category)
    // {
    //     $user = Auth::user();

    //     // Find or create the QuizAttempt record for this user and category
    //     $quizAttempt = QuizAttempt::firstOrCreate(
    //         ['user_id' => $user->id, 'category_id' => $category->id],
    //         ['attempts_left' => 3, 'last_attempt_at' => null]
    //     );

    //     // Check if the user has attempts left
    //     if ($quizAttempt->attempts_left <= 0) {
    //         // All attempts used. Check if the 3-hour reset time has passed.
    //         $resetTime = $quizAttempt->last_attempt_at->addHours(3);

    //         if (Carbon::now()->lt($resetTime)) {
    //             // Not yet 3 hours since last attempt, so still locked out
    //             $remainingTime = Carbon::now()->diffForHumans($resetTime, true, false, 2); // e.g., "1 hour 30 minutes"
    //             return redirect()->back()->with('error', "Anda telah menggunakan semua percobaan. Silakan coba lagi dalam {$remainingTime} lagi.");
    //         } else {
    //             // 3 hours have passed, reset attempts
    //             $quizAttempt->attempts_left = 3;
    //             $quizAttempt->last_attempt_at = null; // Reset last attempt time
    //             $quizAttempt->save();
    //             // Proceed to quiz (fall through to the next check)
    //         }
    //     }

    //     // Check the 1-hour cooldown for individual attempts
    //     if ($quizAttempt->last_attempt_at) {
    //         $cooldownEndTime = $quizAttempt->last_attempt_at->addHours(1);

    //         if (Carbon::now()->lt($cooldownEndTime)) {
    //             // Still within the 1-hour cooldown period
    //             $remainingTime = Carbon::now()->diffForHumans($cooldownEndTime, true, false, 2); // e.g., "30 minutes"
    //             return redirect()->back()->with('error', "Anda baru saja melakukan percobaan. Silakan tunggu {$remainingTime} sebelum mencoba lagi.");
    //         }
    //     }

    //     // If we reach here, the user can start the quiz.
    //     // Decrement attempts and update last attempt time
    //     $quizAttempt->attempts_left--;
    //     $quizAttempt->last_attempt_at = Carbon::now();
    //     $quizAttempt->save();

    //     // Redirect to the actual quiz page
    //     // Ensure your 'client.test.category' route actually leads to the quiz content.
    //     return view('client.quiz_page', compact('category', 'quizAttempt')); // Example: Pass data to a quiz view
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
