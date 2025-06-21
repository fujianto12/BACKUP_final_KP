@extends('layouts.main')

@section('title', 'Modul: ' . $module->category->name)

@section('content')
    <div class="wrapper">
        <a href="{{ url()->previous() }}">
            <i class="fa fa-arrow-left fa-2x wow fadeInRight mb-4">Kembali</i>
        </a>
        <div class="single container">
            <h1 class="mb-4 text-center">{{ $module->category->name }}</h1>
            <hr>

            @foreach ($module->category->modules as $modul)
                <div class="single-content wow fadeInUp mb-5">
                    @if ($modul->image)
                        <img src="{{ asset('storage/' . $modul->image) }}" alt="{{ $modul->title }}" class="img-fluid mb-3" />
                    @endif
                    <h2>{{ $modul->title }}</h2>
                    <div>{!! $modul->content !!}</div>
                    <hr>
                </div>
            @endforeach
        </div>

        {{-- Pesan error dari controller --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-5" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Informasi Percobaan Kuis --}}
        <div class="quiz-info-section mx-5 mb-4">
            @if ($quizAttempt) {{-- Pastikan objek $quizAttempt ada --}}
                <p class="h5">
                    <i class="fa fa-info-circle mr-2"></i>Percobaan Kuis Anda:
                    <span class="badge badge-info">{{ $quizAttempt->attempts_left }} tersisa</span>
                </p>

                @if ($quizAttempt->last_attempt_at) {{-- Jika sudah pernah mencoba --}}
                    @php
                        // Menggunakan Carbon untuk perhitungan waktu
                        $cooldownEndTime = $quizAttempt->last_attempt_at->addHours(1);
                        $resetAllAttemptsTime = $quizAttempt->last_attempt_at->addHours(3);
                        $now = Carbon\Carbon::now();
                    @endphp

                    @if ($quizAttempt->attempts_left > 0 && $now->lt($cooldownEndTime))
                        {{-- Dalam masa cooldown 1 jam setelah percobaan terakhir --}}
                        <p class="text-warning">
                            <i class="fa fa-clock-o mr-1"></i>Anda baru saja melakukan percobaan. Silakan tunggu sekitar
                            **{{ $now->diffForHumans($cooldownEndTime, true, false, 2) }}** lagi
                            sebelum percobaan berikutnya.
                        </p>
                    @elseif ($quizAttempt->attempts_left <= 0 && $now->lt($resetAllAttemptsTime))
                        {{-- Semua percobaan habis, menunggu reset 3 jam --}}
                        <p class="text-danger">
                            <i class="fa fa-ban mr-1"></i>Semua percobaan telah digunakan. Percobaan akan direset dalam sekitar
                            **{{ $now->diffForHumans($resetAllAttemptsTime, true, false, 2) }}** lagi.
                        </p>
                    @elseif ($quizAttempt->attempts_left < 3 && $now->greaterThanOrEqualTo($cooldownEndTime))
                        {{-- Bisa mencoba lagi setelah cooldown 1 jam, tapi belum 3 jam total --}}
                        <p class="text-success">
                            <i class="fa fa-check-circle-o mr-1"></i>Anda siap untuk percobaan berikutnya!
                        </p>
                    @endif
                @else
                    {{-- Belum pernah mencoba sama sekali --}}
                    <p class="text-muted">
                        <i class="fa fa-lightbulb-o mr-1"></i>Anda memiliki **3 percobaan** untuk kuis ini.
                    </p>
                @endif
            @else
                <p class="text-danger">Informasi percobaan kuis tidak tersedia.</p>
            @endif
        </div>

        <div class="single-tags wow fadeInUp mx-5">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#quizConfirmationModal">Mulai Kuis</a>
        </div>

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

        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    </div>
@endsection
