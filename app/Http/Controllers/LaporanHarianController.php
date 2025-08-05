<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarian;
use App\Models\RincianKegiatan;
use App\Models\BuktiDukung;
use App\Services\LaporanHarianPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LaporanHarianController extends Controller
{
    protected $pdfService;
    protected $driveService;

    public function __construct(
        LaporanHarianPdfService $pdfService,
        \App\Services\GoogleDriveService $driveService
    ) {
        $this->pdfService = $pdfService;
        $this->driveService = $driveService;
    }

    /**
     * Display listing of laporan harian for current user
     */
    public function index()
    {
        $laporanHarians = LaporanHarian::with([
            'user',
            'proyek.masterProyek',
            'rincianKegiatan.masterRincianKegiatan'
        ])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('laporanharian', compact('laporanHarians'));
    }

    /**
     * Show create form for laporan harian
     */
    public function create(RincianKegiatan $rincianKegiatan)
    {
        // Check if current user has alokasi in this rincian kegiatan
        $userHasAlokasi = $rincianKegiatan->alokasi()
            ->where('pelaksana_id', Auth::id())
            ->exists();

        if (!$userHasAlokasi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki alokasi pada rincian kegiatan ini.');
        }

        // Load all necessary relationships for auto-fill
        $rincianKegiatan->load([
            'kegiatan.proyek.rkTim.tim.masterTim',
            'kegiatan.proyek.rkTim.masterRkTim',
            'kegiatan.proyek.masterProyek',
            'kegiatan.masterKegiatan',
            'masterRincianKegiatan',
            'buktiDukungs'
        ]);

        return view('laporan-harian.create', compact('rincianKegiatan'));
    }

    /**
     * Store laporan harian
     */
    public function store(Request $request, RincianKegiatan $rincianKegiatan)
    {
        // Validate request
        $validated = $request->validate([
            'tipe_waktu' => 'required|in:single_date,rentang_tanggal',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
            'dasar_pelaksanaan' => 'required|array|min:1',
            'dasar_pelaksanaan.*.deskripsi' => 'required|string',
            'dasar_pelaksanaan.*.is_terlampir' => 'boolean',
            'kendala' => 'nullable|string',
            'solusi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'bukti_dukung_ids' => 'nullable|array',
            'bukti_dukung_ids.*' => 'exists:bukti_dukungs,id',
        ]);

        // Additional validation
        if ($validated['tipe_waktu'] === 'single_date') {
            $request->validate([
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ]);
        } else {
            $request->validate([
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            ]);
        }

        // Check user has alokasi
        $userHasAlokasi = $rincianKegiatan->alokasi()
            ->where('pelaksana_id', Auth::id())
            ->exists();

        if (!$userHasAlokasi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki alokasi pada rincian kegiatan ini.');
        }

        DB::beginTransaction();

        try {
            // Process dasar pelaksanaan
            $dasarPelaksanaan = [];
            foreach ($request->dasar_pelaksanaan as $index => $dasar) {
                $dasarPelaksanaan[] = [
                    'nomor' => $index + 1,
                    'deskripsi' => $dasar['deskripsi'],
                    'is_terlampir' => isset($dasar['is_terlampir']) ? (bool) $dasar['is_terlampir'] : false,
                ];
            }

            // Process bukti dukung with urutan
            $buktiDukungIds = [];
            if (!empty($request->bukti_dukung_ids)) {
                foreach ($request->bukti_dukung_ids as $index => $buktiDukungId) {
                    $buktiDukungIds[] = [
                        'id' => (int) $buktiDukungId,
                        'urutan' => $index + 1,
                    ];
                }
            }

            // Create laporan harian
            $laporan = LaporanHarian::create([
                'user_id' => Auth::id(),
                'proyek_id' => $rincianKegiatan->kegiatan->proyek_id,
                'rincian_kegiatan_id' => $rincianKegiatan->id,
                'tipe_waktu' => $validated['tipe_waktu'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'jam_mulai' => $validated['jam_mulai'],
                'jam_selesai' => $validated['jam_selesai'],
                'kegiatan_deskripsi' => $rincianKegiatan->kegiatan->masterKegiatan->kegiatan_urai,
                'capaian' => $rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_urai,
                'dasar_pelaksanaan' => $dasarPelaksanaan,
                'kendala' => $validated['kendala'],
                'solusi' => $validated['solusi'],
                'catatan' => $validated['catatan'],
                'bukti_dukung_ids' => $buktiDukungIds,
            ]);

            // Generate PDF
            $pdfPath = $this->pdfService->generateLaporanHarian($laporan);

            if (!$pdfPath) {
                throw new \Exception('Gagal generate PDF laporan harian');
            }

            // Upload PDF ke Google Drive
            $driveService = app(\App\Services\GoogleDriveService::class);
            $filename = $laporan->generateFilename();
            $driveId = $this->driveService->uploadFile(storage_path('app/' . $pdfPath), $filename);

            if (!$driveId) {
                throw new \Exception('Gagal mengupload PDF ke Google Drive');
            }

            // Update laporan with PDF info
            $laporan->update([
                'file_path' => 'google_drive', // Indicate stored in Google Drive
                'drive_id' => $driveId,
            ]);

            // Delete local temporary file
            if (Storage::exists($pdfPath)) {
                Storage::delete($pdfPath);
            }

            DB::commit();

            return redirect()->route('detailrinciankegiatan', $rincianKegiatan->id)
                ->with('success', 'Laporan harian berhasil dibuat dan PDF telah diupload ke Google Drive.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating laporan harian: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat laporan harian: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Download PDF laporan harian
     */
    public function download(LaporanHarian $laporan)
    {
        // Check if user can access this laporan
        if ($laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to laporan harian');
        }

        if (!$laporan->isPdfReady()) {
            return redirect()->back()->with('error', 'PDF belum siap untuk didownload.');
        }

        $filename = $laporan->generateFilename();

        // If stored in Google Drive
        if ($laporan->file_path === 'google_drive' && $laporan->drive_id) {
            try {
                $driveService = app(\App\Services\GoogleDriveService::class);
                $tempPath = storage_path('app/temp/laporan-harian/' . uniqid() . '_' . $laporan->id . '.pdf');
                $downloadedPath = $driveService->downloadFileContent($laporan->drive_id, $tempPath);

                if ($tempPath && file_exists($tempPath)) {
                    return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
                }
            } catch (\Exception $e) {
                Log::error('Error downloading from Google Drive: ' . $e->getMessage());
            }
        }

        // Fallback to local storage
        if (Storage::exists($laporan->file_path)) {
            return Storage::download($laporan->file_path, $filename);
        }

        return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
    }

    /**
     * Show laporan harian details
     */
    public function show(LaporanHarian $laporan)
    {
        // Check if user can access this laporan
        if ($laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to laporan harian');
        }

        $laporan->load([
            'user',
            'proyek.masterProyek',
            'rincianKegiatan.masterRincianKegiatan'
        ]);

        return view('laporan-harian.show', compact('laporan'));
    }

    /**
     * Delete laporan harian
     */
    public function destroy(LaporanHarian $laporan)
    {
        // Check if user can delete this laporan
        if ($laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to laporan harian');
        }

        try {
            // Delete PDF file from Google Drive or local storage
            if ($laporan->file_path === 'google_drive' && $laporan->drive_id) {
                try {
                    $this->driveService->deleteFile($laporan->drive_id);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete file from Google Drive: ' . $e->getMessage());
                }
            } elseif ($laporan->file_path && Storage::exists($laporan->file_path)) {
                Storage::delete($laporan->file_path);
            }

            $laporan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Laporan harian berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting laporan harian: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus laporan harian'
            ], 500);
        }
    }
}
