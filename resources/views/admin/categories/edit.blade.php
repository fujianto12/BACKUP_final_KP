@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Tampilkan pesan error jika ada -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card Form Edit -->
    <div class="card shadow">
        <div class="card-header">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Kategori') }}</h1>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-success btn-sm shadow-sm">{{ __('Kembali') }}</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="division">Division</label>
                    <input type="text" class="form-control" id="division" name="division" placeholder="Division"
                        value="{{ old('division', $category->division) }}" required>
                </div>

                <div class="form-group">
                    <label for="subDivision">Sub Division</label>
                    <input type="text" class="form-control" id="subDivision" name="subDivision" placeholder="Sub Division"
                        value="{{ old('subDivision', $category->subDivision) }}" required>
                </div>

                <button type="submit" class="btn btn-success btn-block">{{ __('Simpan') }}</button>
            </form>
        </div>
    </div>

</div>
@endsection
