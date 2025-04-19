<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRincianKegiatan extends Model
{
    use HasFactory;

    protected $table = 'master_rincian_kegiatan';
    
    protected $fillable = [
        'kegiatan_id',
        'rincian_kegiatan_kode',
        'rincian_kegiatan_urai',
        'catatan',
        'rincian_kegiatan_satuan',
    ];
    
    /**
     * Get the Kegiatan that owns this Rincian Kegiatan.
     */
    public function kegiatan()
    {
        return $this->belongsTo(MasterKegiatan::class, 'kegiatan_id');
    }
}