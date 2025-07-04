@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Tambah Kategori</h2>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="division">Division</label>
                <input type="text" name="division" id="division" class="form-control" value="{{ old('division') }}" required>
            </div>

            <div class="form-group">
                <label for="subDivision">Sub Division</label>
                <input type="text" name="subDivision" id="subDivision" class="form-control"
                    value="{{ old('subDivision') }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Simpan</button>
        </form>
    </div>
@endsection
