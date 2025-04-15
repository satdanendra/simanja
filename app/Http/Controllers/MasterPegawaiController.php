<?php

namespace App\Http\Controllers;

use App\Models\MasterPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class MasterPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawais = MasterPegawai::all();
        return view('masterpegawai', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master-pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'sex' => 'required|in:L,P',
            'gelar' => 'nullable|string|max:100',
            'alias' => 'nullable|string|max:100',
            'nip_lama' => 'nullable|string|max:50|unique:master_pegawais',
            'nip_baru' => 'nullable|string|max:50|unique:master_pegawais',
            'nik' => 'nullable|string|max:50|unique:master_pegawais',
            'email' => 'nullable|email|max:255|unique:master_pegawais',
            'nomor_hp' => 'nullable|string|max:20',
            'pangkat' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'educ' => 'nullable|string|max:10',
            'pendidikan' => 'nullable|string|max:255',
            'universitas' => 'nullable|string|max:255',
        ]);

        MasterPegawai::create($validated);

        return redirect()->route('master-pegawai')
            ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterPegawai $masterPegawai)
    {
        return view('master-pegawai.show', compact('masterPegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterPegawai $masterPegawai)
    {
        return response()->json($masterPegawai);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterPegawai $masterPegawai)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'sex' => 'required|in:L,P',
            'gelar' => 'nullable|string|max:100',
            'alias' => 'nullable|string|max:100',
            'nip_lama' => ['nullable', 'string', 'max:50', Rule::unique('master_pegawais')->ignore($masterPegawai->id)],
            'nip_baru' => ['nullable', 'string', 'max:50', Rule::unique('master_pegawais')->ignore($masterPegawai->id)],
            'nik' => ['nullable', 'string', 'max:50', Rule::unique('master_pegawais')->ignore($masterPegawai->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('master_pegawais')->ignore($masterPegawai->id)],
            'nomor_hp' => 'nullable|string|max:20',
            'pangkat' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'educ' => 'nullable|string|max:10',
            'pendidikan' => 'nullable|string|max:255',
            'universitas' => 'nullable|string|max:255',
        ]);

        $masterPegawai->update($validated);

        return redirect()->route('master-pegawai')
            ->with('success', 'Data pegawai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterPegawai $masterPegawai)
    {
        // Opsi 1: Hard delete - menghapus data secara permanen
        // $masterPegawai->delete();

        // Opsi 2: Soft delete - hanya mengubah status menjadi tidak aktif
        $masterPegawai->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Data pegawai berhasil diperbarui'
        ]);
    }

    /**
     * Mengaktifkan kembali pegawai yang telah dinonaktifkan
     */
    // public function activate(MasterPegawai $masterPegawai)
    // {
    //     $masterPegawai->update(['is_active' => true]);

    //     return redirect()->route('master-pegawai.index')
    //         ->with('success', 'Data pegawai berhasil diaktifkan kembali');
    // }

    /**
     * API untuk mendapatkan data pegawai
     */
    public function getPegawai(Request $request)
    {
        $search = $request->input('search');
        $pegawais = MasterPegawai::where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip_lama', 'like', "%{$search}%")
                    ->orWhere('nip_baru', 'like', "%{$search}%");
            })
            ->select('id', 'nama', 'gelar', 'nip_baru', 'jabatan')
            ->limit(10)
            ->get();

        return response()->json($pegawais);
    }

    public function showImportForm()
    {
        return view('master-pegawai.import');
    }

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
                $pegawaiData = $this->mapRowToData($row);

                // Validasi data
                $validator = Validator::make($pegawaiData, [
                    'nama' => 'required|string|max:255',
                    'sex' => 'required|in:L,P',
                    'gelar' => 'nullable|string|max:100',
                    'alias' => 'nullable|string|max:100',
                    'nip_lama' => 'nullable|string|max:50',
                    'nip_baru' => 'nullable|string|max:50',
                    'nik' => 'nullable|string|max:50',
                    'email' => 'nullable|email|max:255',
                    'nomor_hp' => 'nullable|string|max:20',
                    'pangkat' => 'nullable|string|max:50',
                    'jabatan' => 'nullable|string|max:255',
                    'educ' => 'nullable|string|max:10',
                    'pendidikan' => 'nullable|string|max:255',
                    'universitas' => 'nullable|string|max:255',
                ]);

                if ($validator->fails()) {
                    $errorCount++;
                    $errors[] = "Baris {$rowNum}: " . implode(', ', $validator->errors()->all());
                    $importResults[] = [
                        'row' => $rowNum,
                        'status' => 'error',
                        'message' => implode(', ', $validator->errors()->all()),
                        'data' => $pegawaiData
                    ];
                    continue;
                }

                // Cek apakah pegawai sudah ada (berdasarkan NIP Lama, NIP Baru, NIK, atau Email)
                $existingPegawai = null;

                if (!empty($pegawaiData['nip_lama'])) {
                    $existingPegawai = MasterPegawai::where('nip_lama', $pegawaiData['nip_lama'])->first();
                }

                if (!$existingPegawai && !empty($pegawaiData['nip_baru'])) {
                    $existingPegawai = MasterPegawai::where('nip_baru', $pegawaiData['nip_baru'])->first();
                }

                if (!$existingPegawai && !empty($pegawaiData['nik'])) {
                    $existingPegawai = MasterPegawai::where('nik', $pegawaiData['nik'])->first();
                }

                if (!$existingPegawai && !empty($pegawaiData['email'])) {
                    $existingPegawai = MasterPegawai::where('email', $pegawaiData['email'])->first();
                }

                // Jika pegawai sudah ada, update data. Jika belum, buat data baru.
                if ($existingPegawai) {
                    $existingPegawai->update($pegawaiData);
                    $successCount++;
                    $importResults[] = [
                        'row' => $rowNum,
                        'status' => 'updated',
                        'message' => 'Data berhasil diperbarui',
                        'data' => $pegawaiData
                    ];
                } else {
                    MasterPegawai::create($pegawaiData);
                    $successCount++;
                    $importResults[] = [
                        'row' => $rowNum,
                        'status' => 'created',
                        'message' => 'Data berhasil ditambahkan',
                        'data' => $pegawaiData
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

    private function readExcel($path)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
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

    private function isEmptyRow($row)
    {
        foreach ($row as $value) {
            if (!empty($value)) {
                return false;
            }
        }
        return true;
    }

    private function mapRowToData($row)
    {
        // Buat pemetaan kolom file ke kolom database
        // Ini dapat disesuaikan berdasarkan format file yang diimport
        $mapping = [
            'nama' => ['nama', 'name', 'nama_pegawai', 'nama lengkap'],
            'sex' => ['sex', 'jenis_kelamin', 'gender', 'jk'],
            'gelar' => ['gelar', 'title'],
            'alias' => ['alias', 'nama_panggilan', 'nickname'],
            'nip_lama' => ['nip_lama', 'nip lama', 'old_nip'],
            'nip_baru' => ['nip_baru', 'nip baru', 'nip', 'new_nip'],
            'nik' => ['nik', 'no_ktp', 'ktp', 'id_card'],
            'email' => ['email', 'e-mail', 'alamat_email'],
            'nomor_hp' => ['nomor_hp', 'no_hp', 'hp', 'handphone', 'telepon', 'phone'],
            'pangkat' => ['pangkat', 'golongan', 'grade', 'rank'],
            'jabatan' => ['jabatan', 'posisi', 'position', 'job_title'],
            'educ' => ['educ', 'tingkat_pendidikan', 'education_level'],
            'pendidikan' => ['pendidikan', 'jurusan', 'program_studi', 'study_program', 'major'],
            'universitas' => ['universitas', 'kampus', 'instansi_pendidikan', 'university', 'school']
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
        if (empty($result['nama'])) {
            throw new \Exception('Nama pegawai tidak ditemukan atau kosong');
        }

        // Normalisasi data jenis kelamin
        if (!empty($result['sex'])) {
            $sex = strtoupper(substr(trim($result['sex']), 0, 1));
            if ($sex == 'L' || $sex == 'M' || $sex == '1') {
                $result['sex'] = 'L';
            } elseif ($sex == 'P' || $sex == 'F' || $sex == '2') {
                $result['sex'] = 'P';
            } else {
                throw new \Exception('Format jenis kelamin tidak valid');
            }
        } else {
            throw new \Exception('Jenis kelamin tidak ditemukan atau kosong');
        }

        return $result;
    }

    public function downloadTemplate()
    {
        $path = storage_path('app/public/templates/template_import_pegawai.xlsx');

        if (file_exists($path)) {
            return response()->download($path);
        }

        // Jika file template belum ada, buat file template baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $headers = [
            'nama',
            'sex',
            'gelar',
            'alias',
            'nip_lama',
            'nip_baru',
            'nik',
            'email',
            'nomor_hp',
            'pangkat',
            'jabatan',
            'educ',
            'pendidikan',
            'universitas'
        ];

        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, ...
            $sheet->setCellValue($column . '1', $header);

            // Styling header
            $sheet->getStyle($column . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Tambahkan contoh data
        $exampleData = [
            'Imam Suprapto',
            'L',
            ', S.ST., MM.',
            'Imam',
            '340013775',
            '197010301993121001',
            '3308103010700002',
            'imams@bps.go.id',
            '081905031179',
            '4A',
            'Pranata Komputer Ahli Muda',
            'S2',
            'Magister Manajemen SDM',
            'STIE Mitra Indonesia'
        ];

        foreach ($exampleData as $index => $value) {
            $column = chr(65 + $index);
            $sheet->setCellValue($column . '2', $value);
        }

        // Menambahkan catatan pengisian
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Petunjuk');
        $sheet->setCellValue('A1', 'Petunjuk Pengisian Template Import Pegawai');
        $sheet->setCellValue('A3', 'Kolom yang wajib diisi:');
        $sheet->setCellValue('A4', '- nama: Nama lengkap pegawai');
        $sheet->setCellValue('A5', '- sex: Jenis kelamin (L/P)');

        $sheet->setCellValue('A7', 'Kolom opsional:');
        $sheet->setCellValue('A8', '- gelar: Gelar pegawai (Format: , S.ST., MM.)');
        $sheet->setCellValue('A9', '- alias: Nama panggilan pegawai');
        $sheet->setCellValue('A10', '- nip_lama: NIP Lama pegawai');
        $sheet->setCellValue('A11', '- nip_baru: NIP Baru pegawai');
        $sheet->setCellValue('A12', '- nik: Nomor KTP/NIK pegawai');
        $sheet->setCellValue('A13', '- email: Alamat email pegawai');
        $sheet->setCellValue('A14', '- nomor_hp: Nomor handphone pegawai');
        $sheet->setCellValue('A15', '- pangkat: Pangkat/golongan pegawai');
        $sheet->setCellValue('A16', '- jabatan: Jabatan pegawai');
        $sheet->setCellValue('A17', '- educ: Tingkat pendidikan (SMA/D1/D2/D3/D4/S1/S2/S3)');
        $sheet->setCellValue('A18', '- pendidikan: Jurusan/Program studi');
        $sheet->setCellValue('A19', '- universitas: Nama universitas/instansi pendidikan');

        $sheet->setCellValue('A21', 'Catatan:');
        $sheet->setCellValue('A22', '- Data yang sudah ada (berdasarkan NIP Lama, NIP Baru, NIK, atau Email) akan diperbarui');
        $sheet->setCellValue('A23', '- Data baru akan ditambahkan');
        $sheet->setCellValue('A24', '- Format sex dapat berupa: L/P, Laki-laki/Perempuan, M/F, Male/Female, 1/2');

        // Styling
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A7')->getFont()->setBold(true);
        $sheet->getStyle('A21')->getFont()->setBold(true);

        // Set active sheet to first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Create directory if not exists
        if (!file_exists(storage_path('app/public/templates'))) {
            mkdir(storage_path('app/public/templates'), 0755, true);
        }

        // Save to file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path);
    }

    public function deactivate($id)
    {
        try {
            $pegawai = MasterPegawai::findOrFail($id);
            $pegawai->is_active = false;
            $pegawai->save();

            // Tambahkan header Content-Type
            return response()->json([
                'success' => true,
                'message' => 'Pegawai berhasil dinonaktifkan'
            ], 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            Log::error('Error deactivating pegawai: ' . $e->getMessage());

            // Tambahkan header Content-Type
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan pegawai: ' . $e->getMessage()
            ], 500, ['Content-Type' => 'application/json']);
        }
    }

    public function activate($id)
    {
        try {
            $pegawai = MasterPegawai::findOrFail($id);
            $pegawai->is_active = true;
            $pegawai->save();

            // Jika request AJAX, kembalikan response sebagai JSON
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pegawai berhasil diaktifkan'
                ], 200, ['Content-Type' => 'application/json']);
            }

            return redirect()->back()->with('success', 'Pegawai berhasil diaktifkan');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error activating pegawai: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengaktifkan pegawai: ' . $e->getMessage()
                ], 500, ['Content-Type' => 'application/json']);
            }

            return redirect()->back()->with('error', 'Gagal mengaktifkan pegawai');
        }
    }
}
