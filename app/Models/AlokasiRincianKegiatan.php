<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlokasiRincianKegiatan extends Model
{
    use HasFactory;
    
    protected $table = 'alokasi_rincian_kegiatan';
    
    protected $fillable = [
        'rincian_kegiatan_id',
        'pelaksana_id',
        'target',
        'realisasi',
        'nilai',
        'bukti_dukung_file_id',
        'bukti_dukung_file_name',
        'bukti_dukung_link',
        'bukti_dukung_uploaded_at',
    ];
    
    protected $casts = [
        'target' => 'float',
        'realisasi' => 'float',
        'bukti_dukung_uploaded_at' => 'datetime',
    ];
    
    /**
     * Mendapatkan RincianKegiatan yang memiliki alokasi ini.
     */
    public function rincianKegiatan()
    {
        return $this->belongsTo(RincianKegiatan::class, 'rincian_kegiatan_id');
    }
    
    /**
     * Mendapatkan pengguna yang ditugaskan untuk alokasi ini.
     */
    public function pelaksana()
    {
        return $this->belongsTo(User::class, 'pelaksana_id');
    }
}