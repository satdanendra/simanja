<?php

namespace App\Services;

use App\Models\LaporanHarian;
use TCPDF;
use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LaporanHarianPdfService
{
    protected $tempPath;

    public function __construct()
    {
        $this->tempPath = storage_path('app/temp/laporan-harian/');

        // Create temp directory if not exists
        if (!file_exists($this->tempPath)) {
            mkdir($this->tempPath, 0755, true);
        }
    }

    /**
     * Generate PDF laporan harian
     */
    public function generateLaporanHarian(LaporanHarian $laporan)
    {
        try {
            // Load relationships
            $laporan->load([
                'user',
                'user.pegawai',
                'proyek.masterProyek',
                'proyek.rkTim.tim.masterTim',
                'proyek.rkTim.masterRkTim',
                'rincianKegiatan.masterRincianKegiatan',
                'rincianKegiatan.kegiatan.masterKegiatan'
            ]);

            // Create FPDI instance (extends TCPDF)
            $pdf = new Fpdi('P', 'mm', 'A4', true, 'UTF-8', false);

            // Set document information
            $pdf->SetCreator('SiManja - BPS Kota Magelang');
            $pdf->SetAuthor($laporan->user->name);
            $pdf->SetTitle('Laporan Harian Pelaksanaan Pekerjaan');

            // Remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Set margins
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetAutoPageBreak(true, 15);

            // Add main page
            $pdf->AddPage();

            // Add main content
            $this->addMainContent($pdf, $laporan);

            // Get bukti dukung
            $buktiDukungs = $laporan->getBuktiDukungs();

            Log::info("Processing " . $buktiDukungs->count() . " bukti dukung for laporan " . $laporan->id);

            if ($buktiDukungs->count() > 0) {
                $this->addBuktiDukungPages($pdf, $buktiDukungs);
            }

            // Save PDF
            $filename = $laporan->generateFilename();
            $outputPath = 'laporan-harian/' . date('Y/m/') . $filename;
            $fullPath = storage_path('app/' . $outputPath);

            // Create directory if not exists
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $pdf->Output($fullPath, 'F');

            Log::info("PDF generated successfully: " . $outputPath);

            return $outputPath;
        } catch (\Exception $e) {
            Log::error('Error generating PDF laporan harian: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Add main content to PDF
     */
    protected function addMainContent(TCPDF $pdf, LaporanHarian $laporan)
    {
        // Header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Laporan Harian Pelaksanaan Pekerjaan', 0, 1, 'C');
        $pdf->Ln(5);

        // Identitas Pegawai Section
        $this->addIdentitasPegawai($pdf, $laporan);
        $pdf->Ln(5);

        // Rencana Kerja dan Kegiatan Section
        $this->addRencanaKerja($pdf, $laporan);
        $pdf->Ln(5);

        // Dasar Pelaksanaan Section
        $this->addDasarPelaksanaan($pdf, $laporan);
        $pdf->Ln(5);

        // Bukti Pelaksanaan Section
        $this->addBuktiPelaksanaan($pdf, $laporan);
        $pdf->Ln(5);

        // Kendala dan Solusi Section
        $this->addKendalaSolusi($pdf, $laporan);
        $pdf->Ln(5);

        // Catatan Section
        $this->addCatatan($pdf, $laporan);
        $pdf->Ln(5);

        // Pengesahan Section
        $this->addPengesahan($pdf, $laporan);
    }

    protected function addIdentitasPegawai(TCPDF $pdf, LaporanHarian $laporan)
    {
        // Header section
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(124, 212, 64); // Green background
        $pdf->Cell(0, 8, 'Identitas Pegawai', 1, 1, 'L', true);

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetFillColor(255, 255, 255);

        // Nama Pegawai
        $pdf->Cell(40, 6, 'Nama Pegawai', 1, 0, 'L');
        $pdf->Cell(0, 6, strtoupper($laporan->user->pegawai->nama), 1, 1, 'L');

        // NIP
        $pdf->Cell(40, 6, 'NIP Lama/Baru', 1, 0, 'L');
        $nipText = 'Lama: ' . ($laporan->user->pegawai->nip_lama ?? '-') . '    Baru: ' . ($laporan->user->pegawai->nip_baru ?? '-');
        $pdf->Cell(0, 6, $nipText, 1, 1, 'L');

        // Satker
        $pdf->Cell(40, 6, 'Satker', 1, 0, 'L');
        $pdf->Cell(0, 6, 'BPS Kota Magelang', 1, 1, 'L');
    }

    protected function addRencanaKerja(TCPDF $pdf, LaporanHarian $laporan)
    {
        // Header section
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(124, 212, 64);
        $pdf->Cell(0, 8, 'Rencana Kerja dan Kegiatan', 1, 1, 'L', true);

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetFillColor(255, 255, 255);

        // Tim Kegiatan
        $pdf->Cell(40, 6, 'Tim Kegiatan', 1, 0, 'L');
        $timKegiatan = $laporan->proyek->rkTim->tim->masterTim->tim_nama ?? '-';
        $pdf->Cell(0, 6, $timKegiatan, 1, 1, 'L');

        // Rencana Kerja Ketua
        $pdf->Cell(40, 6, 'Rencana Kerja Ketua', 1, 0, 'L');
        $rkKetua = $laporan->proyek->rkTim->masterRkTim->rk_tim_urai ?? '-';
        $pdf->Cell(0, 6, $rkKetua, 1, 1, 'L');

        // Proyek
        $pdf->Cell(40, 6, 'Proyek', 1, 0, 'L');
        $proyek = $laporan->proyek->masterProyek->proyek_urai ?? '-';
        $pdf->Cell(0, 6, $proyek, 1, 1, 'L');

        // Rencana Kerja Anggota
        $pdf->Cell(40, 6, 'Rencana Kerja Anggota', 1, 0, 'L');
        $rkAnggota = $laporan->rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_urai ?? '-';
        $pdf->Cell(0, 6, $rkAnggota, 1, 1, 'L');

        // IKI Anggota
        $pdf->Cell(40, 6, 'IKI Anggota', 1, 0, 'L');
        $iki = $laporan->rincianKegiatan->masterRincianKegiatan->rincian_kegiatan_satuan ?? '-';
        $pdf->Cell(0, 6, $iki, 1, 1, 'L');

        // Waktu
        $pdf->Cell(40, 6, 'Waktu', 1, 0, 'L');
        $waktuText = 'Hari/Tanggal: ' . $laporan->formatted_tanggal . '    Jam: ' . $laporan->formatted_waktu;
        $pdf->Cell(0, 6, $waktuText, 1, 1, 'L');

        // Kegiatan
        $pdf->Cell(40, 6, 'Kegiatan', 1, 0, 'L');
        $pdf->Cell(0, 6, $laporan->kegiatan_deskripsi, 1, 1, 'L');

        // Capaian
        $pdf->Cell(40, 6, 'Capaian', 1, 0, 'L');
        $pdf->Cell(0, 6, $laporan->capaian, 1, 1, 'L');
    }

    protected function addDasarPelaksanaan(TCPDF $pdf, LaporanHarian $laporan)
    {
        // Header section
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(124, 212, 64);
        $pdf->Cell(0, 8, 'Dasar Pelaksanaan Kegiatan', 1, 1, 'L', true);

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetFillColor(255, 255, 255);

        if (!empty($laporan->dasar_pelaksanaan)) {
            foreach ($laporan->dasar_pelaksanaan as $dasar) {
                $text = $dasar['nomor'] . '. ' . $dasar['deskripsi'];
                if ($dasar['is_terlampir']) {
                    $text .= ' (terlampir)';
                }
                $pdf->Cell(0, 6, $text, 1, 1, 'L');
            }
        } else {
            $pdf->Cell(0, 6, '1. -', 1, 1, 'L');
        }
    }

    protected function addBuktiPelaksanaan(TCPDF $pdf, LaporanHarian $laporan)
    {
        // Header section
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(124, 212, 64);
        $pdf->Cell(0, 8, 'Bukti Pelaksanaan Pekerjaan (Foto/Dokumentasi/Screenshot/Print Screen, dll)', 1, 1, 'L', true);

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetFillColor(255, 255, 255);

        $buktiDukungs = $laporan->getBuktiDukungs();

        if ($buktiDukungs->count() > 0) {
            foreach ($buktiDukungs as $bukti) {
                $text = $bukti->urutan_laporan . '. ' . $bukti->nama_file . ' (terlampir)';
                if ($bukti->keterangan) {
                    $text .= ' - ' . $bukti->keterangan;
                }
                $pdf->Cell(0, 6, $text, 1, 1, 'L');
            }
        } else {
            $pdf->Cell(0, 6, '1. (terlampir)', 1, 1, 'L');
        }
    }

    protected function addKendalaSolusi(TCPDF $pdf, LaporanHarian $laporan)
    {
        // Header section
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(124, 212, 64);
        $pdf->Cell(0, 8, 'Kendala dan Solusi', 1, 1, 'L', true);

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetFillColor(255, 255, 255);

        // Header row
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(90, 6, 'Kendala/Permasalahan', 1, 0, 'C');
        $pdf->Cell(80, 6, 'Solusi', 1, 1, 'C');

        // Content
        $pdf->Cell(10, 6, '1.', 1, 0, 'C');
        $pdf->Cell(90, 6, $laporan->kendala ?? '-', 1, 0, 'L');
        $pdf->Cell(80, 6, $laporan->solusi ?? '-', 1, 1, 'L');
    }

    protected function addCatatan(TCPDF $pdf, LaporanHarian $laporan)
    {
        // Header section
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(124, 212, 64);
        $pdf->Cell(0, 8, 'Catatan', 1, 1, 'L', true);

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->Cell(10, 6, '1.', 1, 0, 'L');
        $pdf->Cell(0, 6, $laporan->catatan ?? '', 1, 1, 'L');
    }

    protected function addPengesahan(TCPDF $pdf, LaporanHarian $laporan)
    {
        // Header section
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetDrawColor(255, 255, 255);
        $pdf->SetFillColor(124, 212, 64);
        $pdf->Cell(0, 8, 'Pengesahan', 1, 1, 'C', true);

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetFillColor(255, 255, 255);

        // Three columns for signatures
        $colWidth = 60;

        // Headers
        $pdf->Cell($colWidth, 6, '', 1, 0, 'C');
        $pdf->Cell($colWidth, 6, 'Mengetahui,', 1, 0, 'C');
        $pdf->Cell($colWidth, 6, '', 1, 1, 'C');

        // Subtitle for middle column
        $pdf->Cell($colWidth, 6, 'Pegawai yang Melaporkan,', 1, 0, 'C');
        $pdf->Cell($colWidth, 6, 'Ketua Tim Pelaksana Kegiatan', 1, 0, 'C');
        $pdf->Cell($colWidth, 6, 'Atasan Langsung Pegawai,', 1, 1, 'C');

        // Empty space for signatures
        for ($i = 0; $i < 4; $i++) {
            $pdf->Cell($colWidth, 6, '', 1, 0, 'C');
            $pdf->Cell($colWidth, 6, '', 1, 0, 'C');
            $pdf->Cell($colWidth, 6, '', 1, 1, 'C');
        }

        // Names and NIPs (kosong sesuai requirement)
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell($colWidth, 6, strtoupper($laporan->user->pegawai->nama), 1, 0, 'C');
        $pdf->Cell($colWidth, 6, strtoupper($laporan->proyek->rkTim->tim->ketuaTim->pegawai->nama), 1, 0, 'C'); // Kosong
        $pdf->Cell($colWidth, 6, 'ALUISIUS ABRIANTA', 1, 1, 'C'); // Kosong

        $pdf->SetFont('helvetica', '', 8);
        $nipText = 'NIP. ' . ($laporan->user->pegawai->nip_baru ?? '-');
        $pdf->Cell($colWidth, 6, $nipText, 1, 0, 'C');
        $pdf->Cell($colWidth, 6, 'NIP. ' . $laporan->proyek->rkTim->tim->ketuaTim->pegawai->nip_baru ?? '-', 1, 0, 'C'); // Kosong
        $pdf->Cell($colWidth, 6, 'NIP. 19791005 200212 1003', 1, 1, 'C'); // Kosong
    }

    /**
     * Add bukti dukung pages
     */
    protected function addBuktiDukungPages(Fpdi $pdf, $buktiDukungs)
    {
        foreach ($buktiDukungs as $bukti) {
            Log::info("Processing bukti dukung: {$bukti->id}, extension: {$bukti->extension}");

            try {
                if ($bukti->isImage() && strtolower($bukti->extension) !== 'pdf') {
                    $this->addImagePage($pdf, $bukti);
                } elseif (strtolower($bukti->extension) === 'pdf') {
                    $this->mergePdfFile($pdf, $bukti);
                } else {
                    $this->addFileInfoPage($pdf, $bukti);
                }
            } catch (\Exception $e) {
                Log::error("Error processing bukti dukung {$bukti->id}: " . $e->getMessage());
                $this->addErrorPage($pdf, $bukti, $e->getMessage());
            }
        }
    }

    /**
     * Add image page to PDF
     */
    protected function addImagePage(Fpdi $pdf, $bukti)
    {
        try {
            // Download image
            $imagePath = $this->downloadBuktiDukung($bukti);

            if (!$imagePath || !file_exists($imagePath)) {
                Log::warning("Image file not found for bukti dukung: {$bukti->id}");
                $this->addFileInfoPage($pdf, $bukti);
                return;
            }

            $pdf->AddPage();

            // Add title
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Lampiran ' . $bukti->urutan_laporan . ': ' . $bukti->nama_file, 0, 1, 'C');
            $pdf->Ln(5);

            // Get image dimensions
            $imageSize = @getimagesize($imagePath);
            if ($imageSize) {
                $imgWidth = $imageSize[0];
                $imgHeight = $imageSize[1];

                // Calculate dimensions to fit page
                $maxWidth = 180; // mm
                $maxHeight = 240; // mm

                $ratio = min($maxWidth / ($imgWidth * 0.264583), $maxHeight / ($imgHeight * 0.264583));
                $finalWidth = $imgWidth * 0.264583 * $ratio;
                $finalHeight = $imgHeight * 0.264583 * $ratio;

                // Center the image
                $x = (210 - $finalWidth) / 2;
                $y = $pdf->GetY();

                $pdf->Image($imagePath, $x, $y, $finalWidth, $finalHeight);

                Log::info("Added image with size ({$finalWidth}, {$finalHeight})");
            } else {
                $pdf->SetFont('helvetica', '', 10);
                $pdf->Cell(0, 10, 'Error: Tidak dapat memproses gambar ini.', 0, 1, 'C');
            }

            // Clean up temp file
            if (strpos($imagePath, $this->tempPath) === 0 && file_exists($imagePath)) {
                unlink($imagePath);
            }
        } catch (\Exception $e) {
            Log::error('Error adding image page: ' . $e->getMessage());
            $this->addErrorPage($pdf, $bukti, $e->getMessage());
        }
    }

    /**
     * Merge PDF file - PERBAIKAN
     */
    protected function mergePdfFile(Fpdi $pdf, $bukti)
    {
        try {
            // Download PDF from Google Drive
            $pdfPath = $this->downloadBuktiDukung($bukti);

            if (!$pdfPath || !file_exists($pdfPath)) {
                Log::warning("PDF file not found for bukti dukung: {$bukti->id}");
                $this->addFileInfoPage($pdf, $bukti);
                return;
            }

            Log::info("Merging PDF: " . $pdfPath);

            // Set source file
            $pageCount = $pdf->setSourceFile($pdfPath);

            Log::info("PDF has {$pageCount} pages");

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // Add new page
                $pdf->AddPage();

                // Add title on first page
                if ($pageNo === 1) {
                    $pdf->SetFont('helvetica', 'B', 12);
                    $pdf->Cell(0, 10, 'Lampiran ' . $bukti->urutan_laporan, 0, 1,);
                    $pdf->Ln(5);
                }

                // Import page
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                // Calculate scaling
                $maxWidth = 180;
                $maxHeight = $pageNo === 1 ? 240 : 270;

                $scaleX = $maxWidth / $size['width'];
                $scaleY = $maxHeight / $size['height'];
                $scale = min($scaleX, $scaleY);

                $scaledWidth = $size['width'] * $scale;
                $scaledHeight = $size['height'] * $scale;

                // Center the page
                $x = (210 - $scaledWidth) / 2;
                $y = $pageNo === 1 ? $pdf->GetY() : 15;

                // Use template - FPDI method
                $pdf->useTemplate($templateId, $x, $y, $scaledWidth, $scaledHeight);

                Log::info("Added page {$pageNo} at position ({$x}, {$y}) with size ({$scaledWidth}, {$scaledHeight})");
            }

            // Clean up temp file
            if (strpos($pdfPath, $this->tempPath) === 0 && file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        } catch (\Exception $e) {
            Log::error('Error merging PDF: ' . $e->getMessage());
            $this->addErrorPage($pdf, $bukti, $e->getMessage());
        }
    }

    /**
     * Add file info page for unsupported files
     */
    protected function addFileInfoPage(Fpdi $pdf, $bukti)
    {
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Lampiran ' . $bukti->urutan_laporan . ': ' . $bukti->nama_file, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, 'File tersedia untuk diunduh terpisah.', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Tipe: ' . strtoupper($bukti->extension), 0, 1, 'C');
        if ($bukti->keterangan) {
            $pdf->Cell(0, 10, 'Keterangan: ' . $bukti->keterangan, 0, 1, 'C');
        }
    }

    /**
     * Add error page
     */
    protected function addErrorPage(Fpdi $pdf, $bukti, $errorMessage)
    {
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Lampiran ' . $bukti->urutan_laporan . ': ' . $bukti->nama_file, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, 'Error: Tidak dapat memproses file ini.', 0, 1, 'C');
        $pdf->MultiCell(0, 5, 'Detail: ' . $errorMessage, 0, 'C');
    }

    /**
     * Download bukti dukung file
     */
    protected function downloadBuktiDukung($bukti)
    {
        try {
            Log::info("Downloading bukti dukung:", [
                'id' => $bukti->id,
                'nama_file' => $bukti->nama_file,
                'extension' => $bukti->extension,
                'drive_id' => $bukti->drive_id,
                'file_path' => $bukti->file_path
            ]);

            if (empty($bukti->drive_id)) {
                Log::warning("No drive_id for bukti dukung: {$bukti->id}");
                return null;
            }

            $tempFile = $this->tempPath . uniqid() . '_' . $bukti->id . '.' . $bukti->extension;

            // Method 1: Coba download dari Google Drive
            if ($bukti->file_path === 'google_drive' && !empty($bukti->drive_id)) {
                try {
                    $driveService = app(\App\Services\GoogleDriveService::class);
                    $downloadPath = $driveService->downloadFileContent($bukti->drive_id, $tempFile);

                    if ($downloadPath && file_exists($downloadPath)) {
                        Log::info("Downloaded from Google Drive: {$downloadPath}");
                        return $downloadPath;
                    }
                } catch (\Exception $e) {
                    Log::warning("Google Drive download failed: " . $e->getMessage());
                }
            }

            // Method 2: Coba dari local storage berdasarkan drive_id
            $possiblePaths = [
                storage_path('app/bukti-dukung/' . $bukti->drive_id),
                storage_path('app/bukti-dukung/' . $bukti->drive_id . '.' . $bukti->extension),
                storage_path('app/public/bukti-dukung/' . $bukti->drive_id),
                storage_path('app/public/bukti-dukung/' . $bukti->drive_id . '.' . $bukti->extension),
            ];

            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    copy($path, $tempFile);
                    Log::info("Found local file at: {$path}");
                    return $tempFile;
                }
            }

            // Method 3: Coba dari Laravel Storage
            $storagePaths = [
                'bukti-dukung/' . $bukti->drive_id,
                'bukti-dukung/' . $bukti->drive_id . '.' . $bukti->extension,
                'public/bukti-dukung/' . $bukti->drive_id,
                'public/bukti-dukung/' . $bukti->drive_id . '.' . $bukti->extension,
            ];

            foreach ($storagePaths as $storagePath) {
                if (Storage::exists($storagePath)) {
                    $content = Storage::get($storagePath);
                    file_put_contents($tempFile, $content);
                    Log::info("Found storage file at: {$storagePath}");
                    return $tempFile;
                }
            }

            // Method 4: Coba berdasarkan original file_path (jika bukan google_drive)
            if ($bukti->file_path !== 'google_drive' && !empty($bukti->file_path)) {
                if (Storage::exists($bukti->file_path)) {
                    $content = Storage::get($bukti->file_path);
                    file_put_contents($tempFile, $content);
                    Log::info("Found file at original path: {$bukti->file_path}");
                    return $tempFile;
                }

                $fullPath = storage_path('app/' . $bukti->file_path);
                if (file_exists($fullPath)) {
                    copy($fullPath, $tempFile);
                    Log::info("Found file at full path: {$fullPath}");
                    return $tempFile;
                }
            }
        } catch (\Exception $e) {
            Log::error('Error downloading bukti dukung: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return null;
        }
    }
}
