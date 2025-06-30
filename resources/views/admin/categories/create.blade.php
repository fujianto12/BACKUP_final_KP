@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Content Row -->
        <div class="card shadow">
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">{{ __('Buat Kategori') }}</h1>
                    <a href="{{ route('admin.categories.index') }}"
                        class="btn btn-success btn-sm shadow-sm">{{ __('Kembali') }}</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">{{ __('Nama') }}</label>
                        <input type="text" class="form-control" id="name" placeholder="{{ __('nama') }}"
                            name="name" value="{{ old('name') }}" />
                    </div>
                    <button type="submit" class="btn btn-success btn-block">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
