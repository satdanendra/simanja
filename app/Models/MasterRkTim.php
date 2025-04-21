<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRkTim extends Model
{
    use HasFactory;

    protected $table = 'master_rk_tim';

    protected $fillable = [
        'master_tim_id',
        'rk_tim_kode',
        'rk_tim_urai',
    ];

    /**
     * Get the Master Tim that owns this Master RK Tim.
     */
    public function tim()
    {
        return $this->belongsTo(MasterTim::class, 'master_tim_id');
    }

    /**
     * Get the master_rk_tims that belong to this master_rk_tim.
     */
    public function rkTims()
    {
        return $this->hasMany(RkTim::class, 'master_rk_tim_id');
    }

    /**
     * Get the Master Proyeks for this Master RK Tim.
     */
    public function proyeks()
    {
        return $this->hasMany(MasterProyek::class, 'master_rk_tim_id');
    }
}
