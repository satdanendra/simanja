<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\RincianKegiatan;
use App\Models\MasterRincianKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    /**
     * Menampilkan detail Kegiatan
     */
    public function detailKegiatan(Kegiatan $kegiatan)
    {
        // Load necessary relationships
        $kegiatan->load(['proyek.rkTim.tim', 'masterKegiatan', 'proyek.masterProyek']);
        
        // Dapatkan semua rincian kegiatan yang terkait dengan Kegiatan ini
        $rincianKegiatans = RincianKegiatan::where('kegiatan_id', $kegiatan->id)
            ->with('masterRincianKegiatan')
            ->get();
            
        // Ambil Master Rincian Kegiatan yang tersedia (yang belum ditambahkan ke Kegiatan ini)
        $availableRincianKegiatans = MasterRincianKegiatan::where('master_kegiatan_id', $kegiatan->masterKegiatan->id)
            ->whereDoesntHave('rincianKegiatans', function ($query) use ($kegiatan) {
                $query->where('kegiatan_id', $kegiatan->id);
            })
            ->get();
            
        return view('detailkegiatan', compact(
            'kegiatan',
            'rincianKegiatans',
            'availableRincianKegiatans'
        ));
    }
    
    /**
     * Update kegiatan
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan_kode' => 'required|string|max:50',
            'kegiatan_urai' => 'required|string',
            'iki' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Update data master kegiatan
        $masterKegiatan = $kegiatan->masterKegiatan;
        $masterKegiatan->update([
            'kegiatan_kode' => $request->kegiatan_kode,
            'kegiatan_urai' => $request->kegiatan_urai,
            'iki' => $request->iki,
        ]);
        
        return redirect()->route('detailkegiatan', $kegiatan->id)
            ->with('success', 'Kegiatan berhasil diperbarui');
    }
    
    /**
     * Menyimpan Rincian Kegiatan baru ke Kegiatan
     */
    public function simpanRincian(Request $request, Kegiatan $kegiatan)
    {
        // Cek apakah ini penambahan rincian dari checkbox atau rincian baru
        $isAddingExistingRincians = $request->has('rincian_ids') && !empty($request->rincian_ids);
        $isAddingNewRincian = $request->has('add_new_rincian') && $request->add_new_rincian;
        
        // Atur validasi dinamis berdasarkan input
        $rules = [];
        
        // Jika menambahkan rincian baru, wajib ada kode dan uraian
        if ($isAddingNewRincian) {
            $rules['new_rincian_kegiatan_kode'] = 'required|string|max:50';
            $rules['new_rincian_kegiatan_urai'] = 'required|string';
        }
        
        // Aturan validasi umum
        $rules['rincian_ids'] = 'nullable|array';
        $rules['rincian_ids.*'] = 'exists:master_rincian_kegiatan,id';
        $rules['new_volume'] = 'nullable|numeric|min:0';
        $rules['new_waktu'] = 'nullable|numeric|min:0';
        $rules['new_deadline'] = 'nullable|date';
        $rules['new_is_variabel_kontrol'] = 'nullable|boolean';
        
        // Validasi data
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Proses Rincian Kegiatan yang dipilih dari daftar
        if ($isAddingExistingRincians) {
            foreach ($request->rincian_ids as $rincianId) {
                // Cek jika Rincian Kegiatan sudah ada di Kegiatan ini
                $exists = RincianKegiatan::where('kegiatan_id', $kegiatan->id)
                    ->where('master_rincian_kegiatan_id', $rincianId)
                    ->exists();
                    
                if (!$exists) {
                    RincianKegiatan::create([
                        'kegiatan_id' => $kegiatan->id,
                        'master_rincian_kegiatan_id' => $rincianId,
                        'volume' => $request->get('volume_' . $rincianId),
                        'waktu' => $request->get('waktu_' . $rincianId),
                        'deadline' => $request->get('deadline_' . $rincianId),
                        'is_variabel_kontrol' => $request->has('is_variabel_kontrol_' . $rincianId),
                    ]);
                }
            }
        }
        
        // Proses Rincian Kegiatan baru yang diinput manual
        if ($isAddingNewRincian) {
            // Buat Master Rincian Kegiatan baru
            $masterRincianKegiatan = MasterRincianKegiatan::create([
                'master_kegiatan_id' => $kegiatan->masterKegiatan->id,
                'rincian_kegiatan_kode' => $request->new_rincian_kegiatan_kode,
                'rincian_kegiatan_urai' => $request->new_rincian_kegiatan_urai,
                'catatan' => $request->new_catatan,
                'rincian_kegiatan_satuan' => $request->new_satuan,
            ]);
            
            // Buat relasi Rincian Kegiatan dengan Kegiatan
            RincianKegiatan::create([
                'kegiatan_id' => $kegiatan->id,
                'master_rincian_kegiatan_id' => $masterRincianKegiatan->id,
                'volume' => $request->new_volume,
                'waktu' => $request->new_waktu,
                'deadline' => $request->new_deadline,
                'is_variabel_kontrol' => $request->new_is_variabel_kontrol ? true : false,
            ]);
        }
        
        return redirect()->route('detailkegiatan', $kegiatan->id)
            ->with('success', 'Rincian Kegiatan berhasil ditambahkan');
    }
    
    /**
     * Update Rincian Kegiatan
     */
    public function updateRincian(Request $request, Kegiatan $kegiatan, $rincianId)
    {
        $validator = Validator::make($request->all(), [
            'rincian_kegiatan_kode' => 'required|string|max:50',
            'rincian_kegiatan_urai' => 'required|string',
            'catatan' => 'nullable|string',
            'satuan' => 'nullable|string',
            'volume' => 'nullable|numeric|min:0',
            'waktu' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date',
            'is_variabel_kontrol' => 'nullable|boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Cari rincian kegiatan berdasarkan ID
        $rincianKegiatan = RincianKegiatan::findOrFail($rincianId);
        
        // Verifikasi bahwa Rincian Kegiatan terkait dengan Kegiatan ini
        if ($rincianKegiatan->kegiatan_id != $kegiatan->id) {
            return redirect()->back()->with('error', 'Rincian Kegiatan tidak terkait dengan Kegiatan ini.');
        }
        
        $masterRincianKegiatan = $rincianKegiatan->masterRincianKegiatan;
        
        // Update data master rincian kegiatan
        $masterRincianKegiatan->update([
            'rincian_kegiatan_kode' => $request->rincian_kegiatan_kode,
            'rincian_kegiatan_urai' => $request->rincian_kegiatan_urai,
            'catatan' => $request->catatan,
            'rincian_kegiatan_satuan' => $request->satuan,
        ]);
        
        // Update data rincian kegiatan
        $rincianKegiatan->update([
            'volume' => $request->volume,
            'waktu' => $request->waktu,
            'deadline' => $request->deadline,
            'is_variabel_kontrol' => $request->is_variabel_kontrol ? true : false,
        ]);
        
        return redirect()->route('detailkegiatan', $kegiatan->id)
            ->with('success', 'Rincian Kegiatan berhasil diperbarui');
    }
    
    /**
     * Hapus Rincian Kegiatan dari Kegiatan
     */
    public function destroyRincian(Kegiatan $kegiatan, $rincianId)
    {
        // Cari rincian kegiatan berdasarkan ID
        $rincianKegiatan = RincianKegiatan::findOrFail($rincianId);
        
        // Verifikasi bahwa Rincian Kegiatan terkait dengan Kegiatan ini
        if ($rincianKegiatan->kegiatan_id != $kegiatan->id) {
            return redirect()->back()->with('error', 'Rincian Kegiatan tidak terkait dengan Kegiatan ini.');
        }
        
        // Hapus rincian kegiatan
        $rincianKegiatan->delete();
        
        return redirect()->route('detailkegiatan', $kegiatan->id)
            ->with('success', 'Rincian Kegiatan berhasil dihapus');
    }
}