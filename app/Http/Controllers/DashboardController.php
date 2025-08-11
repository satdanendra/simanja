<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use App\Models\Proyek;
use App\Models\User;
use App\Models\AlokasiRincianKegiatan;
use App\Models\RincianKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Data dasar yang akan dikirim ke view
        $data = [
            'user' => $user,
            'isKepalaBps' => $user->role_id == 2,
            'isSuperadmin' => $user->role_id == 1,
            'isKetuaTim' => $user->role_id == 3,
        ];

        // Jika Kepala BPS atau Superadmin - tampilkan semua data
        if ($user->role_id == 1 || $user->role_id == 2) {
            $data = array_merge($data, $this->getKepalaBpsData());
        } else {
            // User biasa - tampilkan data personal
            $data = array_merge($data, $this->getUserData($user));
        }

        return view('dashboard', $data);
    }

    private function getKepalaBpsData()
    {
        // Ambil semua tim dengan relasi
        $allTims = Tim::with([
            'direktorat',
            'masterTim',
            'ketuaTim',
            'users'
        ])->get();

        // Ambil semua proyek dengan statistik
        $allProyeks = Proyek::with([
            'rkTim.tim.masterTim',
            'rkTim.tim.ketuaTim',
            'masterProyek',
            'picUser',
            'kegiatans.rincianKegiatans.alokasi'
        ])->get();

        // Statistik umum
        $totalTims = $allTims->count();
        $totalProyeks = $allProyeks->count();
        $totalUsers = User::count();
        
        // Statistik progress proyek
        $proyekWithProgress = $allProyeks->map(function ($proyek) {
            $totalRincianKegiatan = $proyek->kegiatans->sum(function ($kegiatan) {
                return $kegiatan->rincianKegiatans->count();
            });

            $totalAlokasi = $proyek->kegiatans->sum(function ($kegiatan) {
                return $kegiatan->rincianKegiatans->sum(function ($rincian) {
                    return $rincian->alokasi->count();
                });
            });

            $totalRealisasi = $proyek->kegiatans->sum(function ($kegiatan) {
                return $kegiatan->rincianKegiatans->sum(function ($rincian) {
                    return $rincian->alokasi->sum('realisasi');
                });
            });

            $totalTarget = $proyek->kegiatans->sum(function ($kegiatan) {
                return $kegiatan->rincianKegiatans->sum(function ($rincian) {
                    return $rincian->alokasi->sum('target');
                });
            });

            $progress = $totalTarget > 0 ? ($totalRealisasi / $totalTarget) * 100 : 0;

            return [
                'id' => $proyek->id,
                'nama_proyek' => $proyek->masterProyek->proyek_urai,
                'kode_proyek' => $proyek->masterProyek->proyek_kode,
                'tim_nama' => $proyek->rkTim->tim->masterTim->tim_nama,
                'tim_kode' => $proyek->rkTim->tim->masterTim->tim_kode,
                'pic_nama' => $proyek->picUser->name ?? 'Belum ditentukan',
                'ketua_tim' => $proyek->rkTim->tim->ketuaTim->name,
                'jumlah_kegiatan' => $proyek->kegiatans->count(),
                'jumlah_rincian_kegiatan' => $totalRincianKegiatan,
                'jumlah_alokasi' => $totalAlokasi,
                'total_target' => $totalTarget,
                'total_realisasi' => $totalRealisasi,
                'progress' => round($progress, 1),
                'status' => $this->getProjectStatus($progress),
                'tahun' => $proyek->rkTim->tim->tahun
            ];
        });

        // Statistik per tim
        $timStatistics = $allTims->map(function ($tim) {
            $proyekCount = Proyek::whereHas('rkTim', function ($query) use ($tim) {
                $query->where('tim_id', $tim->id);
            })->count();

            $anggotaCount = $tim->users->count();

            return [
                'id' => $tim->id,
                'tim_nama' => $tim->masterTim->tim_nama,
                'tim_kode' => $tim->masterTim->tim_kode,
                'ketua_tim' => $tim->ketuaTim->name,
                'direktorat' => $tim->direktorat->nama,
                'jumlah_anggota' => $anggotaCount,
                'jumlah_proyek' => $proyekCount,
                'tahun' => $tim->tahun
            ];
        });

        // Top performers dan need attention
        $topPerformers = $proyekWithProgress->sortByDesc('progress')->take(5);
        $needAttention = $proyekWithProgress->where('progress', '<', 50)->sortBy('progress')->take(5);

        // Statistik penilaian
        $nilaiStatistics = $this->getNilaiStatistics();

        return [
            'allTims' => $allTims,
            'allProyeks' => $allProyeks,
            'totalTims' => $totalTims,
            'totalProyeks' => $totalProyeks,
            'totalUsers' => $totalUsers,
            'proyekWithProgress' => $proyekWithProgress,
            'timStatistics' => $timStatistics,
            'topPerformers' => $topPerformers,
            'needAttention' => $needAttention,
            'nilaiStatistics' => $nilaiStatistics,
            'userTims' => collect(), // Empty untuk kepala BPS
        ];
    }

    private function getUserData($user)
    {
        // Ambil tim yang diikuti user
        $userTims = $user->tims()->with([
            'direktorat',
            'masterTim',
            'ketuaTim'
        ])->get();

        // Ambil proyek dari tim yang diikuti
        $userProyeks = collect();
        foreach ($userTims as $tim) {
            $proyeks = Proyek::whereHas('rkTim', function ($query) use ($tim) {
                $query->where('tim_id', $tim->id);
            })->with([
                'masterProyek',
                'picUser',
                'kegiatans.rincianKegiatans.alokasi' => function ($query) use ($user) {
                    $query->where('pelaksana_id', $user->id);
                }
            ])->get();
            
            $userProyeks = $userProyeks->merge($proyeks);
        }

        // Statistik progress untuk user
        $proyekWithProgress = $userProyeks->map(function ($proyek) use ($user) {
            $userAlokasi = $proyek->kegiatans->flatMap(function ($kegiatan) use ($user) {
                return $kegiatan->rincianKegiatans->flatMap(function ($rincian) use ($user) {
                    return $rincian->alokasi->where('pelaksana_id', $user->id);
                });
            });

            $totalKegiatan = $proyek->kegiatans->count();
            $totalRincianKegiatan = $proyek->kegiatans->sum(function ($kegiatan) {
                return $kegiatan->rincianKegiatans->count();
            });
            $totalTarget = $userAlokasi->sum('target');
            $totalRealisasi = $userAlokasi->sum('realisasi');
            $progress = $totalTarget > 0 ? ($totalRealisasi / $totalTarget) * 100 : 0;

            return [
                'id' => $proyek->id,
                'nama_proyek' => $proyek->masterProyek->proyek_urai,
                'kode_proyek' => $proyek->masterProyek->proyek_kode,
                'pic_nama' => $proyek->picUser->name ?? 'Belum ditentukan',
                'jumlah_kegiatan' => $totalKegiatan,
                'jumlah_rincian_kegiatan' => $totalRincianKegiatan,
                'total_target' => $totalTarget,
                'total_realisasi' => $totalRealisasi,
                'progress' => round($progress, 1),
                'status' => $this->getProjectStatus($progress)
            ];
        });

        return [
            'userTims' => $userTims,
            'proyekWithProgress' => $proyekWithProgress,
            // Set nilai default untuk data kepala BPS
            'allTims' => collect(),
            'allProyeks' => collect(),
            'totalTims' => 0,
            'totalProyeks' => 0,
            'totalUsers' => 0,
            'timStatistics' => collect(),
            'topPerformers' => collect(),
            'needAttention' => collect(),
            'nilaiStatistics' => (object) [
                'total_dinilai' => 0,
                'rata_rata' => 0,
                'nilai_tertinggi' => 0,
                'nilai_terendah' => 0,
                'sangat_baik' => 0,
                'baik' => 0,
                'cukup' => 0,
                'kurang' => 0
            ],
        ];
    }

    private function getProjectStatus($progress)
    {
        if ($progress >= 90) return 'Hampir Selesai';
        if ($progress >= 70) return 'Dalam Progress';
        if ($progress >= 30) return 'Berjalan';
        if ($progress > 0) return 'Mulai';
        return 'Belum Dimulai';
    }

    private function getNilaiStatistics()
    {
        $nilaiStats = AlokasiRincianKegiatan::whereNotNull('nilai')
            ->selectRaw('
                COUNT(*) as total_dinilai,
                AVG(nilai) as rata_rata,
                MAX(nilai) as nilai_tertinggi,
                MIN(nilai) as nilai_terendah,
                SUM(CASE WHEN nilai >= 85 THEN 1 ELSE 0 END) as sangat_baik,
                SUM(CASE WHEN nilai >= 70 AND nilai < 85 THEN 1 ELSE 0 END) as baik,
                SUM(CASE WHEN nilai >= 60 AND nilai < 70 THEN 1 ELSE 0 END) as cukup,
                SUM(CASE WHEN nilai < 60 THEN 1 ELSE 0 END) as kurang
            ')
            ->first();

        return $nilaiStats ?? (object) [
            'total_dinilai' => 0,
            'rata_rata' => 0,
            'nilai_tertinggi' => 0,
            'nilai_terendah' => 0,
            'sangat_baik' => 0,
            'baik' => 0,
            'cukup' => 0,
            'kurang' => 0
        ];
    }
}