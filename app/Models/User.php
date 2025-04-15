<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the pegawai that owns the user.
     */
    public function pegawai()
    {
        return $this->belongsTo(MasterPegawai::class, 'id');
    }

    /**
     * Get name attribute from related pegawai.
     *
     * @return string|null
     */
    public function getNameAttribute()
    {
        return $this->pegawai ? $this->pegawai->alias : null;
    }

    /**
     * Tim yang dimiliki oleh user.
     */
    public function tims()
    {
        return $this->belongsToMany(Tim::class, 'user_tim');
    }
}
