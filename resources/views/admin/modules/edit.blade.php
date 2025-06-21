@extends('layouts.admin')

@section('title', 'Edit Modul')

@section('content')
<div class="container">
    <h2>Edit Modul</h2>
    <form action="{{ route('admin.modules.update', $module->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $module->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="title">Judul Modul</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $module->title) }}" required>
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Isi Modul</label>
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
