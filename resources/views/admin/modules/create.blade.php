@extends('layouts.admin')

@section('title', 'Tambah Modul')

@section('content')
<div class="container">
    <a href="{{ route('admin.modules.index') }}" class="btn btn-success btn-sm shadow-sm mb-2">Kembali</a>
    <h2 class="text-success"><b>Tambah Modul untuk Satu Kategori</b></h2>

    <form action="{{ route('admin.modules.storeMultiple') }}" method="POST" id="module-form">
        @csrf

        <div class="form-group">
            <label for="category_name">Ketik Nama Kategori</label>
            <input type="text" id="category_name" class="form-control" placeholder="Cari kategori..." autocomplete="off" required>
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
                    <input type="text" name="modules[0][title]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Isi Modul</label>
                    <textarea name="modules[0][content]" class="form-control" rows="4" required></textarea>
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
    $(document).ready(function () {
        let moduleIndex = 1;

        // Live search kategori
        $('#category_name').on('keyup', function () {
            let query = $(this).val();

            if (query.length >= 2) {
                $.ajax({
                    url: "{{ route('admin.categories.search') }}",
                    type: "GET",
                    data: { q: query },
                    success: function (data) {
                        let list = $('#categoryList');
                        list.empty();

                        if (data.length > 0) {
                            data.forEach(function (item) {
                                list.append(`<a href="#" class="list-group-item list-group-item-action" data-id="${item.id}">${item.name}</a>`);
                            });
                            list.show();
                        } else {
                            list.html('<div class="list-group-item">Tidak ditemukan</div>').show();
                        }
                    }
                });
            } else {
                $('#categoryList').hide();
            }
        });

        // Saat klik kategori
        $(document).on('click', '#categoryList a', function (e) {
            e.preventDefault();
            $('#category_name').val($(this).text());
            $('#category_id').val($(this).data('id'));
            $('#categoryList').hide();
        });

        // Sembunyikan dropdown jika klik di luar
        $(document).click(function (e) {
            if (!$(e.target).closest('#category_name, #categoryList').length) {
                $('#categoryList').hide();
            }
        });

        // Tambah modul
        $('#add-module').on('click', function () {
            const html = `
                <div class="module-item mb-3 border p-3">
                    <div class="form-group">
                        <label>Judul Modul</label>
                        <input type="text" name="modules[${moduleIndex}][title]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Isi Modul</label>
                        <textarea name="modules[${moduleIndex}][content]" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="button" class="btn btn-danger btn-remove-module">Hapus</button>
                </div>
            `;
            $('#modules-wrapper').append(html);
            moduleIndex++;
        });

        // Hapus modul (minimal 1 harus tersisa)
        $(document).on('click', '.btn-remove-module', function () {
            if ($('.module-item').length > 1) {
                $(this).closest('.module-item').remove();
            } else {
                alert('Minimal satu modul harus ada.');
            }
        });

        // Validasi sebelum submit
        $('#module-form').on('submit', function (e) {
            if ($('#category_id').val() === '') {
                e.preventDefault();
                alert('Silakan pilih kategori dari daftar yang muncul.');
            }
        });
    });
</script>
@endpush
