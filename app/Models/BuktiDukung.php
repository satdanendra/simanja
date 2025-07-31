<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiDukung extends Model
{
    use HasFactory;

    protected $table = 'bukti_dukungs';

    protected $fillable = [
        'rincian_kegiatan_id',
        'nama_file',
        'file_path',
        'drive_id',
        'file_type',
        'extension',
        'mime_type',
        'keterangan',
    ];

    public function rincianKegiatan()
    {
        return $this->belongsTo(RincianKegiatan::class);
    }

    public function isImage()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        return in_array(strtolower($this->extension), $imageExtensions);
    }

    public function isDocument()
    {
        $documentExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];
        return in_array(strtolower($this->extension), $documentExtensions);
    }
}