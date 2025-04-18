<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku extends Model
{
    use HasFactory;
    
    protected $table = 'iku';
    
    protected $fillable = [
        'sasaran_id',
        'iku_kode',
        'iku_urai',
        'iku_satuan',
        'iku_target'
    ];
    
    /**
     * Get the sasaran that owns the iku.
     */
    public function sasaran()
    {
        return $this->belongsTo(Sasaran::class);
    }
}