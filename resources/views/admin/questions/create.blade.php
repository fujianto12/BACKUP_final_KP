@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="text-success"><b>Membuat Soal dan Jawaban</b></h1>
        <a href="{{ route('admin.questions.index') }}" class="btn btn-success btn-sm shadow-sm">{{ __('Kembali') }}</a>

        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="category_name" class="mt-3">Ketik Nama Kategori</label>
                <input type="text" id="category_name" class="form-control" placeholder="Cari kategori..."
                    autocomplete="off" required>
                <input type="hidden" name="category_id" id="category_id">
                <div id="categoryList" class="list-group mt-1" style="position: absolute; z-index: 9999;"></div>
                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="question_text">Buat Soal</label>
                <textarea name="question_text" id="question_text" class="form-control" required>{{ old('question_text') }}</textarea>
                @error('question_text')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <hr>

            <label>Pilihan Jawaban</label>
            <div id="options-wrapper">
                <div class="option-item mb-3">
                    <input type="text" name="options[]" class="form-control mb-1" placeholder="Pilihan Jawaban" required>
                    <input type="number" name="points[]" class="form-control" placeholder="Bobot nilai" required
                        min="0">
                </div>
            </div>

            <button type="button" id="add-option-btn" class="btn btn-secondary btn-sm mb-3">Tambah Jawaban</button>

            <br>

            <button type="submit" class="btn btn-success">Simpan Soal dan Jawaban</button>
        </form>
    </div>
@endsection
