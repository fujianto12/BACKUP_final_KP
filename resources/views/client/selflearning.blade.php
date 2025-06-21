@extends('layouts.main')

@section('title', 'Self Learning')

@section('content')
    <!-- selflearning Start -->
    <div class="selflearning min-vh-100 d-flex flex-column">
        <div class="container mx-auto px-4 flex-1">
            <div class="section-header text-center mb-4 mt-5">
                <h2 class="h3 font-weight-bold text-center">Pilihan Self Learning</h2>
                {{-- <h2 class="h3 font-weight-bold text-center text-success">Sisa Hapus codingan css yang tidak perlu sebelum
                    buat tampilan di bwh ini</h2> --}}
                <hr class="my-4">
            </div>
            <div class="row row-cols-4 g-4">
                @foreach ($categories as $category)
                    @php
                        $firstModule = $category->modules->first(); // modul pertama di kategori
                    @endphp

                    <div class="col">
                        @if ($firstModule)
                            <a href="{{ route('modules.show', $firstModule->id) }}" class="card h-100 text-decoration-none">
                                <div class="card-body">
                                    <h5 class="h5" style="color: #73EC8B;">{{ $category->name }}</h5>
                                    <i class="fas fa-arrow-right ml-2"></i> <!-- Menambahkan ikon panah ke kanan -->
                                </div>
                            </a>
                        @else
                            <div class="card h-100">
                                <div class="card-body">
                                    <p class="text-muted">{{ $category->name }} - Tidak ada modul tersedia</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- selflearning End -->
@endsection
