@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-success">
                    {{ __('Buat Soal dan Jawaban') }}
                </h6>
                <div class="ml-auto">
                    <a href="{{ route('admin.questions.create') }}" class="btn btn-success">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">{{ __('Buat baru') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- Pesan Sukses (Alert) --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Filter Kategori --}}
                <div class="mb-4">
                    <h6 class="font-weight-bold text-primary mb-2">Filter Kategori:</h6>
                    <button class="btn btn-outline-primary btn-sm category-filter-btn" data-category-id="">All
                        Categories</button>
                    @foreach ($categories as $category)
                        <button class="btn btn-outline-primary btn-sm category-filter-btn"
                            data-category-id="{{ $category->id }}">{{ $category->subDivision }}</button>
                    @endforeach
                </div>
                {{-- End Category Filters --}}

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-question"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10"></th>
                                <th>No</th>
                                <th>Category</th>
                                <th>Question Text</th>
                                <th></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($questions as $question)
                                <tr data-entry-id="{{ $question->id }}">
                                    <td></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $question->category->subDivision ?? 'N/A' }}</td>
                                    <td>{{ $question->question_text }}</td>
                                    <td>
                                        <a href="{{ route('admin.detailsoal.index', $question->id) }}"
                                            class="btn btn-success">Lihat Detail Soal</a>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.questions.edit', $question->id) }}"
                                                class="btn btn-warning">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>

                                            {{-- Tombol Hapus yang mengaktifkan Modal --}}
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteModal{{ $question->id }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Konfirmasi Hapus --}}
                                <div class="modal fade" id="deleteModal{{ $question->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Soal</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Tutup">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah kamu yakin ingin menghapus soal ini?
                                            </div>
                                            <div class="modal-footer">
                                                <!-- Form Penghapusan -->
                                                <form action="{{ route('admin.questions.destroy', $question->id) }}"
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
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('Data Empty') }}</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-alt')
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let deleteButton = {
                text: '<i class="fa fa-trash"></i> <span class="ml-1">Hapus</span>',
                url: "{{ route('admin.questions.mass_destroy') }}",
                className: 'btn-danger',
                action: function(e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).nodes(), function(entry) {
                        return $(entry).data('entry-id');
                    });
                    if (ids.length === 0) {
                        alert('No rows selected.');
                        return;
                    }
                    if (confirm('Are you sure you want to delete these items?')) {
                        $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                method: 'POST',
                                url: config.url,
                                data: {
                                    ids: ids,
                                    _method: 'DELETE'
                                }
                            })
                            .done(function() {
                                location.reload();
                            });
                    }
                }
            }
            dtButtons.push(deleteButton);

            let table = $('.datatable-question:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                order: [
                    [1, 'asc']
                ],
                pageLength: 50,
                destroy: true
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            // Category filter logic
            $('.category-filter-btn').on('click', function() {
                const categoryId = $(this).data('category-id');
                filterQuestions(categoryId);
            });

            function filterQuestions(categoryId) {
                let url = "{{ route('admin.questions.index') }}";
                if (categoryId) {
                    url += `?category_id=${categoryId}`;
                }

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        table.clear().draw();

                        if (data.length > 0) {
                            data.forEach(function(question, index) {
                                const categoryName = question.category?.subDivision ?? 'N/A';

                                table.row.add([
                                    '',
                                    index + 1,
                                    categoryName,
                                    question.question_text,
                                    `<a href="/admin/detailsoal/${question.id}" class="btn btn-success">Lihat Detail Soal</a>`,
                                    `<div class="btn-group btn-group-sm">
                            <a href="/admin/questions/${question.id}/edit" class="btn btn-warning">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal${question.id}">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>`
                                ]).draw(false);
                            });
                        } else {
                            table.row.add([
                                '', '', '', '', '',
                                `<td colspan="6" class="text-center">Data Empty</td>`
                            ]).draw(false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching filtered questions:", error);
                        alert("Gagal memuat data. Silakan coba lagi.");
                    }
                });
            }

        });
    </script>
@endpush
