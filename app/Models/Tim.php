<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;

    protected $table = 'tims';

    protected $fillable = [
        'direktorat_id',
        'master_tim_id',
        'tim_ketua',
        'tahun',
    ];

    /**
     * Relasi dengan master direktorat
     */
    public function direktorat()
    {
        return $this->belongsTo(MasterDirektorat::class, 'direktorat_id');
    }

    /**
     * Relasi dengan master tim
     */
    public function masterTim()
    {
        return $this->belongsTo(MasterTim::class, 'master_tim_id');
    }

    /**
     * Relasi dengan user (ketua tim)
     */
    public function ketuaTim()
    {
        return $this->belongsTo(User::class, 'tim_ketua');
    }

    /**
     * User yang dimiliki oleh tim.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tim');
    }

    /**
     * Get the RK Tims for this Tim.
     */
    public function rkTims()
    {
        return $this->hasMany(RkTim::class);
    }
}
