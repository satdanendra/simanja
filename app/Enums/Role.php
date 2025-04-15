<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Pegawai = 'pegawai';
    case Ketua_Tim = 'ketua_tim';
    case Kepala_BPS = 'kepala_bps';
}