<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarModel extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti plural bawaan Laravel
    protected $table = 'pendaftaran_toeic';

    // Primary key jika tidak bernama 'id'
    protected $primaryKey = 'id_pendaftaran';

    // Mass assignment
    protected $fillable = [
        'NIM', 'nama', 'no_wa', 'email',
        'id_jurusan', 'id_prodi', 'scan_ktp',
        'scan_ktm', 'pas_foto', 'tanggal_pendaftaran',
        'id_jadwal'
    ];

    // Jika tidak menggunakan timestamps
    public $timestamps = true;

    public function jurusan()
    {
        return $this->belongsTo(JurusanModel::class, 'Id_Jurusan');
    }

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'Id_Prodi');
    }
    public function mahasiswa()
{
    return $this->belongsTo(Mahasiswa::class, 'NIM', 'nim');
}
    public function jadwal_ujian() {
        return $this->belongsTo(JadwalUjianModel::class, 'Id_Jadwal', 'Id_Jadwal');
    }
}
