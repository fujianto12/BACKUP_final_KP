<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.profile', compact('users'));
    }

    public function create()
    {
        return view('admin.tambahuser');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'email.regex' => 'Email harus menggunakan domain @gmail.com',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'password' => 'required|string|min:6|confirmed',
        ], $messages);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.profile.index')->with([
            'message' => 'Pengguna baru berhasil di tambahkan!',
            'alert-type' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan hapus diri sendiri tanpa validasi
        if (auth()->id() == $user->id) {
            return redirect()->back()
                ->with('message', 'Tidak dapat menghapus akun sendiri.')
                ->with('alert-type', 'danger');
        }

        $user->delete();

        return redirect()->route('admin.profile.index')
            ->with([
                'message' => 'Pengguna berhasil dihapus.',
                'alert-type' => 'success'
            ]);
    }
}
