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
    ];
    
    protected $casts = [
        'target' => 'float',
        'realisasi' => 'float',
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