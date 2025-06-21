<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\QuestionRequest;
use App\Models\Category;

class QuestionController extends Controller
{

    public function index(): View
    {
        $questions = Question::all();

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.questions.create', compact('categories'));
    }

    public function store(QuestionRequest $request)
    {
        $question = Question::create([
            'question_text' => $request->question_text,
            'category_id' => $request->category_id,
        ]);

        foreach ($request->options as $key => $optionText) {
            if (!empty($optionText)) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'points' => $request->points[$key] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.questions.index')->with([
            'message' => 'Soal dan Jawaban berhasil di buat!',
            'alert-type' => 'success',
        ]);
    }

    public function show(Question $question): View
    {
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question): View
    {
        $categories = Category::all()->pluck('name', 'id');

        // Ambil semua opsi yang terkait dengan question ini (id dan option_text)
        $options = $question->options()->pluck('option_text', 'id');

        return view('admin.questions.edit', compact('question', 'categories', 'options'));
    }


    public function update(QuestionRequest $request, Question $question): RedirectResponse
    {
        // Update question
        $question->update($request->validated());

        // Ambil input option dari form
        $optionIds = $request->input('option_ids', []); // array id option lama atau kosong untuk option baru
        $optionTexts = $request->input('options', []);
        $points = $request->input('points', []);

        $existingOptionIds = $question->options()->pluck('id')->toArray();

        // Simpan id option yang masih dipakai di form
        $optionIdsFromForm = array_filter($optionIds);

        // Hapus option yang sudah tidak ada di form (opsional)
        $toDelete = array_diff($existingOptionIds, $optionIdsFromForm);
        if (!empty($toDelete)) {
            $question->options()->whereIn('id', $toDelete)->delete();
        }

        // Loop dan update atau insert option
        foreach ($optionTexts as $key => $optionText) {
            $optId = $optionIds[$key] ?? null;
            $point = $points[$key] ?? 0;

            if ($optId) {
                // Update option lama
                $question->options()->where('id', $optId)->update([
                    'option_text' => $optionText,
                    'points' => $point,
                ]);
            } else {
                // Buat option baru
                if (!empty($optionText)) {
                    $question->options()->create([
                        'option_text' => $optionText,
                        'points' => $point,
                    ]);
                }
            }
        }

        return redirect()->route('admin.questions.index')->with([
            'message' => 'Soal dan Jawaban berhasil di updated!',
            'alert-type' => 'success',
        ]);
    }


    public function destroy(Question $question): RedirectResponse
    {
        // Hapus opsi-opsi terkait
        $question->options()->delete();

        // Hapus soal
        $question->delete();

        return back()->with([
            'message' => 'Soal dan Jawaban berhasil di hapus!',
            'alert-type' => 'danger'
        ]);
    }

    public function massDestroy()
    {
        Question::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

    public function detailSoal()
    {
        $questions = Question::with('options')->get();  // Ambil data questions dengan opsi terkait
        return view('admin.questions.detailsoal.index', compact('questions'));
    }


    public function detailSoalById($id)
    {
        $question = Question::with('options')->findOrFail($id);
        return view('admin.questions.detailsoal.index', compact('question'));
    }
}
