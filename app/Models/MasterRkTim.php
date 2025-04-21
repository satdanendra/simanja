<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRkTim extends Model
{
    use HasFactory;

    protected $table = 'master_rk_tim';

    protected $fillable = [
        'tim_id',
        'rk_tim_kode',
        'rk_tim_urai',
    ];

    /**
     * Get the Tim that owns this RK Tim.
     */
    public function tim()
    {
        return $this->belongsTo(MasterTim::class, 'tim_id');
    }

    /**
     * Get the rk_tims that belong to this master_rk_tim.
     */
    public function rkTims()
    {
        return $this->hasMany(RkTim::class, 'master_rk_tim_id');
    }

    /**
     * Get the Proyeks for this RK Tim.
     */
    public function proyeks()
    {
        return $this->hasMany(MasterProyek::class, 'rk_tim_id');
    }
}
