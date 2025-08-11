<?php

namespace App\Http\Controllers;

use App\Models\RincianKegiatan;
use App\Models\AlokasiRincianKegiatan;
use App\Models\BuktiDukung;
use App\Models\User;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AlokasiRincianKegiatanController extends Controller
{
    protected $driveService;

    public function __construct(GoogleDriveService $driveService)
    {
        $this->driveService = $driveService;
    }

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

        // Prepare update data
        $updateData = [
            'target' => $request->target,
            'realisasi' => $request->realisasi,
        ];

        // Memperbarui alokasi
        $alokasi->update($updateData);

        return redirect()->route('detailrinciankegiatan', $rincianKegiatan->id)
            ->with('success', 'Alokasi berhasil diperbarui');
    }

    /**
     * Menghapus alokasi.
     */
    public function destroyAlokasi(AlokasiRincianKegiatan $alokasi)
    {
        try {
            // Simpan rincian kegiatan ID untuk redirect
            $rincianKegiatanId = $alokasi->rincian_kegiatan_id;

            // Optional: Validasi apakah user berhak menghapus alokasi
            // Misalnya hanya pelaksana atau admin yang bisa menghapus
            // $currentUser = auth()->user();
            // if ($alokasi->pelaksana_id !== $currentUser->id && !$currentUser->isAdmin()) {
            //     return redirect()->back()
            //         ->with('error', 'Anda tidak memiliki hak untuk menghapus alokasi ini');
            // }

            // Cek apakah sudah ada realisasi
            if ($alokasi->realisasi > 0) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus alokasi yang sudah memiliki realisasi');
            }

            // Hapus alokasi
            $alokasi->delete();

            return redirect()->route('detailrinciankegiatan', $rincianKegiatanId)
                ->with('success', 'Alokasi berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting alokasi: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus alokasi');
        }
    }

    // === BUKTI DUKUNG METHODS ===

    /**
     * Menampilkan daftar bukti dukung untuk rincian kegiatan.
     */
    public function buktiDukungIndex(RincianKegiatan $rincianKegiatan)
    {
        $rincianKegiatan->load([
            'kegiatan.masterKegiatan',
            'kegiatan.proyek.masterProyek',
            'kegiatan.proyek.rkTim.tim',
            'masterRincianKegiatan',
            'buktiDukungs'
        ]);

        $buktiDukungs = $rincianKegiatan->buktiDukungs;

        return view('detailbuktidukung', compact('rincianKegiatan', 'buktiDukungs'));
    }

    /**
     * Menyimpan bukti dukung baru untuk rincian kegiatan.
     */
    public function buktiDukungStore(Request $request, RincianKegiatan $rincianKegiatan)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $uploadedFiles = [];
        $failedFiles = [];

        DB::beginTransaction();

        try {
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    try {
                        $originalName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $fileType = $this->determineFileType($extension);
                        $mimeType = $file->getMimeType();

                        // Generate unique name untuk file
                        $filename = 'Rincian_' . $rincianKegiatan->id . '_' . time() . '_' . uniqid() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;

                        // Upload ke Google Drive
                        $driveId = $this->driveService->uploadFile($file, $filename);

                        if ($driveId) {
                            // Simpan data bukti dukung ke database
                            BuktiDukung::create([
                                'rincian_kegiatan_id' => $rincianKegiatan->id,
                                'nama_file' => $originalName,
                                'file_path' => 'google_drive',
                                'drive_id' => $driveId,
                                'file_type' => $fileType,
                                'extension' => $extension,
                                'mime_type' => $mimeType,
                                'keterangan' => $request->keterangan,
                            ]);

                            $uploadedFiles[] = $originalName;
                        } else {
                            $failedFiles[] = $originalName;
                        }
                    } catch (\Exception $e) {
                        Log::error('Error uploading file: ' . $e->getMessage());
                        $failedFiles[] = $originalName;
                    }
                }
            }

            if (count($uploadedFiles) > 0) {
                DB::commit();

                $message = count($uploadedFiles) . ' file berhasil diunggah.';
                if (count($failedFiles) > 0) {
                    $message .= ' ' . count($failedFiles) . ' file gagal diunggah: ' . implode(', ', $failedFiles);
                }

                return redirect()->route('detailbuktidukung', $rincianKegiatan->id)
                    ->with('success', $message);
            } else {
                DB::rollback();
                return redirect()->back()
                    ->with('error', 'Semua file gagal diunggah ke Google Drive.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in bulk upload: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengunggah file.')
                ->withInput();
        }
    }

    /**
     * Menampilkan bukti dukung.
     */
    public function buktiDukungView(BuktiDukung $buktiDukung)
    {
        if ($buktiDukung->drive_id) {
            $url = $this->driveService->getViewUrl($buktiDukung->drive_id);
            return redirect()->away($url);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    /**
     * Download bukti dukung.
     */
    public function buktiDukungDownload(BuktiDukung $buktiDukung)
    {
        if ($buktiDukung->drive_id) {
            $url = $this->driveService->getDownloadUrl($buktiDukung->drive_id);
            return redirect()->away($url);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    /**
     * Menghapus bukti dukung.
     */
    public function buktiDukungDestroy(BuktiDukung $buktiDukung)
    {
        $rincianKegiatanId = $buktiDukung->rincian_kegiatan_id;

        // Hapus file dari Google Drive jika ada drive_id
        if ($buktiDukung->drive_id) {
            $this->driveService->deleteFile($buktiDukung->drive_id);
        }

        $buktiDukung->delete();

        return redirect()->route('detailbuktidukung', $rincianKegiatanId)
            ->with('success', 'Bukti dukung berhasil dihapus.');
    }

    /**
     * Menentukan tipe file berdasarkan ekstensi.
     */
    private function determineFileType($extension)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        $documentExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];

        $extension = strtolower($extension);

        if (in_array($extension, $imageExtensions)) {
            return 'image';
        } elseif (in_array($extension, $documentExtensions)) {
            return 'document';
        } else {
            return 'other';
        }
    }
}
