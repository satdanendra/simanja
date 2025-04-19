<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTim extends Model
{
    use HasFactory;

    protected $table = 'master_tim';
    
    protected $fillable = [
        'tim_kode',
        'tim_nama',
    ];
    
    /**
     * Get the RK Tims for this Tim.
     */
    public function rkTims()
    {
        return $this->hasMany(MasterRkTim::class, 'tim_id');
    }
}