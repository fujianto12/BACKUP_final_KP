@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1>Detail Soal</h1>

    <div class="card mb-3">
        <div class="card-header">
            <strong>Soal:</strong> {{ $question->question_text }}
        </div>
        <div class="card-body">
            <ul>
                @foreach($question->options as $option)
                    <li>{{ $option->option_text }} (Points: {{ $option->points }})</li>
                @endforeach
            </ul>
        </div>
    </div>

    <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">Kembali ke Daftar Soal</a>
</div>
@endsection
