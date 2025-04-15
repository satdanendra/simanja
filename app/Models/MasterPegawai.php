<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPegawai extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'sex',
        'gelar',
        'alias',
        'nip_lama',
        'nip_baru',
        'nik',
        'email',
        'nomor_hp',
        'pangkat',
        'jabatan',
        'educ',
        'pendidikan',
        'universitas',
        'is_active',
    ];

    /**
     * Mendapatkan nama lengkap pegawai dengan gelar
     */
    public function getNamaLengkapAttribute()
    {
        return $this->gelar ? $this->nama . $this->gelar : $this->nama;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

}