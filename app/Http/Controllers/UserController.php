<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MasterPegawai;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Added missing Hash facade
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('pegawai')->get();

        // Ambil ID pegawai yang sudah terdaftar sebagai user
        $registeredPegawaiIds = User::pluck('pegawai_id')->toArray();

        // Ambil pegawai yang belum terdaftar sebagai user
        $pegawais = MasterPegawai::whereNotIn('id', $registeredPegawaiIds)->get();

        return view('user', compact('users', 'pegawais'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:master_pegawais,id|unique:users,pegawai_id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'sometimes|exists:roles,id',
        ]);

        // Ambil data pegawai untuk mendapatkan nama
        $pegawai = MasterPegawai::find($validated['pegawai_id']);


        $user = User::create([
            'pegawai_id' => $validated['pegawai_id'],
            'name' => $pegawai->alias,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'] ?? 3,
        ]);

        return redirect()->route('user')
            ->with('success', 'User berhasil dibuat');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        // Validate the request data
        $validated = $request->validate([
            'new-password' => 'nullable|string|min:8',
        ]);

        // Update password jika diisi
        if ($request->filled('new-password')) {
            $user->update([
                'password' => Hash::make($request->input('new-password'))
            ]);
        }

        return redirect()->route('user')
            ->with('success', 'Data user berhasil diperbarui');
    }

    public function edit(User $user)
    {
        // Return user data as JSON
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    public function deactivate($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->is_active = false;
            $user->save();

            // Tambahkan header Content-Type
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dinonaktifkan'
            ], 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            Log::error('Error deactivating user: ' . $e->getMessage());

            // Tambahkan header Content-Type
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan user: ' . $e->getMessage()
            ], 500, ['Content-Type' => 'application/json']);
        }
    }

    public function activate($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->is_active = true;
            $user->save();

            // Jika request AJAX, kembalikan response sebagai JSON
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil diaktifkan'
                ], 200, ['Content-Type' => 'application/json']);
            }

            return redirect()->back()->with('success', 'User berhasil diaktifkan');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error activating user: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengaktifkan user: ' . $e->getMessage()
                ], 500, ['Content-Type' => 'application/json']);
            }

            return redirect()->back()->with('error', 'Gagal mengaktifkan user');
        }
    }
}
