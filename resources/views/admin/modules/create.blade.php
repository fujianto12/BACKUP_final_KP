@extends('layouts.admin')

@section('title', 'Tambah Modul')

@section('content')
    <div class="container">
        <h2 class="text-success"><b>Tambah Modul untuk Satu Kategori</b></h2>
        <form action="{{ route('admin.modules.storeMultiple') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="category_name">Ketik Nama Kategori</label>
                <input type="text" id="category_name" class="form-control" placeholder="Cari kategori..." autocomplete="off"
                    required>
                <input type="hidden" name="category_id" id="category_id">
                <div id="categoryList" class="list-group mt-1" style="position: absolute; z-index: 9999;"></div>
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
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Live search kategori
            $('#category_name').on('keyup', function() {
                let query = $(this).val();

                if (query.length >= 2) {
                    $.ajax({
                        url: "{{ route('admin.categories.search') }}",
                        type: "GET",
                        data: {
                            q: query
                        },
                        success: function(data) {
                            let list = $('#categoryList');
                            list.empty();

                            if (data.length > 0) {
                                data.forEach(function(item) {
                                    list.append(
                                        `<a href="#" class="list-group-item list-group-item-action" data-id="${item.id}">${item.name}</a>`
                                    );
                                });

                                list.show();
                            } else {
                                list.html('<div class="list-group-item">Tidak ditemukan</div>')
                                    .show();
                            }
                        }
                    });
                } else {
                    $('#categoryList').hide();
                }
            });

            // Saat klik salah satu kategori
            $(document).on('click', '#categoryList a', function(e) {
                e.preventDefault();
                $('#category_name').val($(this).text());
                $('#category_id').val($(this).data('id'));
                $('#categoryList').hide();
            });

            // Tutup dropdown jika klik di luar
            $(document).click(function(e) {
                if (!$(e.target).closest('#category_name, #categoryList').length) {
                    $('#categoryList').hide();
                }
            });

            // Tambah pilihan jawaban
            $('#add-option-btn').on('click', function() {
                const wrapper = $('#options-wrapper');

                const html = `
            <div class="option-item mb-3">
                <input type="text" name="options[]" class="form-control mb-1" placeholder="Option text" required>
                <input type="number" name="points[]" class="form-control" placeholder="Points" required min="0" value="0">
                <button type="button" class="btn btn-danger btn-sm mt-1 remove-option-btn">Remove</button>
            </div>
        `;

                wrapper.append(html);
            });

            // Hapus pilihan jawaban
            $(document).on('click', '.remove-option-btn', function() {
                $(this).closest('.option-item').remove();
            });
        });
    </script>
@endpush
