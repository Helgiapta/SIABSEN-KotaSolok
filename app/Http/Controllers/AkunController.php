<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('admin.akun', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:user,username',
            'password' => ['required', 'confirmed', Password::min(6)],
            'role'     => 'required|in:admin,pengawas',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'username.required'  => 'Username wajib diisi.',
            'username.unique'    => 'Username sudah digunakan, pilih yang lain.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 6 karakter.',
            'role.required'      => 'Role wajib dipilih.',
            'role.in'            => 'Role tidak valid.',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.akun')->with('success', "Akun '{$request->username}' berhasil dibuat.");
    }

    public function destroy(int $id)
    {
        // Tidak boleh hapus akun sendiri
        if (Auth::id() === $id) {
            return redirect()->route('admin.akun')->with('error', 'Tidak dapat menghapus akun yang sedang digunakan. Login ke akun lain terlebih dahulu.');
        }

        $user = User::findOrFail($id);

        // Setiap role harus memiliki minimal 1 akun
        $jumlahRoleini = User::where('role', $user->role)->count();
        if ($jumlahRoleini <= 1) {
            $roleLabel = $user->role === 'admin' ? 'Admin' : 'Pengawas';
            return redirect()->route('admin.akun')
                ->with('error', "Tidak dapat menghapus. Akun {$roleLabel} harus tersedia minimal 1 buah. Buat akun {$roleLabel} baru terlebih dahulu.");
        }

        $username = $user->username;
        $user->delete();

        return redirect()->route('admin.akun')->with('success', "Akun '{$username}' berhasil dihapus.");
    }
}
