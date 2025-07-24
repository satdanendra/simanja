<?php

namespace App\Http\Controllers;

use App\Models\RincianKegiatan;
use App\Models\AlokasiRincianKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class AlokasiRincianKegiatanController extends Controller
{
    protected $driveService;

    public function __construct(?Drive $driveService = null)
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
            'file' => 'nullable|file|max:10240', // Max 10MB
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

        // Handle file upload if file is present
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            try {
                // Simpan file ke penyimpanan lokal terlebih dahulu
                $file = $request->file('file');
                $fileName = 'bukti_' . $alokasi->id . '_' . now()->format('YmdHis') . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('bukti_dukung', $fileName, 'public');

                $updateData['bukti_dukung_file_name'] = $fileName;
                $updateData['bukti_dukung_uploaded_at'] = now();

                // Jika ingin tetap mengupload ke Google Drive setelah disimpan lokal
                if ($this->driveService) {
                    $uploadedFile = $this->uploadFileToDrive($file, $alokasi, $fileName);

                    if ($uploadedFile) {
                        $updateData['bukti_dukung_file_id'] = $uploadedFile['id'];
                        $updateData['bukti_dukung_link'] = $uploadedFile['webViewLink'];
                    }
                } else {
                    // Jika tidak ada Google Drive service, gunakan URL lokal
                    $updateData['bukti_dukung_link'] = asset('storage/' . $filePath);
                }
            } catch (\Exception $e) {
                Log::error('File upload error: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Gagal mengupload file: ' . $e->getMessage())
                    ->withInput();
            }
        }

        // Memperbarui alokasi
        $alokasi->update($updateData);

        return redirect()->route('detailrinciankegiatan', $rincianKegiatan->id)
            ->with('success', 'Alokasi berhasil diperbarui');
    }

    /**
     * Upload file to Google Drive (optional after local storage)
     */
    private function uploadFileToDrive($file, $alokasi, $fileName)
    {
        // Check if Drive service is available
        if (!$this->driveService) {
            Log::warning('Google Drive service not available');
            return null;
        }

        try {
            // Get folder ID from config
            $folderId = config('google-drive.folder_id');

            // Create file metadata
            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [$folderId]
            ]);

            // Upload file to Google Drive
            $result = $this->driveService->files->create($fileMetadata, [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id,name,webViewLink'
            ]);

            // Make file publicly accessible for viewing
            $this->driveService->permissions->create(
                $result->getId(),
                new \Google\Service\Drive\Permission([
                    'type' => 'anyone',
                    'role' => 'reader',
                ])
            );

            return [
                'id' => $result->getId(),
                'name' => $result->getName(),
                'webViewLink' => $result->getWebViewLink()
            ];
        } catch (\Exception $e) {
            Log::error('Google Drive upload error: ' . $e->getMessage());
            return null; // Return null instead of throwing, to continue with local storage
        }
    }

    /**
     * Menghapus alokasi.
     */
    public function destroyAlokasi(AlokasiRincianKegiatan $alokasi)
    {
        // Get info before deleting
        $rincianKegiatanId = $alokasi->rincian_kegiatan_id;
        $fileId = $alokasi->bukti_dukung_file_id;
        $fileName = $alokasi->bukti_dukung_file_name;

        // Delete file from Google Drive if exists
        if ($fileId && $this->driveService) {
            try {
                $this->driveService->files->delete($fileId);
            } catch (\Exception $e) {
                Log::error('Google Drive delete error: ' . $e->getMessage());
                // Continue with deletion even if file delete fails
            }
        }

        // Delete file from local storage if exists
        if ($fileName) {
            $filePath = 'bukti_dukung/' . $fileName;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Delete allocation
        $alokasi->delete();

        return redirect()->route('detailrinciankegiatan', $rincianKegiatanId)
            ->with('success', 'Alokasi berhasil dihapus');
    }

    /**
     * Download bukti dukung.
     */
    public function downloadBuktiDukung(AlokasiRincianKegiatan $alokasi)
    {
        // Cek apakah file ada di Google Drive
        if ($alokasi->bukti_dukung_file_id && $this->driveService) {
            try {
                // Redirect langsung ke URL download Google Drive
                return redirect()->away(
                    "https://drive.google.com/uc?export=download&id={$alokasi->bukti_dukung_file_id}"
                );
            } catch (\Exception $e) {
                Log::error('Google Drive download error: ' . $e->getMessage());
                // Jika gagal, coba cek file lokal
            }
        }

        // Cek dan download dari penyimpanan lokal
        $filePath = 'bukti_dukung/' . $alokasi->bukti_dukung_file_name;

        if (Storage::disk('public')->exists($filePath)) {
            return response()->download(
                storage_path('app/public/' . $filePath),
                $alokasi->bukti_dukung_file_name
            );
        }

        return redirect()->back()->with('error', 'File tidak ditemukan');
    }
}
