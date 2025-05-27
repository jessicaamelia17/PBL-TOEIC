<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengajuan extends Model
{
    use HasFactory;

    protected $table = 'surat_pengajuan';
    protected $primaryKey = 'id_surat';

    protected $fillable = [
        'NIM',
        'tanggal_pengajuan',
        'status_verifikasi',
        'tanggal_verifikasi',
        'catatan',
        'file_sertifikat',
    ];

    // Dalam model SuratPengajuan
public function mahasiswa()
{
    return $this->belongsTo(Mahasiswa::class, 'NIM', 'nim');
}

}
