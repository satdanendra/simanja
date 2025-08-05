<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use App\Models\RkTim;
use App\Models\User;
use App\Models\Proyek;
use App\Models\MasterProyek;
use App\Models\MasterTim;
use App\Models\MasterRkTim;
use App\Models\MasterDirektorat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data tim dengan relasi
        $tims = Tim::with(['direktorat', 'masterTim', 'ketuaTim', 'users'])
            ->join('master_tim', 'tims.master_tim_id', '=', 'master_tim.id')
            ->orderBy('master_tim.tim_kode')
            ->orderBy('tims.tahun')
            ->select('tims.*')
            ->get();

        // Mengambil data untuk dropdown form
        $masterTims = MasterTim::orderBy('tim_kode')->get();
        $direktorats = MasterDirektorat::orderBy('kode')->get();
        $users = User::orderBy('name')->get();

        return view('tim', compact('tims', 'masterTims', 'direktorats', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'direktorat_id' => 'required',
            'master_tim_id' => 'required',
            'tim_ketua' => 'required|exists:users,id',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        // Handle direktorat baru jika opsi 'lainnya' dipilih
        if ($request->direktorat_id === 'lainnya') {
            $request->validate([
                'direktorat_kode' => 'required|string|max:50|unique:master_direktorats,kode',
                'direktorat_nama' => 'required|string|max:255',
            ]);

            // Buat direktorat baru
            $direktorat = MasterDirektorat::create([
                'kode' => $request->direktorat_kode,
                'nama' => $request->direktorat_nama,
            ]);

            // Gunakan ID direktorat baru
            $direktoratId = $direktorat->id;
        } else {
            $direktoratId = $request->direktorat_id;
        }

        // Handle tim baru jika opsi 'lainnya' dipilih
        if ($request->master_tim_id === 'lainnya') {
            $request->validate([
                'tim_kode' => 'required|string|max:50|unique:master_tim,tim_kode',
                'tim_nama' => 'required|string|max:255',
            ]);

            // Buat tim baru
            $masterTim = MasterTim::create([
                'tim_kode' => $request->tim_kode,
                'tim_nama' => $request->tim_nama,
            ]);

            // Gunakan ID tim baru
            $masterTimId = $masterTim->id;
        } else {
            $masterTimId = $request->master_tim_id;
        }

        // Buat tim baru dengan data yang sudah divalidasi
        $tim = Tim::create([
            'direktorat_id' => $direktoratId,
            'master_tim_id' => $masterTimId,
            'tim_ketua' => $request->tim_ketua,
            'tahun' => $request->tahun,
        ]);

        // Tambahkan ketua tim sebagai anggota tim
        $tim->users()->attach($request->tim_ketua);

        return redirect()->route('tim')
            ->with('success', 'Tim berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tim $tim)
    {
        $tim->load(['direktorat', 'masterTim', 'ketuaTim']);
        return view('tim.show', compact('tim'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tim $tim)
    {
        // Untuk API request
        if (request()->ajax()) {
            return response()->json($tim);
        }

        // Mengambil data untuk dropdown form
        $masterTims = MasterTim::all();
        $direktorats = MasterDirektorat::all();
        $users = User::all();

        return view('tim.edit', compact('tim', 'masterTims', 'direktorats', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tim $tim)
    {
        $validated = $request->validate([
            'direktorat_id' => 'required|exists:master_direktorats,id',
            'master_tim_id' => 'required|exists:master_tim,id',
            'tim_ketua' => 'required|exists:users,id',  // Perhatikan: berubah dari 'ketua_tim' ke 'tim_ketua'
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 10),
        ]);

        $tim->update($validated);

        return redirect()->route('tim')
            ->with('success', 'Data tim berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tim $tim)
    {
        // Hapus semua anggota tim terlebih dahulu
        $tim->users()->detach();

        // Hapus tim
        $tim->delete();

        return redirect()->route('tim')
            ->with('success', 'Tim berhasil dihapus');
    }

    /**
     * Menampilkan anggota tim dan RK Tim
     */
    public function anggota(Tim $tim)
    {
        $tim->load(['direktorat', 'masterTim', 'ketuaTim', 'users']); // Eager load relations

        // Dapatkan semua user yang belum menjadi anggota tim ini untuk modal
        $availableUsers = User::whereDoesntHave('tims', function ($query) use ($tim) {
            $query->where('tim_id', $tim->id);
        })->get();

        // Ambil RK Tim yang tersedia (yang belum ditambahkan ke tim ini)
        $availableRkTims = MasterRkTim::where('master_tim_id', $tim->masterTim->id)
            ->whereDoesntHave('rkTims', function ($query) use ($tim) {
                $query->where('tim_id', $tim->id);
            })->get();

        // Ambil RK Tim yang sudah ditambahkan ke tim ini
        $rkTims = RkTim::where('tim_id', $tim->id)
            ->with('masterRkTim')
            ->get()
            ->sortBy(function ($rkTim) {
                return $rkTim->masterRkTim->rk_tim_kode;
            });

        // Ambil semua proyek yang terkait dengan Tim ini (dari semua RK Tim)
        $proyeks = Proyek::whereHas('rkTim', function ($query) use ($tim) {
            $query->where('tim_id', $tim->id);
        })
            ->with(['masterProyek', 'rkTim.masterRkTim'])
            ->join('master_proyek', 'proyek.master_proyek_id', '=', 'master_proyek.id')
            ->orderBy('master_proyek.proyek_kode')
            ->select('proyek.*')
            ->get();

        // Ambil Master Proyek yang tersedia (yang belum ditambahkan ke RK Tim ini)
        $availableProyeks = MasterProyek::whereHas('rkTim', function ($query) use ($tim) {
            $query->where('master_tim_id', $tim->masterTim->id);
        })->whereDoesntHave('proyeks', function ($query) use ($tim) {
            $query->whereHas('rkTim', function ($q) use ($tim) {
                $q->where('tim_id', $tim->id);
            });
        })->get();

        // Ambil semua data IKU untuk dropdown
        $ikus = \App\Models\Iku::all();

        // Ambil daftar anggota tim untuk dropdown PIC proyek
        $anggotaTim = $tim->users()->get();

        return view('detailtim', compact('tim', 'availableUsers', 'availableRkTims', 'rkTims', 'proyeks', 'availableProyeks', 'ikus', 'anggotaTim'));
    }

    /**
     * Menyimpan RK Tim baru ke tim
     */
    public function simpanRkTim(Request $request, Tim $tim)
    {
        // Validasi request
        $validator = Validator::make($request->all(), [
            'rktim_ids' => 'nullable|array',
            'rktim_ids.*' => 'exists:master_rk_tim,id',
        ])
            ->after(function ($validator) use ($request) {
                // Kalau array kosong dan user ingin menambah RK Tim baru, validasi kolom baru
                $rktimIds = $request->input('rktim_ids', []);
                $addNew = $request->input('add_new_rktim');

                if ((empty($rktimIds) || count($rktimIds) == 0) && $addNew) {
                    if (!$request->filled('new_rk_tim_kode')) {
                        $validator->errors()->add('new_rk_tim_kode', 'Kolom kode RK Tim wajib diisi.');
                    }
                    if (!$request->filled('new_rk_tim_urai')) {
                        $validator->errors()->add('new_rk_tim_urai', 'Kolom uraian RK Tim wajib diisi.');
                    }
                }
            });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses RK Tim yang dipilih dari daftar
        if ($request->has('rktim_ids') && !empty($request->rktim_ids)) {
            foreach ($request->rktim_ids as $rkTimId) {
                // Cek jika RK Tim sudah ada di tim ini
                $exists = RkTim::where('tim_id', $tim->id)
                    ->where('master_rk_tim_id', $rkTimId)
                    ->exists();

                if (!$exists) {
                    RkTim::create([
                        'tim_id' => $tim->id,
                        'master_rk_tim_id' => $rkTimId,
                    ]);
                }
            }
        }

        // Proses RK Tim baru yang diinput manual
        if ($request->add_new_rktim) {
            // Buat Master RK Tim baru
            $masterRkTim = MasterRkTim::create([
                'master_tim_id' => $tim->masterTim->id, // ID Tim Master
                'rk_tim_kode' => $request->new_rk_tim_kode,
                'rk_tim_urai' => $request->new_rk_tim_urai,
            ]);

            // Buat relasi RK Tim dengan Tim
            RkTim::create([
                'tim_id' => $tim->id,
                'master_rk_tim_id' => $masterRkTim->id,
            ]);
        }

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'RK Tim berhasil ditambahkan');
    }

    /**
     * Update RK Tim
     */
    public function updateRkTim(Request $request, Tim $tim, $rkTimId)
    {
        $validator = Validator::make($request->all(), [
            'rk_tim_kode' => 'required|string|max:50',
            'rk_tim_urai' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $masterRkTim = MasterRkTim::findOrFail($rkTimId);

        $masterRkTim->update([
            'rk_tim_kode' => $request->rk_tim_kode,
            'rk_tim_urai' => $request->rk_tim_urai,
        ]);

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'RK Tim berhasil diperbarui');
    }

    /**
     * Hapus RK Tim dari tim
     */
    public function hapusRkTim(Tim $tim, $rkTimId)
    {
        // Hapus relasi RK Tim dengan Tim
        RkTim::where('tim_id', $tim->id)
            ->where('master_rk_tim_id', $rkTimId)
            ->delete();

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'RK Tim berhasil dihapus dari tim');
    }

    /**
     * Menyimpan anggota baru ke tim
     */
    public function simpanAnggota(Request $request, Tim $tim)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $tim->users()->attach($request->user_ids);

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'Anggota tim berhasil ditambahkan');
    }

    /**
     * Menghapus anggota dari tim
     */
    public function hapusAnggota(Tim $tim, $userId)
    {
        $tim->users()->detach($userId);

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'Anggota tim berhasil dihapus');
    }

    /**
     * Menyimpan Proyek baru ke Tim
     */
    public function simpanProyek(Request $request, Tim $tim)
    {
        // Cek apakah ini penambahan proyek dari checkbox atau proyek baru
        $isAddingExistingProyeks = $request->has('proyek_ids') && !empty($request->proyek_ids);
        $isAddingNewProyek = $request->has('add_new_proyek') && $request->add_new_proyek;

        // Atur validasi dinamis berdasarkan input
        $rules = [];

        // Jika menambahkan proyek baru, wajib ada rk_tim_id
        if ($isAddingNewProyek) {
            $rules['rk_tim_id'] = 'required|exists:rk_tim,id';
            $rules['new_proyek_kode'] = 'required|string|max:50';
            $rules['new_proyek_urai'] = 'required|string';
        }

        // Aturan validasi umum
        $rules['proyek_ids'] = 'nullable|array';
        $rules['proyek_ids.*'] = 'exists:master_proyek,id';
        $rules['pic_ids'] = 'nullable|array';
        $rules['pic_ids.*'] = 'nullable|exists:users,id';
        $rules['new_pic_proyek'] = 'nullable|exists:users,id';

        // Validasi data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses Proyek yang dipilih dari daftar
        if ($isAddingExistingProyeks) {
            foreach ($request->proyek_ids as $proyekId) {
                // Dapatkan master proyek untuk mendapatkan rk_tim_id yang tepat
                $masterProyek = MasterProyek::findOrFail($proyekId);

                // Dapatkan RK Tim yang terkait dengan master proyek dan tim saat ini
                $rkTim = RkTim::where('tim_id', $tim->id)
                    ->where('master_rk_tim_id', $masterProyek->master_rk_tim_id)
                    ->first();

                if (!$rkTim) {
                    // Jika tidak ada RK Tim yang cocok, lanjutkan ke proyek berikutnya
                    continue;
                }

                // Cek jika Proyek sudah ada di RK Tim ini
                $exists = Proyek::where('rk_tim_id', $rkTim->id)
                    ->where('master_proyek_id', $proyekId)
                    ->exists();

                if (!$exists) {
                    // Set PIC jika ada
                    $pic = null;
                    if ($request->has('pic_ids') && isset($request->pic_ids[$proyekId])) {
                        $pic = $request->pic_ids[$proyekId];
                    }

                    Proyek::create([
                        'rk_tim_id' => $rkTim->id,
                        'master_proyek_id' => $proyekId,
                        'pic' => $pic,
                    ]);
                }
            }
        }

        // Proses Proyek baru yang diinput manual
        if ($isAddingNewProyek) {
            // Dapatkan RK Tim
            $rkTim = RkTim::findOrFail($request->rk_tim_id);

            // Verifikasi bahwa RK Tim adalah milik Tim yang diberikan
            if ($rkTim->tim_id != $tim->id) {
                return redirect()->back()->with('error', 'RK Tim tidak terkait dengan Tim ini.');
            }

            // Buat Master Proyek baru
            $masterProyek = MasterProyek::create([
                'master_rk_tim_id' => $rkTim->masterRkTim->id,
                'proyek_kode' => $request->new_proyek_kode,
                'proyek_urai' => $request->new_proyek_urai,
                'iku_kode' => $request->new_iku_kode,
                'iku_urai' => $request->new_iku_urai,
                'rk_anggota' => $request->new_rk_anggota,
                'proyek_lapangan' => $request->new_proyek_lapangan,
            ]);

            // Buat relasi Proyek dengan RK Tim
            Proyek::create([
                'rk_tim_id' => $rkTim->id,
                'master_proyek_id' => $masterProyek->id,
                'pic' => $request->filled('new_pic_proyek') ? $request->new_pic_proyek : null,
            ]);
        }

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'Proyek berhasil ditambahkan');
    }

    /**
     * Update Proyek
     */
    public function updateProyek(Request $request, Tim $tim, $proyekId)
    {
        $validator = Validator::make($request->all(), [
            'rk_tim_id' => 'required|exists:rk_tim,id',  // Tambahan validasi untuk RK Tim
            'proyek_kode' => 'required|string|max:50',
            'proyek_urai' => 'required|string',
            'iku_kode' => 'nullable|string|max:50',
            'iku_urai' => 'nullable|string',
            'rk_anggota' => 'nullable|string',
            'proyek_lapangan' => 'required|string|in:Ya,Tidak',
            'pic' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cari proyek berdasarkan ID
        $proyek = Proyek::findOrFail($proyekId);

        // Dapatkan RK Tim baru
        $rktim = RkTim::findOrFail($request->rk_tim_id);

        // Verifikasi bahwa RK Tim baru adalah milik Tim yang diberikan
        if ($rktim->tim_id != $tim->id) {
            return redirect()->back()->with('error', 'RK Tim tidak terkait dengan Tim ini.');
        }

        // Verifikasi bahwa Proyek terkait dengan Tim ini (melalui RK Tim lama)
        if ($proyek->rkTim->tim_id != $tim->id) {
            return redirect()->back()->with('error', 'Proyek tidak terkait dengan Tim ini.');
        }

        $masterProyek = $proyek->masterProyek;

        // Update data master proyek
        $masterProyek->update([
            'proyek_kode' => $request->proyek_kode,
            'proyek_urai' => $request->proyek_urai,
            'iku_kode' => $request->iku_kode,
            'iku_urai' => $request->iku_urai,
            'rk_anggota' => $request->rk_anggota,
            'proyek_lapangan' => $request->proyek_lapangan,
        ]);

        // Update PIC & RK Tim proyek
        $proyek->update([
            'pic' => $request->pic,
            'rk_tim_id' => $request->rk_tim_id, // Update RK Tim jika berubah
        ]);

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'Proyek berhasil diperbarui');
    }

    /**
     * Hapus Proyek dari Tim
     */
    public function hapusProyek(Tim $tim, $proyekId)
    {
        // Hapus relasi Proyek
        $proyek = Proyek::findOrFail($proyekId);

        // Verifikasi bahwa Proyek terkait dengan Tim ini
        if ($proyek->rkTim->tim_id != $tim->id) {
            return redirect()->back()->with('error', 'Proyek tidak terkait dengan Tim ini.');
        }

        $proyek->delete();

        return redirect()->route('detailtim', $tim->id)
            ->with('success', 'Proyek berhasil dihapus');
    }
}
