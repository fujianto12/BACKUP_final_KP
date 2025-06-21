@extends('layouts.client')

@section('title', 'Test Kategori')

@section('content')
<div class="container mt-4">
    <h1>Mulai Test</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($categories->isEmpty())
        <p>Tidak ada kategori atau soal yang tersedia.</p>
    @else
        <!-- Menampilkan Form Kuis -->
        @foreach ($categories as $category)
            <form action="{{ route('client.test.store', $category->id) }}" method="POST" id="quizForm">
                @csrf

                <div class="card mb-3">
                    <div class="card-header">
                        <h2>Kategori: {{ $category->name }}</h2>
                    </div>

                    <div class="card-body" id="quizQuestions" style="pointer-events: none;">
                        @foreach ($category->questions as $question)
                            <div class="card mb-3 question" style="filter: blur(5px);">
                                <div class="card-header">
                                    <p><strong>{{ $loop->iteration }}. {{ $question->question_text }}</strong></p>
                                </div>

                                <div class="card-body">
                                    @foreach ($question->options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                   name="questions[{{ $question->id }}]"
                                                   id="option{{ $option->id }}"
                                                   value="{{ $option->id }}"
                                                   @if(old("questions.$question->id") == $option->id) checked @endif
                                                   required>
                                            <label class="form-check-label" for="option{{ $option->id }}">
                                                {{ $option->option_text }}
                                            </label>
                                        </div>
                                    @endforeach

                                    @if($errors->has("questions.$question->id"))
                                        <span style="margin-top: .25rem; font-size: 80%; color: #e3342f;" role="alert">
                                            <strong>{{ $errors->first("questions.$question->id") }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="button" class="btn btn-primary" id="startTestButton">Mulai Tes</button>
                <button type="submit" class="btn btn-primary" id="submitButton" style="display: none;">Kirim Jawaban</button>
            </form>
        @endforeach
    @endif
</div>

<!-- Overlay untuk mengunci interaksi sebelum tes dimulai -->
<div id="overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); display: none; z-index: 1000;"></div>

<!-- Timer dan Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Menampilkan SweetAlert2 pemberitahuan waktu
        Swal.fire({
            title: 'Pemberitahuan Waktu',
            text: 'Waktu yang disediakan untuk mengerjakan tes adalah 30 menit. Pastikan Anda menyelesaikan tes sebelum waktu habis.',
            icon: 'info',
            showCancelButton: false,
            confirmButtonText: 'Mulai Tes',
        }).then((result) => {
            if (result.isConfirmed) {
                startTest();
            }
        });

        // Menangani tombol Mulai Tes
        document.getElementById('startTestButton').addEventListener('click', function() {
            startTest();
        });

        function startTest() {
            // Menonaktifkan overlay untuk mengizinkan interaksi
            document.getElementById('overlay').style.display = 'none';

            // Hapus blur pada soal dan aktifkan interaksi
            document.querySelectorAll('.question').forEach(function(question) {
                question.style.filter = 'none';
            });

            // Mengaktifkan interaksi pada form
            document.getElementById('quizQuestions').style.pointerEvents = 'auto';

            // Menampilkan tombol Kirim Jawaban dan menyembunyikan tombol Mulai Tes
            document.getElementById('submitButton').style.display = 'inline-block';
            document.getElementById('startTestButton').style.display = 'none';

            // Mulai timer
            startTimer();
        }
    });

    let timer;
    let timeRemaining = 1 * 5; // 30 menit dalam detik
    const submitButton = document.getElementById('submitButton');
    const quizForm = document.getElementById('quizForm');

    function startTimer() {
        timer = setInterval(function() {
            if (timeRemaining <= 0) {
                clearInterval(timer);
                submitButton.disabled = false;
                alert("Waktu habis! Tes telah selesai.");

                // Kirim formulir otomatis setelah waktu habis
                submitQuizForm();
            } else {
                timeRemaining--;
                updateTimerDisplay();
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        document.title = `Waktu Tersisa: ${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
    }

    // Fungsi untuk mengirimkan formulir secara otomatis
    function submitQuizForm() {
        // Kirim formulir ketika waktu habis
        quizForm.submit();
    }
</script>

@endsection
