<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiModel extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_toeic';
    protected $primaryKey = 'Id_Pendaftaran';
    public $timestamps = true;

    protected $fillable = [
        'NIM',
        'Nama',
        'No_WA',
        'email',
        'Id_Jurusan',
        'Id_Prodi',
        'Scan_KTP',
        'Scan_KTM',
        'Pas_Foto',
        'Tanggal_Pendaftaran',
        'ID_Jadwal',
        'id_room',
    ];

    // Relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(JurusanModel::class, 'Id_Jurusan', 'Id_Jurusan');
    }

    // Relasi ke prodi
    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'Id_Prodi', 'Id_Prodi');
    }

    // Relasi ke jadwal ujian
    public function jadwal()
    {
        return $this->belongsTo(JadwalUjianModel::class, 'ID_Jadwal', 'ID_Jadwal');
    }

    // Relasi ke room ujian
    public function room()
    {
        return $this->belongsTo(RoomUjianModel::class, 'id_room', 'id_room');
    }
}
