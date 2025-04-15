<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'superadmin',
            'kepala_satker',
            'ketua_tim',
            'pic',
            'anggota_tim'
        ];

        foreach ($roles as $role) {
            Role::create(['nama' => $role]);
        }
    }
}
