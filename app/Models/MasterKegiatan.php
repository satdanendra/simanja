<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    use HasFactory;

    protected $table = 'master_kegiatan';
    
    protected $fillable = [
        'proyek_id',
        'iki',
        'kegiatan_kode',
        'kegiatan_urai',
    ];
    
    /**
     * Get the Proyek that owns this Kegiatan.
     */
    public function proyek()
    {
        return $this->belongsTo(MasterProyek::class, 'proyek_id');
    }
    
    /**
     * Get the Rincian Kegiatans for this Kegiatan.
     */
    public function rincianKegiatans()
    {
        return $this->hasMany(MasterRincianKegiatan::class, 'kegiatan_id');
    }
}