@extends('layouts.main')

@section('title', 'Modul: ' . $module->category->subDivision)

@section('content')
    <div class="wrapper">
        <a href="{{ url()->previous() }}">
            <i class="fa fa-arrow-left fa-2x wow fadeInRight mb-4">Kembali</i>
        </a>
        <div class="single container">
            <h1 class="mb-4 text-center">{{ $module->category->subDivision }}</h1>
            <hr>

            <!-- Menampilkan modul yang dipilih -->
            <div class="single-content wow fadeInUp mb-5">
                <h2>{{ $module->title }}</h2>
                <div class="modul-description">
                    {!! nl2br(e(strip_tags($module->content))) !!}
                </div>
                <hr>
            </div>

            <!-- Menampilkan modul lain dalam kategori yang sama, kecuali modul yang sedang ditampilkan -->
            @foreach ($module->category->modules->where('id', '!=', $module->id) as $modul)
                <div class="single-content wow fadeInUp mb-5">
                    <h3>{{ $modul->title }}</h3>
                    <div class="modul-description" style="text-align: justify">
                        {!! nl2br(e(strip_tags($modul->content, '<p><br><b><i><strong><em><ul><ol><li>'))) !!}
                    </div>
                    <hr>
                </div>
            @endforeach
        </div>

        <!-- Tombol Mulai Kuis -->
        <div class="single-tags wow fadeInUp mx-5">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#quizConfirmationModal">Mulai
                Kuis</a>
        </div>

        <!-- Modal Konfirmasi Mulai Kuis -->
        <div class="modal fade" id="quizConfirmationModal" tabindex="-1" role="dialog"
            aria-labelledby="quizConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quizConfirmationModalLabel">Konfirmasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda ingin memulai kuis?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <a href="{{ route('client.test.category', $module->category->id) }}" class="btn btn-primary">Ya</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    </div>
@endsection
