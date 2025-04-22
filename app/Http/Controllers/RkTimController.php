<?php

namespace App\Http\Controllers;

use App\Models\RkTim;
use App\Models\Proyek;
use App\Models\MasterProyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RkTimController extends Controller
{
    /**
     * Menampilkan detail RK Tim
     */
    public function detailRkTim(RkTim $rktim)
    {
        $rktim->load(['tim', 'tim.masterTim', 'masterRkTim']);
        
        // Dapatkan semua proyek yang terkait dengan RK Tim ini
        $proyeks = Proyek::where('rk_tim_id', $rktim->id)->with('masterProyek')->get();
        
        // Ambil Master Proyek yang tersedia (yang belum ditambahkan ke RK Tim ini)
        $availableProyeks = MasterProyek::whereDoesntHave('proyeks', function ($query) use ($rktim) {
            $query->where('rk_tim_id', $rktim->id);
        })->get();
        
        return view('detailrktim', compact('rktim', 'proyeks', 'availableProyeks'));
    }
    
    /**
     * Menyimpan Proyek baru ke RK Tim
     */
    public function simpanProyek(Request $request, RkTim $rktim)
    {
        // Validasi request
        $validator = Validator::make($request->all(), [
            'proyek_ids' => 'nullable|array',
            'proyek_ids.*' => 'exists:master_proyek,id',
        ])
            ->after(function ($validator) use ($request) {
                // Kalau array kosong dan user ingin menambah Proyek baru, validasi kolom baru
                $proyekIds = $request->input('proyek_ids', []);
                $addNew = $request->input('add_new_proyek');

                if ((empty($proyekIds) || count($proyekIds) == 0) && $addNew) {
                    if (!$request->filled('new_proyek_kode')) {
                        $validator->errors()->add('new_proyek_kode', 'Kolom kode Proyek wajib diisi.');
                    }
                    if (!$request->filled('new_proyek_urai')) {
                        $validator->errors()->add('new_proyek_urai', 'Kolom uraian Proyek wajib diisi.');
                    }
                }
            });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses Proyek yang dipilih dari daftar
        if ($request->has('proyek_ids') && !empty($request->proyek_ids)) {
            foreach ($request->proyek_ids as $proyekId) {
                // Cek jika Proyek sudah ada di RK Tim ini
                $exists = Proyek::where('rk_tim_id', $rktim->id)
                    ->where('master_proyek_id', $proyekId)
                    ->exists();

                if (!$exists) {
                    Proyek::create([
                        'rk_tim_id' => $rktim->id,
                        'master_proyek_id' => $proyekId,
                    ]);
                }
            }
        }

        // Proses Proyek baru yang diinput manual
        if ($request->add_new_proyek) {
            // Buat Master Proyek baru
            $masterProyek = MasterProyek::create([
                'master_rk_tim_id' => $rktim->masterRkTim->id, // ID Master RK Tim
                'proyek_kode' => $request->new_proyek_kode,
                'proyek_urai' => $request->new_proyek_urai,
                'iku_kode' => $request->new_iku_kode,
                'iku_urai' => $request->new_iku_urai,
                'rk_anggota' => $request->new_rk_anggota,
                'proyek_lapangan' => $request->new_proyek_lapangan,
            ]);

            // Buat relasi Proyek dengan RK Tim
            Proyek::create([
                'rk_tim_id' => $rktim->id,
                'master_proyek_id' => $masterProyek->id,
            ]);
        }

        return redirect()->route('detailrktim', $rktim->id)
            ->with('success', 'Proyek berhasil ditambahkan');
    }
    
    /**
     * Update Proyek
     */
    public function updateProyek(Request $request, RkTim $rktim, $proyekId)
    {
        $validator = Validator::make($request->all(), [
            'proyek_kode' => 'required|string|max:50',
            'proyek_urai' => 'required|string',
            'iku_kode' => 'nullable|string|max:50',
            'iku_urai' => 'nullable|string',
            'rk_anggota' => 'nullable|string',
            'proyek_lapangan' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Cari proyek berdasarkan ID
        $proyek = Proyek::findOrFail($proyekId);
        $masterProyek = $proyek->masterProyek;

        // Update data master proyek
        $masterProyek->update([
            'proyek_kode' => $request->proyek_kode,
            'proyek_urai' => $request->proyek_urai,
            'iku_kode' => $request->iku_kode,
            'iku_urai' => $request->iku_urai,
            'rk_anggota' => $request->rk_anggota,
            'proyek_lapangan' => $request->proyek_lapangan,
        ]);

        return redirect()->route('detailrktim', $rktim->id)
            ->with('success', 'Proyek berhasil diperbarui');
    }

    /**
     * Hapus Proyek dari RK Tim
     */
    public function hapusProyek(RkTim $rktim, $proyekId)
    {
        // Hapus relasi Proyek dengan RK Tim
        $proyek = Proyek::findOrFail($proyekId);
        $proyek->delete();

        return redirect()->route('detailrktim', $rktim->id)
            ->with('success', 'Proyek berhasil dihapus dari RK Tim');
    }
}