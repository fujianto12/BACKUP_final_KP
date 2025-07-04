@extends('layouts.main')

@section('title', 'Sub Division dari ' . $division)

@section('content')
    <div class="container mt-5">
        <a href="{{ route('selflearning.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h2 class="text-center mb-4 text-success">Sub Divisi dari: {{ $division }}</h2>

        <div class="row row-cols-2 row-cols-md-4 g-4">

            @foreach ($subdivisions as $sub)
                @php
                    $firstModule = \App\Models\Category::with('modules')
                        ->where('subDivision', $sub->subDivision)
                        ->where('division', $division)
                        ->first()
                        ?->modules?->first();
                @endphp

                <div class="col">
                    @if ($firstModule)
                        <a href="{{ route('modules.show', $firstModule->id) }}" class="card h-100 text-decoration-none">
                            <div class="card-body">
                                <h5 class="h5" style="color: #73EC8B;">{{ $sub->subDivision }}</h5>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </a>
                    @else
                        <div class="card h-100">
                            <div class="card-body">
                                <p class="text-muted">{{ $sub->subDivision }} - Tidak ada modul tersedia</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
    </div>
@endsection
