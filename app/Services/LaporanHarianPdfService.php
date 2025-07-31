<?php

namespace App\Services;

use App\Models\LaporanHarian;
use TCPDF;
use setasign\Fpdi\Fpdi;
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
                'proyek.masterProyek',
                'proyek.rkTim.tim.masterTim',
                'proyek.rkTim.masterRkTim',
                'rincianKegiatan.masterRincianKegiatan',
                'rincianKegiatan.kegiatan.masterKegiatan'
            ]);

            // Create main PDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            
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
            
            return $outputPath;
            
        } catch (\Exception $e) {
            Log::error('Error generating PDF laporan harian: ' . $e->getMessage());
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
        $pdf->Cell(0, 10, 'Laporan Harian Pelaksanaan Pekerjaan untuk Aplikasi KipApp', 0, 1, 'C');
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
        $pdf->Cell(0, 6, strtoupper($laporan->user->name), 1, 1, 'L');
        
        // NIP
        $pdf->Cell(40, 6, 'NIP Lama/Baru', 1, 0, 'L');
        $nipText = 'Lama: ' . ($laporan->user->nip_lama ?? '-') . '    Baru: ' . ($laporan->user->nip_baru ?? '-');
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
        $timKegiatan = $laporan->proyek->rkTim->tim->masterTim->tim_urai ?? '-';
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
        $pdf->SetFillColor(124, 212, 64);
        $pdf->Cell(0, 8, 'Pengesahan', 1, 1, 'C', true);
        
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetFillColor(255, 255, 255);
        
        // Three columns for signatures
        $colWidth = 60;
        
        // Headers
        $pdf->Cell($colWidth, 6, 'Pegawai yang Melaporkan,', 1, 0, 'C');
        $pdf->Cell($colWidth, 6, 'Mengetahui,', 1, 0, 'C');
        $pdf->Cell($colWidth, 6, 'Atasan Langsung Pegawai,', 1, 1, 'C');
        
        // Subtitle for middle column
        $pdf->Cell($colWidth, 6, '', 1, 0, 'C');
        $pdf->Cell($colWidth, 6, 'Ketua Tim Pelaksana Kegiatan', 1, 0, 'C');
        $pdf->Cell($colWidth, 6, '', 1, 1, 'C');
        
        // Empty space for signatures
        for ($i = 0; $i < 4; $i++) {
            $pdf->Cell($colWidth, 6, '', 1, 0, 'C');
            $pdf->Cell($colWidth, 6, '', 1, 0, 'C');
            $pdf->Cell($colWidth, 6, '', 1, 1, 'C');
        }
        
        // Names and NIPs (kosong sesuai requirement)
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell($colWidth, 6, strtoupper($laporan->user->name), 1, 0, 'C');
        $pdf->Cell($colWidth, 6, '', 1, 0, 'C'); // Kosong
        $pdf->Cell($colWidth, 6, '', 1, 1, 'C'); // Kosong
        
        $pdf->SetFont('helvetica', '', 8);
        $nipText = 'NIP. ' . ($laporan->user->nip_baru ?? $laporan->user->nip_lama ?? '-');
        $pdf->Cell($colWidth, 6, $nipText, 1, 0, 'C');
        $pdf->Cell($colWidth, 6, '', 1, 0, 'C'); // Kosong
        $pdf->Cell($colWidth, 6, '', 1, 1, 'C'); // Kosong
    }

    /**
     * Add bukti dukung pages
     */
    protected function addBuktiDukungPages(TCPDF $pdf, $buktiDukungs)
    {
        foreach ($buktiDukungs as $bukti) {
            if ($bukti->isImage() && $bukti->extension !== 'pdf') {
                $this->addImagePage($pdf, $bukti);
            } elseif ($bukti->extension === 'pdf') {
                $this->mergePdfFile($pdf, $bukti);
            }
        }
    }

    /**
     * Add image page to PDF
     */
    protected function addImagePage(TCPDF $pdf, $bukti)
    {
        try {
            // Download image from Google Drive if needed
            $imagePath = $this->downloadBuktiDukung($bukti);
            
            if (!$imagePath || !file_exists($imagePath)) {
                return;
            }

            $pdf->AddPage();
            
            // Add title
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Lampiran ' . $bukti->urutan_laporan . ': ' . $bukti->nama_file, 0, 1, 'C');
            $pdf->Ln(5);
            
            // Get image dimensions
            $imageSize = getimagesize($imagePath);
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
            }
            
            // Clean up temp file
            if (strpos($imagePath, $this->tempPath) === 0) {
                unlink($imagePath);
            }
            
        } catch (\Exception $e) {
            Log::error('Error adding image page: ' . $e->getMessage());
        }
    }

    /**
     * Merge PDF file
     */
    protected function mergePdfFile(TCPDF $pdf, $bukti)
    {
        try {
            // Download PDF from Google Drive if needed
            $pdfPath = $this->downloadBuktiDukung($bukti);
            
            if (!$pdfPath || !file_exists($pdfPath)) {
                return;
            }

            // Use FPDI to merge PDF
            $fpdi = new FPDI();
            $pageCount = $fpdi->setSourceFile($pdfPath);
            
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $pdf->AddPage();
                
                // Add title on first page
                if ($pageNo === 1) {
                    $pdf->SetFont('helvetica', 'B', 12);
                    $pdf->Cell(0, 10, 'Lampiran ' . $bukti->urutan_laporan . ': ' . $bukti->nama_file, 0, 1, 'C');
                    $pdf->Ln(5);
                }
                
                // Import page
                $templateId = $fpdi->importPage($pageNo);
                $size = $fpdi->getTemplateSize($templateId);
                
                // Calculate position
                $y = $pageNo === 1 ? $pdf->GetY() : 15;
                $fpdi->useTemplate($templateId, 15, $y, 180);
            }
            
            // Clean up temp file
            if (strpos($pdfPath, $this->tempPath) === 0) {
                unlink($pdfPath);
            }
            
        } catch (\Exception $e) {
            Log::error('Error merging PDF: ' . $e->getMessage());
        }
    }

    /**
     * Download bukti dukung file
     */
    protected function downloadBuktiDukung($bukti)
    {
        try {
            if (empty($bukti->drive_id)) {
                return null;
            }

            $tempFile = $this->tempPath . uniqid() . '.' . $bukti->extension;
            
            // Here you would implement Google Drive download
            // For now, return null if file doesn't exist locally
            if (Storage::exists('bukti-dukung/' . $bukti->drive_id)) {
                $content = Storage::get('bukti-dukung/' . $bukti->drive_id);
                file_put_contents($tempFile, $content);
                return $tempFile;
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Error downloading bukti dukung: ' . $e->getMessage());
            return null;
        }
    }
}