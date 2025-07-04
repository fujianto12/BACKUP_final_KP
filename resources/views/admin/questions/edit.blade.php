@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Soal dan Jawaban') }}</h1>
                <a href="{{ route('admin.questions.index') }}"
                    class="btn btn-success btn-sm shadow-sm">{{ __('Kembali') }}</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Category Dropdown -->
                    <div class="form-group">
                        <label for="category_name">Ubah Kategori Sub Devisi</label>
                        <input type="text" id="category_name" class="form-control" placeholder="Cari kategori..."
                            value="{{ old('category_name', isset($currentCategory) ? $currentCategory->subDivision : '') }}"
                            autocomplete="off" required>
                        <input type="hidden" name="category_id" id="category_id"
                            value="{{ old('category_id', isset($currentCategory) ? $currentCategory->id : '') }}">
                        <div id="categoryList" class="list-group mt-1" style="position: absolute; z-index: 9999;"></div>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Question Text -->
                    <div class="form-group">
                        <label for="question_text">{{ __('Edit Soal Text') }}</label>
                        <input type="text" class="form-control" id="question_text" name="question_text"
                            value="{{ old('question_text', $question->question_text) }}" required>
                    </div>

                    <!-- Options Editable List -->
                    <div class="form-group">
                        <label>{{ __('Edit Jawaban') }}</label>
                        <div id="options-wrapper">
                            @foreach ($question->options as $index => $option)
                                <div class="input-group mb-2 option-item">
                                    <input type="hidden" name="option_ids[]" value="{{ $option->id }}">
                                    <input type="text" class="form-control" name="options[]"
                                        value="{{ old('options.' . $index, $option->option_text) }}"
                                        placeholder="Option Text" required>
                                    <input type="number" class="form-control" style="max-width: 100px;" name="points[]"
                                        value="{{ old('points.' . $index, $option->points) }}" placeholder="Points"
                                        required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger btn-remove-option">&times;</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="btn-add-option" class="btn btn-success btn-sm mt-2">
                            + Tambah Jawaban
                        </button>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">{{ __('Save') }}</button>
                </form>
            </div>
        </div>

    </div>

    <!-- Optional JavaScript for dynamic add/remove options -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const optionsWrapper = document.getElementById('options-wrapper');
            const btnAddOption = document.getElementById('btn-add-option');

            btnAddOption.addEventListener('click', function() {
                const index = optionsWrapper.querySelectorAll('.option-item').length;
                const optionHtml = `
                <div class="input-group mb-2 option-item">
                    <input type="hidden" name="option_ids[]" value="">
                    <input type="text" class="form-control" name="options[]" placeholder="Option Text" required>
                    <input type="number" class="form-control" style="max-width: 100px;" name="points[]" placeholder="Points" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger btn-remove-option">&times;</button>
                    </div>
                </div>
            `;
                optionsWrapper.insertAdjacentHTML('beforeend', optionHtml);
            });

            optionsWrapper.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-option')) {
                    const optionItem = e.target.closest('.option-item');
                    if (optionItem) optionItem.remove();
                }
            });
        });
    </script>

@endsection
