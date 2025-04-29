<?php

namespace App\Http\Controllers;

use App\Models\RincianKegiatan;
use App\Models\AlokasiRincianKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AlokasiRincianKegiatanController extends Controller
{
    /**
     * Menampilkan detail rincian kegiatan dengan form alokasi.
     */
    public function detailRincianKegiatan(RincianKegiatan $rincianKegiatan)
    {
        // Memuat semua relasi yang diperlukan
        $rincianKegiatan->load([
            'kegiatan.masterKegiatan',
            'kegiatan.proyek.masterProyek',
            'kegiatan.proyek.rkTim.tim',
            'masterRincianKegiatan',
            'alokasi.pelaksana'
        ]);

        // Menghitung total alokasi yang sudah ditetapkan
        $totalAllocated = $rincianKegiatan->alokasi->sum('target');
        $remainingVolume = ($rincianKegiatan->volume ?? 0) - $totalAllocated;

        // Mendapatkan semua anggota tim dari tim terkait
        $tim = $rincianKegiatan->kegiatan->proyek->rkTim->tim;
        $timMembers = $tim->users()->get();
        
        // Mendapatkan alokasi yang sudah ada
        $existingAllocations = $rincianKegiatan->alokasi;

        return view('detailrinciankegiatan', compact(
            'rincianKegiatan',
            'timMembers',
            'totalAllocated',
            'remainingVolume',
            'existingAllocations'
        ));
    }

    /**
     * Menyimpan alokasi baru untuk rincian kegiatan.
     */
    public function storeAlokasi(Request $request, RincianKegiatan $rincianKegiatan)
    {
        $validator = Validator::make($request->all(), [
            'pelaksana_id' => 'required|exists:users,id',
            'target' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Menghitung total alokasi dan memeriksa apakah alokasi baru melebihi volume yang tersedia
        $totalAllocated = $rincianKegiatan->alokasi->sum('target');
        $remainingVolume = ($rincianKegiatan->volume ?? 0) - $totalAllocated;
        
        if ($request->target > $remainingVolume) {
            return redirect()->back()
                ->with('error', 'Alokasi melebihi volume yang tersisa (' . $remainingVolume . ')')
                ->withInput();
        }

        // Memeriksa apakah pengguna adalah anggota tim
        $tim = $rincianKegiatan->kegiatan->proyek->rkTim->tim;
        $isMember = $tim->users()->where('users.id', $request->pelaksana_id)->exists();
        
        if (!$isMember) {
            return redirect()->back()
                ->with('error', 'Pelaksana bukan anggota tim')
                ->withInput();
        }

        // Membuat alokasi baru
        AlokasiRincianKegiatan::create([
            'rincian_kegiatan_id' => $rincianKegiatan->id,
            'pelaksana_id' => $request->pelaksana_id,
            'target' => $request->target,
            'realisasi' => 0, // Default ke 0
        ]);

        return redirect()->route('detailrinciankegiatan', $rincianKegiatan->id)
            ->with('success', 'Alokasi berhasil ditambahkan');
    }

    /**
     * Memperbarui alokasi.
     */
    public function updateAlokasi(Request $request, AlokasiRincianKegiatan $alokasi)
    {
        $validator = Validator::make($request->all(), [
            'target' => 'required|numeric|min:0.01',
            'realisasi' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Mendapatkan rincian kegiatan
        $rincianKegiatan = $alokasi->rincianKegiatan;
        
        // Menghitung total alokasi tidak termasuk yang saat ini
        $totalAllocated = $rincianKegiatan->alokasi->where('id', '!=', $alokasi->id)->sum('target');
        $remainingVolume = ($rincianKegiatan->volume ?? 0) - $totalAllocated;
        
        if ($request->target > $remainingVolume) {
            return redirect()->back()
                ->with('error', 'Alokasi melebihi volume yang tersisa (' . $remainingVolume . ')')
                ->withInput();
        }

        // Memperbarui alokasi
        $alokasi->update([
            'target' => $request->target,
            'realisasi' => $request->realisasi,
        ]);

        return redirect()->route('detailrinciankegiatan', $rincianKegiatan->id)
            ->with('success', 'Alokasi berhasil diperbarui');
    }

    /**
     * Menghapus alokasi.
     */
    public function destroyAlokasi(AlokasiRincianKegiatan $alokasi)
    {
        $rincianKegiatanId = $alokasi->rincian_kegiatan_id;
        $alokasi->delete();

        return redirect()->route('detailrinciankegiatan', $rincianKegiatanId)
            ->with('success', 'Alokasi berhasil dihapus');
    }
}