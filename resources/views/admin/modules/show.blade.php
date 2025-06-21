@extends('layouts.main')

@section('title', 'Modul Kategori: ' . $module->category->name)

@section('content')
<div class="wrapper">

    <a href="{{ url()->previous() }}">
        <i class="fa fa-arrow-left fa-2x wow fadeInRight mb-4">Kembali</i>
    </a>

    <div class="container">
        <h2 class="mb-4">Modul Kategori: {{ $module->category->name }}</h2>

        <div class="row">
            @foreach ($module->category->modules as $modul)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card wow fadeInUp">
                        @if($modul->image)
                            <img src="{{ asset('storage/' . $modul->image) }}" alt="{{ $modul->title }}" class="card-img-top" />
                        @endif
                        <div class="card-body">
                            <h5>{{ $modul->title }}</h5>
                            <p>{!! Str::limit(strip_tags($modul->content), 100) !!}</p>
                            <a href="{{ route('modules.show', $modul->id) }}" class="btn btn-success">Lihat Modul</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
</div>
@endsection
