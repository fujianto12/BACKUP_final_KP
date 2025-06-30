@extends('layouts.admin')

@section('title', 'Edit Modul')

@section('content')
    <div class="container">
        <a href="{{ route('admin.modules.index') }}" class="btn btn-success btn-sm shadow-sm mb-2">{{ __('Kembali') }}</a>
        <h2 class="text-success"><b>Edit Modul</b></h2>
        <form action="{{ route('admin.modules.update', $module->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="category_name">Ubah Nama Kategori</label>
                <input type="text" id="category_name" class="form-control" placeholder="Cari kategori..."
                    value="{{ old('category_name', isset($currentCategory) ? $currentCategory->name : '') }}"
                    autocomplete="off" required>
                <input type="hidden" name="category_id" id="category_id"
                    value="{{ old('category_id', isset($currentCategory) ? $currentCategory->id : '') }}">
                <div id="categoryList" class="list-group mt-1" style="position: absolute; z-index: 9999;"></div>
                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="title">Ubah Judul Modul</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $module->title) }}" required>
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Ubah Isi Modul</label>
                <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $module->content) }}</textarea>
                @error('content')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Perbarui Modul</button>
            <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
