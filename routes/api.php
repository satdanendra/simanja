<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\AlokasiRincianKegiatan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API untuk mendapatkan info file bukti dukung
Route::get('/alokasi/{alokasi}/file-info', function(AlokasiRincianKegiatan $alokasi) {
    return response()->json([
        'has_file' => !empty($alokasi->bukti_dukung_file_id),
        'file_name' => $alokasi->bukti_dukung_file_name,
        'file_link' => $alokasi->bukti_dukung_link,
    ]);
});