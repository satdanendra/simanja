<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    use HasFactory;
    
    protected $table = 'tujuan';
    
    protected $fillable = [
        'tujuan_kode',
        'tujuan_urai'
    ];
    
    /**
     * Get sasarans for this tujuan.
     */
    public function sasarans()
    {
        return $this->hasMany(Sasaran::class);
    }
}