<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;
    
    protected $table = 'proyek';
    
    protected $fillable = [
        'rk_tim_id',
        'master_proyek_id',
        'pic',
    ];
    
    /**
     * Get the RK Tim that owns this Proyek.
     */
    public function rkTim()
    {
        return $this->belongsTo(RkTim::class, 'rk_tim_id');
    }
    
    /**
     * Get the Master Proyek for this Proyek.
     */
    public function masterProyek()
    {
        return $this->belongsTo(MasterProyek::class, 'master_proyek_id');
    }

    /**
     * Get the PIC (Person In Charge) for this Proyek.
     */
    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic');
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'proyek_id');
    }
}