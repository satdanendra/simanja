<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;
    
    protected $table = 'tims';
    
    protected $fillable = [
        'nama_tim',
        'tahun'
    ];
    
    /**
     * User yang dimiliki oleh tim.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tim');
    }
}