<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tim;
use App\Models\Proyek;
use App\Models\Kegiatan;
use App\Models\RincianKegiatan;
use App\Models\AlokasiRincianKegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil tim yang diikuti oleh user (sebagai anggota atau ketua)
        $userTims = Tim::where(function($query) use ($user) {
            $query->where('tim_ketua', $user->id)
                  ->orWhereHas('users', function($subQuery) use ($user) {
                      $subQuery->where('user_id', $user->id);
                  });
        })
        ->with(['masterTim', 'direktorat', 'ketuaTim'])
        ->get();

        // Ambil semua proyek dari tim yang diikuti user
        $userProyeks = Proyek::whereHas('rkTim.tim', function($query) use ($user) {
            $query->where('tim_ketua', $user->id)
                  ->orWhereHas('users', function($subQuery) use ($user) {
                      $subQuery->where('user_id', $user->id);
                  });
        })
        ->with([
            'masterProyek', 
            'rkTim.tim.masterTim', 
            'rkTim.masterRkTim',
            'picUser'
        ])
        ->get();

        // Hitung statistik dashboard
        $stats = [
            'total_tim' => $userTims->count(),
            'total_proyek' => $userProyeks->count(),
            'proyek_selesai' => 0, // Akan dihitung setelah proyekWithProgress
            'proyek_berjalan' => 0, // Akan dihitung setelah proyekWithProgress
        ];

        // Ambil proyek dengan progress berdasarkan alokasi rincian kegiatan
        $proyekWithProgress = $userProyeks->map(function($proyek) {
            // Ambil semua kegiatan dalam proyek ini
            $kegiatans = Kegiatan::where('proyek_id', $proyek->id)
                ->with(['masterKegiatan'])
                ->get();
            
            // Ambil semua rincian kegiatan dari semua kegiatan
            $rincianKegiatans = RincianKegiatan::whereIn('kegiatan_id', $kegiatans->pluck('id'))
                ->with(['alokasi'])
                ->get();
            
            // Hitung total target dan realisasi dari semua alokasi
            $totalTarget = 0;
            $totalRealisasi = 0;
            
            foreach ($rincianKegiatans as $rincianKegiatan) {
                foreach ($rincianKegiatan->alokasi as $alokasi) {
                    $totalTarget += $alokasi->target;
                    $totalRealisasi += $alokasi->realisasi ?? 0;
                }
            }
            
            // Hitung persentase progress berdasarkan realisasi vs target
            $progress = $totalTarget > 0 ? ($totalRealisasi / $totalTarget * 100) : 0;
            
            // Tentukan status berdasarkan progress
            $status = 'Belum Dimulai';
            $statusClass = 'bg-gray-100 text-gray-800';
            
            if ($progress > 0 && $progress < 50) {
                $status = 'Baru Dimulai';
                $statusClass = 'bg-blue-100 text-blue-800';
            } elseif ($progress >= 50 && $progress < 90) {
                $status = 'Dalam Progress';
                $statusClass = 'bg-yellow-100 text-yellow-800';
            } elseif ($progress >= 90 && $progress < 100) {
                $status = 'Hampir Selesai';
                $statusClass = 'bg-orange-100 text-orange-800';
            } elseif ($progress >= 100) {
                $status = 'Selesai';
                $statusClass = 'bg-green-100 text-green-800';
            }
            
            return [
                'id' => $proyek->id,
                'nama_proyek' => $proyek->masterProyek->proyek_urai,
                'kode_proyek' => $proyek->masterProyek->proyek_kode,
                'tim_nama' => $proyek->rkTim->tim->masterTim->tim_urai,
                'pic_nama' => $proyek->picUser ? $proyek->picUser->name : 'Belum Ditentukan',
                'progress' => round($progress, 1),
                'status' => $status,
                'status_class' => $statusClass,
                'total_target' => $totalTarget,
                'total_realisasi' => $totalRealisasi,
                'jumlah_kegiatan' => $kegiatans->count(),
                'jumlah_rincian_kegiatan' => $rincianKegiatans->count(),
                'rk_tim' => $proyek->rkTim->masterRkTim->rk_tim_urai,
            ];
        });

        // Update statistik berdasarkan progress yang sebenarnya
        $proyekSelesai = $proyekWithProgress->filter(function($proyek) {
            return $proyek['progress'] >= 100;
        })->count();
        
        $stats['proyek_selesai'] = $proyekSelesai;
        $stats['proyek_berjalan'] = $userProyeks->count() - $proyekSelesai;

        // Hapus aktivitas terbaru karena tidak menggunakan laporan harian
        // Bisa diganti dengan aktivitas terbaru dari alokasi atau update proyek
        $recentActivities = collect(); // Kosongkan untuk sementara

        return view('dashboard', compact(
            'userTims', 
            'userProyeks', 
            'proyekWithProgress', 
            'stats',
            'recentActivities'
        ));
    }
}