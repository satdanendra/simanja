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
     * Get the Master RK Tims for this Master Tim.
     */
    public function rkTims()
    {
        return $this->hasMany(MasterRkTim::class, 'master_tim_id');
    }
}