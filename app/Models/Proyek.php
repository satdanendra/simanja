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
     * Get the Master Proyek that this Proyek references.
     */
    public function masterProyek()
    {
        return $this->belongsTo(MasterProyek::class, 'master_proyek_id');
    }
    
    /**
     * Get the user (PIC) for this Proyek.
     */
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic');
    }
    
    /**
     * Get all the kegiatan for this proyek.
     */
    // public function kegiatans()
    // {
    //     return $this->hasMany(Kegiatan::class);
    // }
}