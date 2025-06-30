@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-success font-weight-bold">Daftar Pengguna</h1>
        <div class="row">
            <div class="col-lg-12">

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-success ">Semua Pengguna</h6>
                        <a href="{{ route('admin.profile.create') }}" class="btn btn-success font-weight-bold">
                            <i class="fas fa-plus"></i> Tambah Pengguna Baru
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y H:i') }}
                                            </td>
                                            <td>
                                                <!-- Form untuk menghapus -->
                                                <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('admin.profile.destroy', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <!-- Tombol pemicu modal -->
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus pengguna <strong id="userNameToDelete"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let userIdToDelete;

            // Ketika tombol hapus di-klik, tampilkan modal dan simpan ID pengguna
            $('.delete-btn').on('click', function() {
                userIdToDelete = $(this).data('user-id');
                const userName = $(this).data('user-name');

                // Menampilkan nama pengguna di modal
                $('#userNameToDelete').text(userName);

                // Menampilkan modal
                $('#deleteConfirmationModal').modal('show');
            });

            // Ketika tombol konfirmasi di modal di-klik, submit form yang sesuai
            $('#confirmDeleteButton').on('click', function() {
                // Temukan form yang sesuai dengan ID pengguna dan submit
                $('#delete-form-' + userIdToDelete).submit();
            });
        });
    </script>
@endpush
