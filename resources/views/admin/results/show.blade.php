@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->


        <!-- Content Row -->
        <div class="card">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    Total points: {{ $result->total_points }} points
                </h6>
                <div class="ml-auto">
                    <a href="{{ route('admin.results.index') }}" class="btn btn-primary">
                        <span class="text">{{ __('Go Back') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Soal</th>
                                <th>Jawaban Anda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result->questions as $question)
                                <tr>
                                    <!-- Kolom Soal -->
                                    <td style="width: 70%">
                                        <strong>{{ $question->question_text }}</strong>
                                        <ul class="mt-2">
                                            @foreach ($question->options as $option)
                                                <li>
                                                    {{ $option->option_text }}

                                                    @if ($option->points > 0)
                                                        <span class="text-success">(Jawaban yang benar)</span>
                                                    @endif

                                                    @if ($question->pivot->option_id == $option->id)
                                                        <span class="text-primary ml-2">← Jawaban Anda</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    <!-- Kolom Penilaian Jawaban -->
                                    <td style="vertical-align: middle; width: 30%">
                                        @php
                                            $selectedOption = $question->options
                                                ->where('id', $question->pivot->option_id)
                                                ->first();
                                        @endphp

                                        @if ($selectedOption)
                                            @if ($selectedOption->points > 0)
                                                <span class="text-success font-weight-bold">Benar</span>
                                            @else
                                                <span class="text-danger font-weight-bold">Salah</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Tidak menjawab</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>



                    </table>
                </div>
            </div>
        </div>
        <!-- Content Row -->

    </div>
@endsection
