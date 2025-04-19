<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProyek extends Model
{
    use HasFactory;

    protected $table = 'master_proyek';
    
    protected $fillable = [
        'rk_tim_id',
        'iku_kode',
        'iku_urai',
        'proyek_kode',
        'proyek_urai',
        'rk_anggota',
        'proyek_lapangan',
    ];
    
    /**
     * Get the RK Tim that owns this Proyek.
     */
    public function rkTim()
    {
        return $this->belongsTo(MasterRkTim::class, 'rk_tim_id');
    }
    
    /**
     * Get the Kegiatans for this Proyek.
     */
    public function kegiatans()
    {
        return $this->hasMany(MasterKegiatan::class, 'proyek_id');
    }
}