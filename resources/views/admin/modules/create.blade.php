@extends('layouts.admin')

@section('title', 'Tambah Modul')

@section('content')
    <div class="container">
        <h2>Tambah Modul untuk Satu Kategori</h2>
        <form action="{{ route('admin.modules.storeMultiple') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="category_id">Pilih Kategori</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <hr>

            <div id="modules-wrapper">
                <div class="module-item mb-3 border p-3">
                    <div class="form-group">
                        <label>Judul Modul</label>
                        <input type="text" name="modules[0][title]" class="form-control" required
                            value="{{ old('modules.0.title') }}">
                    </div>
                    <div class="form-group">
                        <label>Isi Modul</label>
                        <textarea name="modules[0][content]" class="form-control" rows="4" required>{{ old('modules.0.content') }}</textarea>
                    </div>
                    <button type="button" class="btn btn-danger btn-remove-module">Hapus</button>
                </div>
            </div>

            <button type="button" id="add-module" class="btn btn-primary mb-3">Tambah Modul</button>

            <br>

            <button type="submit" class="btn btn-success">Simpan Semua Modul</button>
            <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    @push('scripts')
        <script>
            let moduleIndex = 1;

            document.getElementById('add-module').addEventListener('click', function() {
                const wrapper = document.getElementById('modules-wrapper');

                const newModule = document.createElement('div');
                newModule.classList.add('module-item', 'mb-3', 'border', 'p-3');
                newModule.innerHTML = `
            <div class="form-group">
                <label>Judul Modul</label>
                <input type="text" name="modules[${moduleIndex}][title]" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Isi Modul</label>
                <textarea name="modules[${moduleIndex}][content]" class="form-control" rows="4" required></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-remove-module">Hapus</button>
        `;
                wrapper.appendChild(newModule);

                moduleIndex++;
            });

            document.getElementById('modules-wrapper').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('btn-remove-module')) {
                    e.target.closest('.module-item').remove();
                }
            });
        </script>
    @endpush
@endsection

