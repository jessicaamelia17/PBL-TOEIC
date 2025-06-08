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
    public function jadwal() {
        return $this->belongsTo(JadwalUjianModel::class, 'id_Jadwal', 'Id_Jadwal');
    }
    public function riwayat()
    {
        return $this->hasOne(RiwayatPendaftar::class, 'ID_Pendaftaran', 'Id_Pendaftaran');
    }
    public function hasil()
{
    return $this->hasOne(HasilUjian::class, 'Id_Pendaftaran', 'Id_Pendaftaran');
}

public function sesi()
{
    return $this->belongsTo(SesiUjianModel::class, 'id_sesi', 'id_sesi');
}
public function room()
{
    return $this->belongsTo(RoomUjianModel::class, 'id_room', 'id_room');
}


// Di Hasil.php
public function pengambilanSertifikat()
{
    return $this->hasOne(PengambilanSertifikat::class, 'ID_Hasil', 'Id_Hasil');
}
    





}
