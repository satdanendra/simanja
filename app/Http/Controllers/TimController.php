<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tims = Tim::all();
        return view('tim', compact('tims'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tim.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tim' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        Tim::create([
            'nama_tim' => $request->nama_tim,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('tim')->with('success', 'Tim berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tim $tim)
    {
        return view('tim.show', compact('tim'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tim $tim)
    {
        return view('tim.edit', compact('tim'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tim $tim)
    {
        $validated = $request->validate([
            'nama_tim' => 'required|string|max:255',
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
        $tim->load('users'); // Eager load users yang berelasi dengan tim

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
