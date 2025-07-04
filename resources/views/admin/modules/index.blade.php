@extends('layouts.admin')

@section('title', 'Daftar Modul')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-success">Daftar Modul Pembelajaran</h6>
                <div class="ml-auto">
                    <a href="{{ route('admin.modules.create') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Buat Baru
                    </a>
                </div>
            </div>
            <div class="card-body">

                <table id="moduleTable" class="table table-bordered table-striped table-hover w-100">
                    <thead class="thead-light text-center">
                        <tr>

                            <th style="width: 5%">No</th>
                            <th style="width: 5%">No</th>
                            <th style="width: 40%">Judul Modul</th>
                            <th style="width: 35%">Kategori</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            @foreach ($category->modules as $index => $module)
                                <tr data-category-id="{{ $category->id }}">
                                    <td class="text-center">
                                        <input type="checkbox" class="row-checkbox" value="{{ $module->id }}">
                                        {{-- 🔧 perubahan di sini --}}
                                    </td>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $module->title }}</td>
                                    <td>{{ $category->subDivision }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.modules.edit', $module->id) }}"
                                                class="btn btn-warning">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteModal{{ $module->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Konfirmasi Hapus --}}
                                <div class="modal fade" id="deleteModal{{ $module->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel{{ $module->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $module->id }}">
                                                    Konfirmasi Hapus Modul
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah kamu yakin ingin menghapus modul
                                                <strong>{{ $module->title }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.modules.destroy', $module->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

@push('script-alt')
    <script>
        $(document).ready(function() {
            $('#moduleTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Cari:",
                    paginate: {
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    },
                    lengthMenu: "Tampilkan _MENU_ entri",
                    zeroRecords: "Tidak ada modul ditemukan",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 dari 0 entri",
                }
            });
            $('#select-all').on('click', function() { // 🔧 perubahan di sini: fungsi "Pilih Semua"
            $('.row-checkbox').prop('checked', this.checked);
        });
        });
    </script>
@endpush
