<?php

namespace App\Http\Controllers;

use App\Models\MasterDirektorat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MasterDirektoratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $direktorats = MasterDirektorat::all();
        return view('masterdirektorat', compact('direktorats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master-direktorat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:master_direktorats',
            'nama' => 'required|string|max:255',
        ]);

        MasterDirektorat::create($validated);

        return redirect()->route('master-direktorat')
            ->with('success', 'Direktorat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterDirektorat $masterDirektorat)
    {
        return view('master-direktorat.show', compact('masterDirektorat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterDirektorat $masterDirektorat)
    {
        return response()->json($masterDirektorat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterDirektorat $masterDirektorat)
    {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:50',
                Rule::unique('master_direktorats')->ignore($masterDirektorat->id)
            ],
            'nama' => 'required|string|max:255',
        ]);

        $masterDirektorat->update($validated);

        return redirect()->route('master-direktorat')
            ->with('success', 'Data direktorat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterDirektorat $masterDirektorat)
    {
        // Hard delete - menghapus data secara permanen
        $masterDirektorat->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Data direktorat berhasil dihapus'
        ]);
    }

    /**
     * Import data direktorat dari file
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xls,xlsx|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        // Mendeteksi tipe file dan membaca data
        $ext = $file->getClientOriginalExtension();
        $data = [];
        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        if ($ext == 'csv') {
            $data = $this->readCSV($path);
        } else {
            $data = $this->readExcel($path);
        }

        // Memproses dan validasi data
        $rowNum = 1; // Mulai dari baris 1 (setelah header)
        $importResults = [];

        foreach ($data as $row) {
            $rowNum++;

            // Abaikan baris kosong
            if ($this->isEmptyRow($row)) {
                continue;
            }

            // Memetakan data dari file ke kolom database
            try {
                $direktoratData = $this->mapRowToData($row);

                // Validasi data
                $validator = \Illuminate\Support\Facades\Validator::make($direktoratData, [
                    'kode' => 'required|string|max:50',
                    'nama' => 'required|string|max:255',
                ]);

                if ($validator->fails()) {
                    $errorCount++;
                    $errors[] = "Baris {$rowNum}: " . implode(', ', $validator->errors()->all());
                    $importResults[] = [
                        'row' => $rowNum,
                        'status' => 'error',
                        'message' => implode(', ', $validator->errors()->all()),
                        'data' => $direktoratData
                    ];
                    continue;
                }

                // Cek apakah direktorat sudah ada berdasarkan kode
                $existingDirektorat = MasterDirektorat::where('kode', $direktoratData['kode'])->first();

                // Jika direktorat sudah ada, update data. Jika belum, buat data baru.
                if ($existingDirektorat) {
                    $existingDirektorat->update($direktoratData);
                    $successCount++;
                    $importResults[] = [
                        'row' => $rowNum,
                        'status' => 'updated',
                        'message' => 'Data berhasil diperbarui',
                        'data' => $direktoratData
                    ];
                } else {
                    MasterDirektorat::create($direktoratData);
                    $successCount++;
                    $importResults[] = [
                        'row' => $rowNum,
                        'status' => 'created',
                        'message' => 'Data berhasil ditambahkan',
                        'data' => $direktoratData
                    ];
                }
            } catch (\Exception $e) {
                $errorCount++;
                $errors[] = "Baris {$rowNum}: " . $e->getMessage();
                $importResults[] = [
                    'row' => $rowNum,
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'data' => $row
                ];
            }
        }

        return response()->json([
            'success' => true,
            'successCount' => $successCount,
            'errorCount' => $errorCount,
            'errors' => $errors,
            'results' => $importResults
        ]);
    }

    /**
     * Download template untuk import direktorat
     */
    public function downloadTemplate()
    {
        $path = storage_path('app/public/templates/template_import_direktorat.xlsx');

        if (file_exists($path)) {
            return response()->download($path);
        }

        // Jika file template belum ada, buat file template baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $headers = [
            'kode',
            'nama'
        ];

        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, ...
            $sheet->setCellValue($column . '1', $header);

            // Styling header
            $sheet->getStyle($column . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Tambahkan contoh data
        $exampleData = [
            '31',
            'Direktorat Pengembangan Metodologi Sensus dan Survei'
        ];

        foreach ($exampleData as $index => $value) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '2', $value);
        }

        // Menambahkan contoh data kedua
        $exampleData2 = [
            '32',
            'Direktorat Diseminasi Statistik'
        ];

        foreach ($exampleData2 as $index => $value) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '3', $value);
        }

        // Menambahkan catatan pengisian
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Petunjuk');
        $sheet->setCellValue('A1', 'Petunjuk Pengisian Template Import Direktorat');
        $sheet->setCellValue('A3', 'Kolom yang harus diisi:');
        $sheet->setCellValue('A4', '- kode: Kode direktorat (harus unik)');
        $sheet->setCellValue('A5', '- nama: Nama direktorat');

        $sheet->setCellValue('A7', 'Catatan:');
        $sheet->setCellValue('A8', '- Data yang sudah ada (berdasarkan kode) akan diperbarui');
        $sheet->setCellValue('A9', '- Data baru akan ditambahkan');

        // Styling
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A7')->getFont()->setBold(true);

        // Set active sheet to first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Create directory if not exists
        if (!file_exists(storage_path('app/public/templates'))) {
            mkdir(storage_path('app/public/templates'), 0755, true);
        }

        // Save to file
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path);
    }

    /**
     * Membaca file CSV
     */
    private function readCSV($path)
    {
        $file = fopen($path, 'r');
        $header = fgetcsv($file);
        $data = [];

        while ($row = fgetcsv($file)) {
            if (count($header) == count($row)) {
                $data[] = array_combine($header, $row);
            }
        }

        fclose($file);
        return $data;
    }

    /**
     * Membaca file Excel
     */
    private function readExcel($path)
    {
        $spreadsheet = IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();

        $rows = $worksheet->toArray();
        $header = array_shift($rows);
        $data = [];

        foreach ($rows as $row) {
            if (count($header) == count($row)) {
                $data[] = array_combine($header, $row);
            }
        }

        return $data;
    }

    /**
     * Memeriksa apakah baris kosong
     */
    private function isEmptyRow($row)
    {
        foreach ($row as $value) {
            if (!empty($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Memetakan data dari baris file ke data direktorat
     */
    private function mapRowToData($row)
    {
        // Buat pemetaan kolom file ke kolom database
        $mapping = [
            'kode' => ['kode', 'code', 'id'],
            'nama' => ['nama', 'name', 'nama_direktorat']
        ];

        $result = [];

        // Mencari kolom yang sesuai di file berdasarkan pemetaan
        foreach ($mapping as $dbField => $possibleNames) {
            $result[$dbField] = null;

            foreach ($possibleNames as $name) {
                // Cek nama kolom case insensitive
                foreach ($row as $key => $value) {
                    if (strtolower($key) == strtolower($name) && !empty($value)) {
                        $result[$dbField] = $value;
                        break 2;
                    }
                }
            }
        }

        // Pastikan data wajib ada
        if (empty($result['kode'])) {
            throw new \Exception('Kode direktorat tidak ditemukan atau kosong');
        }

        if (empty($result['nama'])) {
            throw new \Exception('Nama direktorat tidak ditemukan atau kosong');
        }

        return $result;
    }
    
    /**
     * Hapus beberapa record direktorat sekaligus
     */
    public function batchDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:master_direktorats,id'
        ]);

        MasterDirektorat::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'success' => true,
            'message' => count($validated['ids']) . ' data direktorat berhasil dihapus'
        ]);
    }
}
