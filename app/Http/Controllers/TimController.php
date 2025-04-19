<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use App\Models\User;
use App\Models\MasterTim;
use App\Models\MasterDirektorat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data tim dengan relasi
        $tims = Tim::with(['direktorat', 'masterTim', 'ketuaTim'])->get();

        // Mengambil data untuk dropdown form
        $masterTims = MasterTim::all();
        $direktorats = MasterDirektorat::all();
        $users = User::all();

        return view('tim', compact('tims', 'masterTims', 'direktorats', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'direktorat_id' => 'required',
            'master_tim_id' => 'required',
            'tim_ketua' => 'required|exists:users,id',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        // Handle direktorat baru jika opsi 'lainnya' dipilih
        if ($request->direktorat_id === 'lainnya') {
            $request->validate([
                'direktorat_kode' => 'required|string|max:50|unique:master_direktorats,kode',
                'direktorat_nama' => 'required|string|max:255',
            ]);

            // Buat direktorat baru
            $direktorat = MasterDirektorat::create([
                'kode' => $request->direktorat_kode,
                'nama' => $request->direktorat_nama,
            ]);

            // Gunakan ID direktorat baru
            $direktoratId = $direktorat->id;
        } else {
            $direktoratId = $request->direktorat_id;
        }

        // Handle tim baru jika opsi 'lainnya' dipilih
        if ($request->master_tim_id === 'lainnya') {
            $request->validate([
                'tim_kode' => 'required|string|max:50|unique:master_tim,tim_kode',
                'tim_nama' => 'required|string|max:255',
            ]);

            // Buat tim baru
            $masterTim = MasterTim::create([
                'tim_kode' => $request->tim_kode,
                'tim_nama' => $request->tim_nama,
            ]);

            // Gunakan ID tim baru
            $masterTimId = $masterTim->id;
        } else {
            $masterTimId = $request->master_tim_id;
        }

        // Buat tim baru dengan data yang sudah divalidasi
        Tim::create([
            'direktorat_id' => $direktoratId,
            'master_tim_id' => $masterTimId,
            'tim_ketua' => $request->tim_ketua,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('tim')
            ->with('success', 'Tim berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tim $tim)
    {
        $tim->load(['direktorat', 'masterTim', 'ketuaTim']);
        return view('tim.show', compact('tim'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tim $tim)
    {
        // Untuk API request
        if (request()->ajax()) {
            return response()->json($tim);
        }

        // Mengambil data untuk dropdown form
        $masterTims = MasterTim::all();
        $direktorats = MasterDirektorat::all();
        $users = User::all();

        return view('tim.edit', compact('tim', 'masterTims', 'direktorats', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tim $tim)
    {
        $validated = $request->validate([
            'direktorat_id' => 'required|exists:master_direktorats,id',
            'master_tim_id' => 'required|exists:master_tim,id',
            'ketua_tim' => 'required|exists:users,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 10),
        ]);

        $tim->update($validated);

        return redirect()->route('tim')
            ->with('success', 'Data tim berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tim $tim)
    {
        $tim->delete();

        return redirect()->route('tim')
            ->with('success', 'Tim berhasil dihapus');
    }

    /**
     * Menampilkan anggota tim
     */
    public function anggota(Tim $tim)
    {
        $tim->load(['direktorat', 'masterTim', 'ketuaTim', 'users']); // Eager load relations

        // Dapatkan semua user yang belum menjadi anggota tim ini untuk modal
        $availableUsers = User::whereDoesntHave('tims', function ($query) use ($tim) {
            $query->where('tim_id', $tim->id);
        })->get();

        return view('detailtim', compact('tim', 'availableUsers'));
    }

    /**
     * Menyimpan anggota baru ke tim
     */
    public function simpanAnggota(Request $request, Tim $tim)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $tim->users()->attach($request->user_ids);

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'Anggota tim berhasil ditambahkan');
    }

    /**
     * Menghapus anggota dari tim
     */
    public function hapusAnggota(Tim $tim, $userId)
    {
        $tim->users()->detach($userId);

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'Anggota tim berhasil dihapus');
    }
}
