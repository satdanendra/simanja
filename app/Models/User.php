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
        'role_id',
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
        return $this->belongsTo(MasterPegawai::class, 'pegawai_id');
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

    // Relasi ke tabel roles
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Helper methods untuk check role
    public function isSuperadmin()
    {
        return $this->role_id === 1;
    }

    public function isKepalaBps()
    {
        return $this->role_id === 2;
    }

    public function isPegawai()
    {
        return $this->role_id === 3;
    }

    public function hasRole($roleId)
    {
        return $this->role_id === $roleId;
    }
}
