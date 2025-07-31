<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class LaporanHarian extends Model
{
    use HasFactory;

    protected $table = 'laporan_harians';

    protected $fillable = [
        'user_id',
        'proyek_id',
        'rincian_kegiatan_id',
        'tipe_waktu',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'kegiatan_deskripsi',
        'capaian',
        'dasar_pelaksanaan',
        'kendala',
        'solusi',
        'catatan',
        'bukti_dukung_ids',
        'file_path',
        'drive_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'dasar_pelaksanaan' => 'array',
        'bukti_dukung_ids' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function rincianKegiatan()
    {
        return $this->belongsTo(RincianKegiatan::class);
    }

    // Get bukti dukung dengan urutan
    public function getBuktiDukungs()
    {
        if (empty($this->bukti_dukung_ids)) {
            return collect();
        }

        $buktiDukungList = collect();

        foreach ($this->bukti_dukung_ids as $item) {
            $buktiDukung = BuktiDukung::find($item['id']);
            if ($buktiDukung) {
                $buktiDukung->urutan_laporan = $item['urutan'];
                $buktiDukungList->push($buktiDukung);
            }
        }

        return $buktiDukungList->sortBy('urutan_laporan');
    }

    // Format tanggal untuk display
    public function getFormattedTanggalAttribute()
    {
        if ($this->tipe_waktu === 'single_date') {
            return $this->tanggal_mulai->format('d/m/Y');
        } else {
            return $this->tanggal_mulai->format('d/m/Y') . ' - ' .
                ($this->tanggal_selesai ? $this->tanggal_selesai->format('d/m/Y') : '');
        }
    }

    // Format waktu untuk display
    public function getFormattedWaktuAttribute()
    {
        if ($this->tipe_waktu === 'single_date' && $this->jam_mulai && $this->jam_selesai) {
            return $this->jam_mulai->format('H:i') . ' - ' . $this->jam_selesai->format('H:i');
        }
        return '-';
    }

    // Check if PDF is ready
    public function isPdfReady()
    {
        // Check if stored in Google Drive
        if ($this->file_path === 'google_drive' && !empty($this->drive_id)) {
            return true;
        }

        // Check if stored locally
        return !empty($this->drive_id) && !empty($this->file_path) && Storage::exists($this->file_path);
    }

    // Get download URL
    public function getDownloadUrl()
    {
        if ($this->isPdfReady()) {
            return route('laporan-harian.download', $this->id);
        }
        return null;
    }

    // Generate filename for PDF
    public function generateFilename()
    {
        $tanggal = $this->tanggal_mulai->format('Y-m-d');
        $userName = str_replace(' ', '_', $this->user->name);
        $proyekKode = $this->proyek->masterProyek->proyek_kode ?? 'PROJ';

        return "Laporan_Harian_{$tanggal}_{$userName}_{$proyekKode}.pdf";
    }
}
