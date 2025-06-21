@extends('layouts.main')

@section('title', 'About')

@section('content')


    <!-- Carousel Start -->
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <video class="d-block w-100" autoplay muted loop playsinline>
                    <source src="{{ asset('img/WhatsApp Video 2025-05-14 at 20.11.57_6452b6d2.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="carousel-caption">
                    <p class="animated fadeInRight">Kami Adalah Profesional</p>
                    <h1 class="animated fadeInLeft">Untuk Proyek Impian Anda</h1>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Carousel End -->


    <!-- Feature Start-->
    <div class="feature wow fadeInUp" data-wow-delay="0.1s">
        <div class="container-fluid">
            <div class="row align-items-center mb-5">
                <div class="col-lg-4 col-md-12">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="flaticon-worker"></i>
                        </div>
                        <div class="feature-text">
                            <h3>Pekerja Profesional</h3>
                            <p>Pekerja disini semua nya semua profesional dan terampil menggunakan alat alat berat
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="flaticon-building"></i>
                        </div>
                        <div class="feature-text">
                            <h3>Alat Berkualitas</h3>
                            <p>Di lematang ini menyediakan alat alat konstruksi yang berkualitas dan menyediakan
                                alat-alat berkualitas tinggi</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="flaticon-call"></i>
                        </div>
                        <div class="feature-text">
                            <h3>24/7 Support</h3>
                            <p>Kami menyediakan layanan panggilan dari pagi sampai Sore</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End-->





@endsection
