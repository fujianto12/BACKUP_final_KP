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
                {{-- Category Filters --}}
                <div class="mb-4">
                    <h6 class="font-weight-bold text-primary mb-2">Filter Kategori:</h6>
                    <button class="btn btn-outline-primary btn-sm category-filter-btn" data-category-id="">All Categories</button>
                    @foreach($categories as $category)
                        <button class="btn btn-outline-primary btn-sm category-filter-btn" data-category-id="{{ $category->id }}">{{ $category->name }}</button>
                    @endforeach
                </div>
                {{-- End Category Filters --}}

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-question"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
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
                                    <td>{{ $question->category->name ?? 'N/A' }}</td> {{-- Added 'N/A' for robustness --}}
                                    <td>{{ $question->question_text }}</td>
                                    <td>
                                        <a href="{{ route('admin.detailsoal.index', $question->id) }}"
                                            class="btn btn-success">Lihat Detail Soal</a>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.questions.edit', $question->id) }}"
                                                class="btn btn-info">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <form onclick="return confirm('Are you sure you want to delete this item?')" class="d-inline"
                                                action="{{ route('admin.questions.destroy', $question->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger"
                                                    style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let deleteButton = {
                text: '<i class="fa fa-trash"></i> <span class="ml-1">Hapus</span>',
                url: "{{ route('admin.questions.mass_destroy') }}",
                className: 'btn-danger',
                action: function(e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).nodes(), function(entry) {
                        return $(entry).data('entry-id')
                    });
                    if (ids.length === 0) {
                        alert('No rows selected.')
                        return
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
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)

            let table = $('.datatable-question:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                order: [
                    [1, 'asc']
                ],
                pageLength: 50,
                // Make sure to destroy the existing DataTable instance before reinitializing
                // This is crucial for dynamic data loading
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
                let url = "{{ route('admin.questions.index') }}"; // Base URL for questions

                if (categoryId) {
                    url = `${url}?category_id=${categoryId}`; // Add category_id to URL if selected
                }

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        // Clear existing rows
                        table.clear().draw();

                        // Add new rows based on filtered data
                        if (data.length > 0) {
                            $.each(data, function(index, question) {
                                table.row.add([
                                    '', // Empty for the checkbox column if you have one
                                    index + 1,
                                    question.category ? question.category.name : 'N/A',
                                    question.question_text,
                                    `<a href="/admin/detailsoal/${question.id}" class="btn btn-success">Lihat Detail Soal</a>`,
                                    `<div class="btn-group btn-group-sm">
                                        <a href="/admin/questions/${question.id}/edit" class="btn btn-info">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form onclick="return confirm('Are you sure you want to delete this item?')" class="d-inline"
                                            action="/admin/questions/${question.id}" method="POST">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>`
                                ]).draw(false);
                            });
                        } else {
                            // If no data, add a row indicating empty data
                            table.row.add([
                                '', '', '', '', '', '<td colspan="7" class="text-center">{{ __("Data Empty") }}</td>'
                            ]).draw(false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching filtered questions:", error);
                        alert("Failed to load questions. Please try again.");
                    }
                });
            }
        });
    </script>
@endpush
