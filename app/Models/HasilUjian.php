<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujian'; // Nama tabel di database

    protected $primaryKey = 'Id_Hasil'; // Primary key tabel (jika tidak 'id')

    protected $fillable = [
        'Id_Pendaftaran',
        'listening_1',
        'reading_1',
        'total_skor_1',
        'Listening_2',
        'Reading_2',
        'total_skor_2',
        'Tanggal_Ujian',
        'Status', 
    ];

    public $timestamps = true; // Gunakan timestamps jika tabel pakai created_at & updated_at
        // Relasi ke peserta pendaftaran
    public function peserta()
    {
        return $this->hasMany(RegistrasiModel::class, 'id_room', 'id_room');
    }
//    public function jadwal()
//     {
//         return $this->belongsTo(JadwalUjianModel::class, 'id_jadwal', 'Id_Jadwal');
//     }
    public function pengambilanSertifikat()
    {
    return $this->hasOne(PengambilanSertifikat::class, 'Id_Hasil', 'Id_Hasil');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'NIM', 'nim');
    }
    public function pendaftaran()
{
    return $this->belongsTo(RegistrasiModel::class, 'Id_Pendaftaran', 'Id_Pendaftaran');
}

}