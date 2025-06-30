@extends('layouts.admin')

@section('title', 'Daftar Modul')

@section('content')
    <div class="container-fluid">
        <h2 class="text-success"><b>Buat Modul Pembelajaran</b></h2>
        <a href="{{ route('admin.modules.create') }}" class="btn btn-success mb-3">
            <i class="fa fa-plus"></i> Tambah Modul
        </a>

        {{-- Filter Kategori --}}
        <div class="mb-4">
            <h6 class="font-weight-bold text-primary mb-2">Filter Kategori:</h6>
            <button class="btn btn-outline-primary btn-sm category-filter-btn active" data-category-id="">Semua Kategori</button>
            @foreach($categories as $category)
                <button class="btn btn-outline-primary btn-sm category-filter-btn" data-category-id="{{ $category->id }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
        {{-- End Filter --}}

        @forelse ($categories as $category)
            <div class="card mb-4 category-card" data-category-id="{{ $category->id }}">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">{{ $category->name }}</h4>
                </div>
                <div class="card-body p-0">
                    @if ($category->modules->count() > 0)
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Modul</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category->modules as $index => $module)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $module->title }}</td>
                                        <td>
                                            <a href="{{ route('admin.modules.edit', $module->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus modul ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="p-3">Belum ada modul untuk kategori ini.</p>
                    @endif
                </div>
            </div>
        @empty
            <p>Data kategori masih kosong.</p>
        @endforelse
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Filter berdasarkan kategori
        $('.category-filter-btn').on('click', function () {
            let selectedId = $(this).data('category-id');

            // Highlight tombol aktif
            $('.category-filter-btn').removeClass('active');
            $(this).addClass('active');

            // Tampilkan semua jika kategori kosong (Semua Kategori)
            if (selectedId === "") {
                $('.category-card').show();
            } else {
                $('.category-card').each(function () {
                    let cardCategoryId = $(this).data('category-id');
                    if (cardCategoryId == selectedId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
    });
</script>
@endpush
