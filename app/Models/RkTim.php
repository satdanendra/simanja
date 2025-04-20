<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RkTim extends Model
{
    use HasFactory;
    
    protected $table = 'rk_tim';
    
    protected $fillable = [
        'tim_id',
        'rk_tim_id',
    ];
    
    /**
     * Get the tim that owns this rk_tim.
     */
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
    
    /**
     * Get the master_rk_tim for this rk_tim.
     */
    public function masterRkTim()
    {
        return $this->belongsTo(MasterRkTim::class, 'rk_tim_id');
    }
}