<?php

namespace App\Http\Controllers;

use App\Models\Iku;
use App\Models\Sasaran;
use App\Models\Tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class IkuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ikus = Iku::with('sasaran.tujuan')->get();
        return view('iku', compact('ikus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'iku_kode' => 'required|string|max:255',
            'iku_urai' => 'required|string',
            'iku_satuan' => 'required|string|max:255',
            'iku_target' => 'required|string|max:255',
            'sasaran_id' => 'required|exists:sasaran,id',
        ]);

        Iku::create($validated);

        return redirect()->route('iku')
            ->with('success', 'IKU berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Iku $iku)
    {
        return response()->json($iku);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Iku $iku)
    {
        $validated = $request->validate([
            'iku_kode' => 'required|string|max:255',
            'iku_urai' => 'required|string',
            'iku_satuan' => 'required|string|max:255',
            'iku_target' => 'required|string|max:255',
            'sasaran_id' => 'required|exists:sasaran,id',
        ]);

        $iku->update($validated);

        return redirect()->route('iku')
            ->with('success', 'IKU berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Iku $iku)
    {
        $iku->delete();

        return response()->json([
            'success' => true,
            'message' => 'IKU berhasil dihapus'
        ]);
    }

    /**
     * Import IKU data from Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xls,xlsx|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        // Detect file type and read data
        $reader = IOFactory::createReaderForFile($path);
        $spreadsheet = $reader->load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        
        $rows = $worksheet->toArray();
        
        // Skip the header row
        array_shift($rows);
        
        $successCount = 0;
        $errorCount = 0;
        $errors = [];
        $results = [];
        
        // Group data by tujuan and sasaran for normalized structure
        $groupedData = [];
        
        // First pass: Group rows by tujuan and sasaran
        foreach ($rows as $rowIndex => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }
            
            // Example mapping based on Excel structure
            // Assuming columns are in order: tujuan_kode, tujuan_urai, sasaran_kode, sasaran_urai, iku_kode, iku_urai, iku_satuan, iku_target
            $rowNum = $rowIndex + 2; // +2 because we skip header and arrays are 0-indexed
            
            try {
                $tujuanKode = trim($row[0] ?? '');
                $tujuanUrai = trim($row[1] ?? '');
                $sasaranKode = trim($row[2] ?? '');
                $sasaranUrai = trim($row[3] ?? '');
                $ikuKode = trim($row[4] ?? '');
                $ikuUrai = trim($row[5] ?? '');
                $ikuSatuan = trim($row[6] ?? '');
                $ikuTarget = trim($row[7] ?? '');
                
                // Validate required fields
                if (empty($tujuanKode) || empty($tujuanUrai)) {
                    throw new \Exception('Kode Tujuan dan Uraian Tujuan wajib diisi');
                }
                
                if (empty($sasaranKode) || empty($sasaranUrai)) {
                    throw new \Exception('Kode Sasaran dan Uraian Sasaran wajib diisi');
                }
                
                if (empty($ikuKode) || empty($ikuUrai)) {
                    throw new \Exception('Kode IKU dan Uraian IKU wajib diisi');
                }
                
                if (empty($ikuSatuan)) {
                    throw new \Exception('Satuan IKU wajib diisi');
                }
                
                if (empty($ikuTarget)) {
                    throw new \Exception('Target IKU wajib diisi');
                }
                
                // Group by tujuan and sasaran
                if (!isset($groupedData[$tujuanKode])) {
                    $groupedData[$tujuanKode] = [
                        'tujuan_kode' => $tujuanKode,
                        'tujuan_urai' => $tujuanUrai,
                        'sasaran' => []
                    ];
                }
                
                if (!isset($groupedData[$tujuanKode]['sasaran'][$sasaranKode])) {
                    $groupedData[$tujuanKode]['sasaran'][$sasaranKode] = [
                        'sasaran_kode' => $sasaranKode,
                        'sasaran_urai' => $sasaranUrai,
                        'iku' => []
                    ];
                }
                
                $groupedData[$tujuanKode]['sasaran'][$sasaranKode]['iku'][] = [
                    'iku_kode' => $ikuKode,
                    'iku_urai' => $ikuUrai,
                    'iku_satuan' => $ikuSatuan,
                    'iku_target' => $ikuTarget,
                    'row' => $rowNum
                ];
                
            } catch (\Exception $e) {
                $errorCount++;
                $errors[] = "Baris {$rowNum}: " . $e->getMessage();
                $results[] = [
                    'row' => $rowNum,
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'data' => $row
                ];
            }
        }
        
        // Second pass: Insert data into database with proper relationships
        DB::beginTransaction();
        
        try {
            foreach ($groupedData as $tujuanData) {
                // Find or create tujuan
                $tujuan = Tujuan::firstOrCreate(
                    ['tujuan_kode' => $tujuanData['tujuan_kode']],
                    ['tujuan_urai' => $tujuanData['tujuan_urai']]
                );
                
                foreach ($tujuanData['sasaran'] as $sasaranData) {
                    // Find or create sasaran
                    $sasaran = Sasaran::firstOrCreate(
                        [
                            'tujuan_id' => $tujuan->id,
                            'sasaran_kode' => $sasaranData['sasaran_kode']
                        ],
                        ['sasaran_urai' => $sasaranData['sasaran_urai']]
                    );
                    
                    foreach ($sasaranData['iku'] as $ikuData) {
                        // Find or create iku
                        $iku = Iku::firstOrCreate(
                            [
                                'sasaran_id' => $sasaran->id,
                                'iku_kode' => $ikuData['iku_kode']
                            ],
                            [
                                'iku_urai' => $ikuData['iku_urai'],
                                'iku_satuan' => $ikuData['iku_satuan'],
                                'iku_target' => $ikuData['iku_target']
                            ]
                        );
                        
                        $successCount++;
                        $results[] = [
                            'row' => $ikuData['row'],
                            'status' => $iku->wasRecentlyCreated ? 'created' : 'updated',
                            'message' => $iku->wasRecentlyCreated ? 'Data berhasil ditambahkan' : 'Data berhasil diperbarui',
                            'data' => [
                                'tujuan_kode' => $tujuanData['tujuan_kode'],
                                'tujuan_urai' => $tujuanData['tujuan_urai'],
                                'sasaran_kode' => $sasaranData['sasaran_kode'],
                                'sasaran_urai' => $sasaranData['sasaran_urai'],
                                'iku_kode' => $ikuData['iku_kode'],
                                'iku_urai' => $ikuData['iku_urai']
                            ]
                        ];
                    }
                }
            }
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error importing IKU data: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage()
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'successCount' => $successCount,
            'errorCount' => $errorCount,
            'errors' => $errors,
            'results' => $results
        ]);
    }

    /**
     * Download IKU import template.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $headers = [
            'Kode Tujuan',
            'Uraian Tujuan',
            'Kode Sasaran',
            'Uraian Sasaran',
            'Kode IKU',
            'Uraian IKU',
            'Satuan IKU',
            'Target IKU'
        ];
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, ...
            $sheet->setCellValue($column . '1', $header);
            
            // Styling header
            $sheet->getStyle($column . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Add sample data
        $sampleData = [
            'T1',
            'Meningkatkan kualitas pelayanan publik',
            'S1.1',
            'Meningkatkan kepuasan pengguna data',
            'IKU-1.1',
            'Persentase Kepuasan Pengguna Data',
            'Persen',
            '85'
        ];
        
        foreach ($sampleData as $index => $value) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '2', $value);
        }
        
        // Add second sample with same tujuan & sasaran but different IKU
        $sampleData2 = [
            'T1',
            'Meningkatkan kualitas pelayanan publik',
            'S1.1',
            'Meningkatkan kepuasan pengguna data',
            'IKU-1.2',
            'Tingkat Ketersediaan Data Publik',
            'Persen',
            '90'
        ];
        
        foreach ($sampleData2 as $index => $value) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '3', $value);
        }
        
        // Add third sample with same tujuan but different sasaran & IKU
        $sampleData3 = [
            'T1',
            'Meningkatkan kualitas pelayanan publik',
            'S1.2',
            'Meningkatkan kualitas data',
            'IKU-2.1',
            'Persentase Akurasi Data',
            'Persen',
            '95'
        ];
        
        foreach ($sampleData3 as $index => $value) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '4', $value);
        }
        
        // Add fourth sample with different tujuan, sasaran & IKU
        $sampleData4 = [
            'T2',
            'Meningkatkan kualitas sumber daya manusia',
            'S2.1',
            'Meningkatkan kompetensi pegawai',
            'IKU-3.1',
            'Rata-rata Nilai Kompetensi Pegawai',
            'Nilai',
            '85'
        ];
        
        foreach ($sampleData4 as $index => $value) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '5', $value);
        }
        
        // Create instructions sheet
        $instructionSheet = $spreadsheet->createSheet();
        $instructionSheet->setTitle('Petunjuk');
        $instructionSheet->setCellValue('A1', 'Petunjuk Pengisian Template Import IKU');
        $instructionSheet->setCellValue('A3', 'Informasi Struktur Data:');
        $instructionSheet->setCellValue('A4', '- Satu Tujuan dapat memiliki banyak Sasaran');
        $instructionSheet->setCellValue('A5', '- Satu Sasaran dapat memiliki banyak IKU');
        $instructionSheet->setCellValue('A6', '- Tujuan dengan kode yang sama namun uraian berbeda akan diupdate dengan uraian terbaru');
        $instructionSheet->setCellValue('A7', '- Sasaran dengan kode yang sama dalam satu Tujuan namun uraian berbeda akan diupdate dengan uraian terbaru');
        $instructionSheet->setCellValue('A8', '- IKU dengan kode yang sama dalam satu Sasaran namun detail berbeda akan diupdate dengan detail terbaru');
        
        $instructionSheet->setCellValue('A10', 'Kolom yang wajib diisi:');
        $instructionSheet->setCellValue('A11', '- Kode Tujuan: Kode unik untuk Tujuan');
        $instructionSheet->setCellValue('A12', '- Uraian Tujuan: Penjelasan lengkap Tujuan');
        $instructionSheet->setCellValue('A13', '- Kode Sasaran: Kode unik untuk Sasaran dalam satu Tujuan');
        $instructionSheet->setCellValue('A14', '- Uraian Sasaran: Penjelasan lengkap Sasaran');
        $instructionSheet->setCellValue('A15', '- Kode IKU: Kode unik untuk IKU dalam satu Sasaran');
        $instructionSheet->setCellValue('A16', '- Uraian IKU: Penjelasan lengkap IKU');
        $instructionSheet->setCellValue('A17', '- Satuan IKU: Satuan pengukuran IKU (mis: Persen, Nilai, Jumlah, dll)');
        $instructionSheet->setCellValue('A18', '- Target IKU: Target pencapaian IKU');
        
        $instructionSheet->setCellValue('A20', 'Contoh Pengisian:');
        $instructionSheet->setCellValue('A21', '1. Untuk memasukkan Tujuan, Sasaran dan IKU baru, isi semua kolom.');
        $instructionSheet->setCellValue('A22', '2. Untuk memasukkan IKU baru pada Sasaran yang sudah ada, pastikan kode dan uraian Tujuan serta Sasaran sama persis dengan data yang sudah ada.');
        $instructionSheet->setCellValue('A23', '3. Untuk memasukkan Sasaran baru pada Tujuan yang sudah ada, pastikan kode dan uraian Tujuan sama persis dengan data yang sudah ada.');
        
        $instructionSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $instructionSheet->getStyle('A3')->getFont()->setBold(true);
        $instructionSheet->getStyle('A10')->getFont()->setBold(true);
        $instructionSheet->getStyle('A20')->getFont()->setBold(true);
        
        // Set column widths
        $instructionSheet->getColumnDimension('A')->setWidth(50);
        
        // Set active sheet back to first sheet
        $spreadsheet->setActiveSheetIndex(0);
        
        // Create directory if not exists
        if (!file_exists(storage_path('app/public/templates'))) {
            mkdir(storage_path('app/public/templates'), 0755, true);
        }
        
        // Save to file
        $path = storage_path('app/public/templates/template_import_iku.xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);
        
        return response()->download($path);
    }
    
    /**
     * Delete multiple IKUs at once.
     */
    public function batchDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:iku,id'
        ]);
        
        Iku::whereIn('id', $validated['ids'])->delete();
        
        return response()->json([
            'success' => true,
            'message' => count($validated['ids']) . ' IKU berhasil dihapus'
        ]);
    }
}