<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sasaran extends Model
{
    use HasFactory;
    
    protected $table = 'sasaran';
    
    protected $fillable = [
        'tujuan_id',
        'sasaran_kode',
        'sasaran_urai'
    ];
    
    /**
     * Get the tujuan that owns the sasaran.
     */
    public function tujuan()
    {
        return $this->belongsTo(Tujuan::class);
    }
    
    /**
     * Get ikus for this sasaran.
     */
    public function ikus()
    {
        return $this->hasMany(Iku::class);
    }
}