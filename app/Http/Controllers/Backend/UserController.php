<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Get users with their related kelas data
        $users = User::with('kelas')->latest()->get();
        $kelass = Kelas::whereNot('jurusan', 'UMUM')->orderBy('nama_kelas', 'asc')->get();

        return view('backend.user.index', compact('users', 'kelass'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $kelass = Kelas::whereNot('jurusan', 'UMUM')->orderBy('nama_kelas', 'asc')->get();

        return view('backend.user.create', compact('kelass'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'isAdmin' => ['required', 'in:1,0'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'kelas_id.required' => 'Kelas wajib diisi.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
            'isAdmin.required' => 'Role wajib dipilih.',
            'isAdmin.in' => 'Role harus admin atau user.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'kelas_id' => $request->kelas_id,
                'isAdmin' => (bool) $request->isAdmin, // Convert to boolean
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('backend.users.index')
                ->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('kelas');
        return view('backend.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $kelass = Kelas::whereNot('jurusan', 'UMUM')->orderBy('nama_kelas', 'asc')->get();

        return view('backend.user.edit', compact('user', 'kelass'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'isAdmin' => ['required', 'in:1,0'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'kelas_id.required' => 'Kelas wajib diisi.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
            'isAdmin.required' => 'Role wajib dipilih.',
            'isAdmin.in' => 'Role harus admin atau user.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'kelas_id' => $request->kelas_id,
                'isAdmin' => (bool) $request->isAdmin, // Convert to boolean
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return redirect()->route('backend.users.index')
                ->with('success', 'User berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate user: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Prevent deletion of the current authenticated user
            if (Auth::id() === $user->id) {
                return redirect()->route('backend.users.index')
                    ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
            }

            $user->delete();

            return redirect()->route('backend.users.index')
                ->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus user: ' . $e->getMessage());
        }
    }
}