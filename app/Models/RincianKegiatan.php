<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianKegiatan extends Model
{
    use HasFactory;
    
    protected $table = 'rincian_kegiatan';
    
    protected $fillable = [
        'kegiatan_id',
        'master_rincian_kegiatan_id',
        'volume',
        'waktu',
        'deadline',
        'is_variabel_kontrol',
    ];
    
    protected $casts = [
        'deadline' => 'date',
        'is_variabel_kontrol' => 'boolean',
    ];
    
    /**
     * Get the Kegiatan that owns this RincianKegiatan.
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
    
    /**
     * Get the MasterRincianKegiatan for this RincianKegiatan.
     */
    public function masterRincianKegiatan()
    {
        return $this->belongsTo(MasterRincianKegiatan::class, 'master_rincian_kegiatan_id');
    }

    /**
     * Get the allocations for this RincianKegiatan.
     */
    public function alokasi()
    {
        return $this->hasMany(AlokasiRincianKegiatan::class, 'rincian_kegiatan_id');
    }
}