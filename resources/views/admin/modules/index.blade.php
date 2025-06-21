@extends('layouts.admin')


@section('title', 'Daftar Modul')

@section('content')
<div class="container-fluid">
    <h2>Daftar Modul</h2>
    <a href="{{ route('admin.modules.create') }}" class="btn btn-success mb-3">
        <i class="fa fa-plus"></i> Tambah Modul
    </a>

    @forelse ($categories as $category)
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h4>{{ $category->name }}</h4>
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
<script>
    $(function () {
        $('.datatable-modules').DataTable({
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
            order: [[1, 'asc']],
            pageLength: 25,
            select: true,
        });
    });
</script>
@endpush
