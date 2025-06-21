@extends('layouts.main')

@section('title', 'Daftar Pengguna')

@section('content')
    <div class="team">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Daftar Pengguna</h2>
            </div>
            <div class="row">
                @foreach ($users as $user)
                    <div class="col-lg-3 col-md-6 mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card shadow-sm border-3 team-item">
                            <div class="team-text">
                                <h2 class="mb-1">{{ $user->name }}</h2>
                                <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                            </div>
                            <div class="">
                                <small>Bergabung sejak {{ $user->created_at->format('d-m-Y') }}</small>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
