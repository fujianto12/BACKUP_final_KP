@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="text-success"><b>Detail Soal</b></h1>
        <a href="{{ route('admin.questions.index') }}" class="btn btn-success btn-sm shadow-sm mb-3">{{ __('Kembali') }}</a>
        <div class="card mb-3">
            <div class="card-header">
                <strong>Soal:</strong> {{ $question->question_text }}
            </div>
            <div class="card-body">
                <ul>
                    @foreach ($question->options as $option)
                        <li>{{ $option->option_text }} (Points: {{ $option->points }})</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <a href="{{ route('admin.questions.index') }}" class="btn btn-success">Kembali ke Daftar Soal</a>
    </div>
@endsection
