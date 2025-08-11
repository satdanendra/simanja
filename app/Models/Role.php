<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relasi dengan users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Constants untuk role IDs
    const SUPERADMIN = 1;
    const KEPALA_BPS = 2;
    const KETUA_TIM = 3;
}
