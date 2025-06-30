@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <a href="{{ route('admin.profile.index') }}" class="btn btn-success btn-sm shadow-sm font-weight-bold p-2">Kembali</a>
        <h2 class="mb-4 font-weight-bold text-success text-center">Tambah Karyawan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.store') }}" method="POST">
            @csrf
            <fieldset>

                <div class="input-field">
                    <input type="text" name="name" placeholder=" " value="{{ old('name') }}" required />
                    <label>Nama Lengkap</label>
                </div>

                <div class="input-field">
                    <input type="email" name="email" placeholder=" " value="{{ old('email') }}" required
                        autocomplete="email" />
                    <label>Email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" class="pass-key" placeholder=" " required />
                    <label>Password</label>
                    <span class="toggle-pass" onclick="togglePassword()" role="button">&#128065;</span>
                </div>

                <div class="input-field">
                    <input type="password" name="password_confirmation" class="pass-key" placeholder=" " required />
                    <label>Confirm Password</label>
                </div>

                <button type="submit" class="btn btn-success mt-3 font-weight-bold">Register</button>
        </form>
    </div>

    <style>
        .input-field {
            position: relative;
            margin-bottom: 20px;
        }

        .input-field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            outline: none;
            border-radius: 4px;
        }

        .input-field label {
            position: absolute;
            left: 12px;
            top: 10px;
            transition: 0.2s ease;
            pointer-events: none;
            color: #777;
            background: #fff;
            padding: 0 4px;
        }

        .input-field input:focus+label,
        .input-field input:not(:placeholder-shown)+label {
            top: -10px;
            font-size: 12px;
            color: #007bff;
        }

        .toggle-pass {
            position: absolute;
            right: 10px;
            top: 12px;
            cursor: pointer;
        }
    </style>

    <script>
        function togglePassword() {
            const fields = document.querySelectorAll('.pass-key');
            fields.forEach(field => {
                field.type = field.type === 'password' ? 'text' : 'password';
            });
        }
    </script>
@endsection
