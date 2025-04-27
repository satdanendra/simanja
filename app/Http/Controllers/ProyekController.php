<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Kegiatan;
use App\Models\MasterKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProyekController extends Controller
{
    /**
     * Menampilkan detail Proyek
     */
    public function detailProyek(Proyek $proyek)
    {
        // Load necessary relationships
        $proyek->load(['rkTim.tim', 'rkTim.tim.rkTims', 'rkTim.masterRkTim', 'masterProyek', 'picUser']);

        // Dapatkan semua kegiatan yang terkait dengan Proyek ini
        $kegiatans = Kegiatan::where('proyek_id', $proyek->id)
            ->with('masterKegiatan')
            ->get();

        // Ambil Master Kegiatan yang tersedia (yang belum ditambahkan ke Proyek ini)
        $availableKegiatans = MasterKegiatan::where('master_proyek_id', $proyek->masterProyek->id)
            ->whereDoesntHave('kegiatans', function ($query) use ($proyek) {
                $query->where('proyek_id', $proyek->id);
            })
            ->get();

        // Debug: Check if we're getting data
        // dd($availableKegiatans);

        // Ambil semua data IKU untuk dropdown
        $ikus = \App\Models\Iku::all();

        // Ambil semua anggota tim untuk dropdown PIC proyek
        $anggotaTim = $proyek->rkTim->tim->users()->get();

        // Additional information about RK Tims for editing the proyek
        $rkTims = $proyek->rkTim->tim->rkTims()->with('masterRkTim')->get();

        return view('detailproyek', compact(
            'proyek',
            'kegiatans',
            'availableKegiatans',
            'anggotaTim',
            'ikus',
            'rkTims'
        ));
    }

    /**
     * Update proyek
     */
    public function update(Request $request, Proyek $proyek)
    {
        $validator = Validator::make($request->all(), [
            'rk_tim_id' => 'required|exists:rk_tim,id',  // Added RK Tim ID validation
            'proyek_kode' => 'required|string|max:50',
            'proyek_urai' => 'required|string',
            'iku_kode' => 'nullable|string|max:50',
            'iku_urai' => 'nullable|string',
            'rk_anggota' => 'nullable|string',
            'proyek_lapangan' => 'required|string|in:Ya,Tidak',
            'pic' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verify that the RK Tim belongs to the same Tim as the current RK Tim
        $currentRkTim = $proyek->rkTim;
        $newRkTim = \App\Models\RkTim::findOrFail($request->rk_tim_id);

        if ($currentRkTim->tim_id != $newRkTim->tim_id) {
            return redirect()->back()
                ->with('error', 'RK Tim harus berasal dari Tim yang sama');
        }

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

        // Update PIC proyek and RK Tim
        $proyek->update([
            'pic' => $request->pic,
            'rk_tim_id' => $request->rk_tim_id  // Update RK Tim
        ]);

        return redirect()->route('detailproyek', $proyek->id)
            ->with('success', 'Proyek berhasil diperbarui');
    }

    /**
     * Menyimpan Kegiatan baru ke Proyek
     */
    public function simpanKegiatan(Request $request, Proyek $proyek)
    {
        // Cek apakah ini penambahan kegiatan dari checkbox atau kegiatan baru
        $isAddingExistingKegiatans = $request->has('kegiatan_ids') && !empty($request->kegiatan_ids);
        $isAddingNewKegiatan = $request->has('add_new_kegiatan') && $request->add_new_kegiatan;

        // Atur validasi dinamis berdasarkan input
        $rules = [];

        // Jika menambahkan kegiatan baru, wajib ada kode dan uraian
        if ($isAddingNewKegiatan) {
            $rules['new_kegiatan_kode'] = 'required|string|max:50';
            $rules['new_kegiatan_urai'] = 'required|string';
        }

        // Aturan validasi umum
        $rules['kegiatan_ids'] = 'nullable|array';
        $rules['kegiatan_ids.*'] = 'exists:master_kegiatan,id';

        // Validasi data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses Kegiatan yang dipilih dari daftar
        if ($isAddingExistingKegiatans) {
            foreach ($request->kegiatan_ids as $kegiatanId) {
                // Cek jika Kegiatan sudah ada di Proyek ini
                $exists = Kegiatan::where('proyek_id', $proyek->id)
                    ->where('master_kegiatan_id', $kegiatanId)
                    ->exists();

                if (!$exists) {
                    Kegiatan::create([
                        'proyek_id' => $proyek->id,
                        'master_kegiatan_id' => $kegiatanId,
                    ]);
                }
            }
        }

        // Proses Kegiatan baru yang diinput manual
        if ($isAddingNewKegiatan) {
            // Buat Master Kegiatan baru
            $masterKegiatan = MasterKegiatan::create([
                'master_proyek_id' => $proyek->masterProyek->id,
                'kegiatan_kode' => $request->new_kegiatan_kode,
                'kegiatan_urai' => $request->new_kegiatan_urai,
                'iki' => $request->new_iki,
            ]);

            // Buat relasi Kegiatan dengan Proyek
            Kegiatan::create([
                'proyek_id' => $proyek->id,
                'master_kegiatan_id' => $masterKegiatan->id,
            ]);
        }

        return redirect()->route('detailproyek', $proyek->id)
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    /**
     * Update Kegiatan
     */
    public function updateKegiatan(Request $request, Proyek $proyek, $kegiatanId)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan_kode' => 'required|string|max:50',
            'kegiatan_urai' => 'required|string',
            'iki' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cari kegiatan berdasarkan ID
        $kegiatan = Kegiatan::findOrFail($kegiatanId);

        // Verifikasi bahwa Kegiatan terkait dengan Proyek ini
        if ($kegiatan->proyek_id != $proyek->id) {
            return redirect()->back()->with('error', 'Kegiatan tidak terkait dengan Proyek ini.');
        }

        $masterKegiatan = $kegiatan->masterKegiatan;

        // Update data master kegiatan
        $masterKegiatan->update([
            'kegiatan_kode' => $request->kegiatan_kode,
            'kegiatan_urai' => $request->kegiatan_urai,
            'iki' => $request->iki,
        ]);

        return redirect()->route('detailproyek', $proyek->id)
            ->with('success', 'Kegiatan berhasil diperbarui');
    }
}
