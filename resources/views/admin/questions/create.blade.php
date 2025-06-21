    @extends('layouts.admin')

    @section('content')
    <div class="container-fluid">
        <h1>Create Question</h1>

        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="category_id">Kategori Alat Berat</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $id => $name)
                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('category_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="question_text">Buat Soal</label>
                <textarea name="question_text" id="question_text" class="form-control" required>{{ old('question_text') }}</textarea>
                @error('question_text')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <hr>

            <label>Pilihan Jawaban</label>
            <div id="options-wrapper">
                <div class="option-item mb-3">
                    <input type="text" name="options[]" class="form-control mb-1" placeholder="Pilihan Jawaban" required>
                    <input type="number" name="points[]" class="form-control" placeholder="Bobot nilai" required min="bobot nilai">
                </div>
            </div>

            <button type="button" id="add-option-btn" class="btn btn-secondary btn-sm mb-3">Tambah Jawaban</button>

            <br>

            <button type="submit" class="btn btn-success">Simpan Soal dan Jawaban</button>
        </form>
    </div>

    <script>
        document.getElementById('add-option-btn').addEventListener('click', function() {
            const wrapper = document.getElementById('options-wrapper');

            const div = document.createElement('div');
            div.classList.add('option-item', 'mb-3');
            div.innerHTML = `
                <input type="text" name="options[]" class="form-control mb-1" placeholder="Option text" required>
                <input type="number" name="points[]" class="form-control" placeholder="Points" required min="0" value="0">
                <button type="button" class="btn btn-danger btn-sm mt-1 remove-option-btn">Remove</button>
            `;

            wrapper.appendChild(div);

            div.querySelector('.remove-option-btn').addEventListener('click', function() {
                div.remove();
            });
        });

    </script>
    @endsection
