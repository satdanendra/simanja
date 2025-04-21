<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    use HasFactory;

    protected $table = 'master_kegiatan';
    
    protected $fillable = [
        'master_proyek_id',
        'iki',
        'kegiatan_kode',
        'kegiatan_urai',
    ];
    
    /**
     * Get the Master Proyek that owns this Master Kegiatan.
     */
    public function proyek()
    {
        return $this->belongsTo(MasterProyek::class, 'master_proyek_id');
    }
    
    /**
     * Get the Master Rincian Kegiatans for this Master Kegiatan.
     */
    public function rincianKegiatans()
    {
        return $this->hasMany(MasterRincianKegiatan::class, 'master_kegiatan_id');
    }
}