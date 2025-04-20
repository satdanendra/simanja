<?php

namespace App\Http\Controllers;

use App\Models\MasterTim;
use App\Models\MasterRkTim;
use App\Models\MasterProyek;
use App\Models\MasterKegiatan;
use App\Models\MasterRincianKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MasterRincianKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rincianKegiatans = MasterRincianKegiatan::with(['kegiatan.proyek.rkTim.tim'])->get();
        return view('masterrinciankegiatan', compact('rincianKegiatans'));
    }

    /**
     * Import master rincian kegiatan data from Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:2048',
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

        // Group data for normalized structure
        $groupedData = [];

        // First pass: Group rows by hierarchical structure
        foreach ($rows as $rowIndex => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $rowNum = $rowIndex + 2; // +2 because we skip header and arrays are 0-indexed

            try {
                // Extract data from columns
                // Adjust column indexes based on your Excel structure
                $timKode = trim($row[0] ?? '');
                $timNama = trim($row[1] ?? '');
                $rkTimKode = trim($row[2] ?? '');
                $rkTimUrai = trim($row[3] ?? '');
                $ikuKode = trim($row[4] ?? '');
                $ikuUrai = trim($row[5] ?? '');
                $proyekKode = trim($row[6] ?? '');
                $proyekUrai = trim($row[7] ?? '');
                $rkAnggota = trim($row[8] ?? '');
                $proyekLapangan = trim($row[9] ?? '');
                $iki = trim($row[10] ?? '');
                $kegiatanKode = trim($row[11] ?? '');
                $kegiatanUrai = trim($row[12] ?? '');
                $rincianKegiatanKode = trim($row[13] ?? '');
                $rincianKegiatanUrai = trim($row[14] ?? '');
                $catatan = trim($row[15] ?? '');
                $rincianKegiatanSatuan = trim($row[16] ?? '');

                // Validate required fields
                if (empty($timKode) || empty($timNama)) {
                    throw new \Exception('Kode Tim dan Nama Tim wajib diisi');
                }

                if (empty($rkTimKode) || empty($rkTimUrai)) {
                    throw new \Exception('Kode RK Tim dan Uraian RK Tim wajib diisi');
                }

                if (empty($proyekKode) || empty($proyekUrai)) {
                    throw new \Exception('Kode Proyek dan Uraian Proyek wajib diisi');
                }

                if (empty($kegiatanKode) || empty($kegiatanUrai)) {
                    throw new \Exception('Kode Kegiatan dan Uraian Kegiatan wajib diisi');
                }

                if (empty($rincianKegiatanKode) || empty($rincianKegiatanUrai)) {
                    throw new \Exception('Kode Rincian Kegiatan dan Uraian Rincian Kegiatan wajib diisi');
                }

                // Group by hierarchical structure (Tim > RK Tim > Proyek > Kegiatan > Rincian Kegiatan)
                if (!isset($groupedData[$timKode])) {
                    $groupedData[$timKode] = [
                        'tim_kode' => $timKode,
                        'tim_nama' => $timNama,
                        'rk_tims' => []
                    ];
                }

                // Unique key for RK Tim within a Tim
                $rkTimKey = $timKode . '|' . $rkTimKode;
                if (!isset($groupedData[$timKode]['rk_tims'][$rkTimKey])) {
                    $groupedData[$timKode]['rk_tims'][$rkTimKey] = [
                        'rk_tim_kode' => $rkTimKode,
                        'rk_tim_urai' => $rkTimUrai,
                        'proyeks' => []
                    ];
                }

                // Unique key for Proyek within an RK Tim
                $proyekKey = $rkTimKey . '|' . $proyekKode;
                if (!isset($groupedData[$timKode]['rk_tims'][$rkTimKey]['proyeks'][$proyekKey])) {
                    $groupedData[$timKode]['rk_tims'][$rkTimKey]['proyeks'][$proyekKey] = [
                        'iku_kode' => $ikuKode,
                        'iku_urai' => $ikuUrai,
                        'proyek_kode' => $proyekKode,
                        'proyek_urai' => $proyekUrai,
                        'rk_anggota' => $rkAnggota,
                        'proyek_lapangan' => $proyekLapangan,
                        'kegiatans' => []
                    ];
                }

                // Unique key for Kegiatan within a Proyek
                $kegiatanKey = $proyekKey . '|' . $kegiatanKode;
                if (!isset($groupedData[$timKode]['rk_tims'][$rkTimKey]['proyeks'][$proyekKey]['kegiatans'][$kegiatanKey])) {
                    $groupedData[$timKode]['rk_tims'][$rkTimKey]['proyeks'][$proyekKey]['kegiatans'][$kegiatanKey] = [
                        'iki' => $iki,
                        'kegiatan_kode' => $kegiatanKode,
                        'kegiatan_urai' => $kegiatanUrai,
                        'rincian_kegiatans' => []
                    ];
                }

                // Unique key for Rincian Kegiatan within a Kegiatan
                $rincianKey = $kegiatanKey . '|' . $rincianKegiatanKode;
                $groupedData[$timKode]['rk_tims'][$rkTimKey]['proyeks'][$proyekKey]['kegiatans'][$kegiatanKey]['rincian_kegiatans'][$rincianKey] = [
                    'rincian_kegiatan_kode' => $rincianKegiatanKode,
                    'rincian_kegiatan_urai' => $rincianKegiatanUrai,
                    'catatan' => $catatan,
                    'rincian_kegiatan_satuan' => $rincianKegiatanSatuan,
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
            foreach ($groupedData as $timData) {
                // Find or create Tim
                $tim = MasterTim::firstOrCreate(
                    ['tim_kode' => $timData['tim_kode']],
                    ['tim_nama' => $timData['tim_nama']]
                );

                foreach ($timData['rk_tims'] as $rkTimData) {
                    // Find or create RK Tim
                    $rkTim = MasterRkTim::firstOrCreate(
                        [
                            'tim_id' => $tim->id,
                            'rk_tim_kode' => $rkTimData['rk_tim_kode']
                        ],
                        [
                            'rk_tim_urai' => $rkTimData['rk_tim_urai']
                        ]
                    );

                    foreach ($rkTimData['proyeks'] as $proyekData) {
                        // Find or create Proyek
                        $proyek = MasterProyek::firstOrCreate(
                            [
                                'rk_tim_id' => $rkTim->id,
                                'proyek_kode' => $proyekData['proyek_kode']
                            ],
                            [
                                'iku_kode' => $proyekData['iku_kode'],
                                'iku_urai' => $proyekData['iku_urai'],
                                'proyek_urai' => $proyekData['proyek_urai'],
                                'rk_anggota' => $proyekData['rk_anggota'],
                                'proyek_lapangan' => $proyekData['proyek_lapangan']
                            ]
                        );

                        foreach ($proyekData['kegiatans'] as $kegiatanData) {
                            // Find or create Kegiatan
                            $kegiatan = MasterKegiatan::firstOrCreate(
                                [
                                    'proyek_id' => $proyek->id,
                                    'kegiatan_kode' => $kegiatanData['kegiatan_kode']
                                ],
                                [
                                    'iki' => $kegiatanData['iki'],
                                    'kegiatan_urai' => $kegiatanData['kegiatan_urai']
                                ]
                            );

                            foreach ($kegiatanData['rincian_kegiatans'] as $rincianData) {
                                // Find or create Rincian Kegiatan
                                $rincian = MasterRincianKegiatan::firstOrCreate(
                                    [
                                        'kegiatan_id' => $kegiatan->id,
                                        'rincian_kegiatan_kode' => $rincianData['rincian_kegiatan_kode']
                                    ],
                                    [
                                        'rincian_kegiatan_urai' => $rincianData['rincian_kegiatan_urai'],
                                        'catatan' => $rincianData['catatan'],
                                        'rincian_kegiatan_satuan' => $rincianData['rincian_kegiatan_satuan']
                                    ]
                                );

                                $successCount++;
                                $results[] = [
                                    'row' => $rincianData['row'],
                                    'status' => $rincian->wasRecentlyCreated ? 'created' : 'updated',
                                    'message' => $rincian->wasRecentlyCreated ? 'Data berhasil ditambahkan' : 'Data berhasil diperbarui',
                                    'data' => [
                                        'tim_kode' => $timData['tim_kode'],
                                        'tim_nama' => $timData['tim_nama'],
                                        'rk_tim_kode' => $rkTimData['rk_tim_kode'],
                                        'rk_tim_urai' => $rkTimData['rk_tim_urai'],
                                        'proyek_kode' => $proyekData['proyek_kode'],
                                        'proyek_urai' => $proyekData['proyek_urai'],
                                        'kegiatan_kode' => $kegiatanData['kegiatan_kode'],
                                        'kegiatan_urai' => $kegiatanData['kegiatan_urai'],
                                        'rincian_kegiatan_kode' => $rincianData['rincian_kegiatan_kode'],
                                        'rincian_kegiatan_urai' => $rincianData['rincian_kegiatan_urai']
                                    ]
                                ];
                            }
                        }
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error importing Master Rincian Kegiatan data: ' . $e->getMessage());

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
     * Download import template.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'Tim Kode',
            'Tim Nama',
            'RK Tim Kode',
            'RK Tim Urai',
            'IKU Kode',
            'IKU Urai',
            'Proyek Kode',
            'Proyek Urai',
            'RK Anggota',
            'Proyek Lapangan',
            'IKI',
            'Kegiatan Kode',
            'Kegiatan Urai',
            'Rincian Kegiatan Kode',
            'Rincian Kegiatan Urai',
            'Catatan',
            'Satuan'
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
            'Tim Sensus',
            'RKT1.1',
            'Pelaksanaan Sensus',
            'IKU-1.1',
            'Persentase Kualitas Data Sensus',
            'P1.1.1',
            'Persiapan Sensus',
            'Seluruh Anggota',
            'Tidak',
            'Ketepatan Waktu Persiapan',
            'K1.1.1.1',
            'Penyiapan Instrumen',
            'RK1.1.1.1.1',
            'Desain Kuesioner',
            'Harus selesai 2 bulan sebelum pelaksanaan',
            'Dokumen'
        ];

        foreach ($sampleData as $index => $value) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '2', $value);
        }

        // Add second sample with same Tim & RK Tim but different Proyek
        $sampleData2 = [
            'T1',
            'Tim Sensus',
            'RKT1.1',
            'Pelaksanaan Sensus',
            'IKU-1.1',
            'Persentase Kualitas Data Sensus',
            'P1.1.2',
            'Pelaksanaan Lapangan',
            'Tim Lapangan',
            'Ya',
            'Cakupan Wilayah',
            'K1.1.2.1',
            'Pengumpulan Data',
            'RK1.1.2.1.1',
            'Wawancara Responden',
            'Target 100 responden per hari',
            'Responden'
        ];

        foreach ($sampleData2 as $index => $value) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '3', $value);
        }

        // Add instructions sheet
        $instructionSheet = $spreadsheet->createSheet();
        $instructionSheet->setTitle('Petunjuk');
        $instructionSheet->setCellValue('A1', 'Petunjuk Pengisian Template Import Master Rincian Kegiatan');
        $instructionSheet->setCellValue('A3', 'Informasi Struktur Data:');
        $instructionSheet->setCellValue('A4', '- Satu Tim dapat memiliki banyak RK Tim');
        $instructionSheet->setCellValue('A5', '- Satu RK Tim dapat memiliki banyak Proyek');
        $instructionSheet->setCellValue('A6', '- Satu Proyek dapat memiliki banyak Kegiatan');
        $instructionSheet->setCellValue('A7', '- Satu Kegiatan dapat memiliki banyak Rincian Kegiatan');
        $instructionSheet->setCellValue('A8', '- Tim dengan kode yang sama namun nama berbeda akan diupdate dengan nama terbaru');
        $instructionSheet->setCellValue('A9', '- Demikian juga untuk tingkatan lainnya, kode yang sama akan diupdate dengan detail terbaru');
        $instructionSheet->setCellValue('A10', '- Kode IKU dan Uraian IKU terkait dengan Proyek');

        $instructionSheet->setCellValue('A12', 'Kolom yang wajib diisi:');
        $instructionSheet->setCellValue('A13', '- Tim Kode & Tim Nama: Kode dan nama Tim');
        $instructionSheet->setCellValue('A14', '- RK Tim Kode & RK Tim Urai: Kode dan uraian RK Tim');
        $instructionSheet->setCellValue('A15', '- Proyek Kode & Proyek Urai: Kode dan uraian Proyek');
        $instructionSheet->setCellValue('A16', '- Kegiatan Kode & Kegiatan Urai: Kode dan uraian Kegiatan');
        $instructionSheet->setCellValue('A17', '- Rincian Kegiatan Kode & Rincian Kegiatan Urai: Kode dan uraian Rincian Kegiatan');

        $instructionSheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $instructionSheet->getStyle('A3')->getFont()->setBold(true);
        $instructionSheet->getStyle('A12')->getFont()->setBold(true);

        // Set column widths
        $instructionSheet->getColumnDimension('A')->setWidth(50);

        // Set active sheet back to first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Create directory if not exists
        if (!file_exists(storage_path('app/public/templates'))) {
            mkdir(storage_path('app/public/templates'), 0755, true);
        }

        // Save to file
        $path = storage_path('app/public/templates/template_import_rincian_kegiatan.xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterRincianKegiatan $masterRincianKegiatan)
    {
        $masterRincianKegiatan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rincian kegiatan berhasil dihapus'
        ]);
    }

    /**
     * Delete multiple rincian kegiatan at once.
     */
    public function batchDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:master_rincian_kegiatan,id'
        ]);

        MasterRincianKegiatan::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'success' => true,
            'message' => count($validated['ids']) . ' Rincian Kegiatan berhasil dihapus'
        ]);
    }
}
