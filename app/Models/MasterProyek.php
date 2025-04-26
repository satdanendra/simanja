<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProyek extends Model
{
    use HasFactory;

    protected $table = 'master_proyek';

    protected $fillable = [
        'master_rk_tim_id',
        'iku_kode',
        'iku_urai',
        'proyek_kode',
        'proyek_urai',
        'rk_anggota',
        'proyek_lapangan',
    ];

    /**
     * Get the Master RK Tim that owns this Master Proyek.
     */
    public function rkTim()
    {
        return $this->belongsTo(MasterRkTim::class, 'master_rk_tim_id');
    }

    /**
     * Get the Master Kegiatans for this Master Proyek.
     */
    public function kegiatans()
    {
        return $this->hasMany(MasterKegiatan::class, 'master_proyek_id');
    }

    /**
     * Get the Proyek records for this Master Proyek.
     */
    public function proyeks()
    {
        return $this->hasMany(Proyek::class, 'master_proyek_id');
    }
}
