<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    
    protected $table = 'kegiatan';
    
    protected $fillable = [
        'proyek_id',
        'master_kegiatan_id',
    ];
    
    /**
     * Get the Proyek that owns this Kegiatan.
     */
    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }
    
    /**
     * Get the Master Kegiatan for this Kegiatan.
     */
    public function masterKegiatan()
    {
        return $this->belongsTo(MasterKegiatan::class, 'master_kegiatan_id');
    }
    
    /**
     * Get the rincian kegiatans for this kegiatan.
     */
    public function rincianKegiatans()
    {
        return $this->hasMany(RincianKegiatan::class);
    }
}