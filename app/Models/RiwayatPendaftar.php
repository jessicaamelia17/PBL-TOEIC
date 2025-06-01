<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendaftar extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pendaftar'; // pastikan nama tabel benar
    protected $primaryKey = 'Id_Riwayat';   // sesuaikan dengan kolom PK
    protected $fillable = [
        'ID_Pendaftaran',
        'ID_Jadwal',
        'ID_Hasil',
        'id_pengambilan',
        'created_at',
        'updated_at',

    ];

    public $timestamps = false;

    // Relasi ke tabel pendaftaran (misal: PendaftaranToeic)
    public function pendaftaran()
    {
        return $this->belongsTo(PendaftarModel::class, 'ID_Pendaftaran', 'Id_Pendaftaran');
    }

    // Relasi ke tabel jadwal (misal: JadwalUjian)
    public function jadwal()
    {
        return $this->belongsTo(JadwalUjianModel::class, 'ID_Jadwal', 'Id_Jadwal');
    }

    // Relasi ke tabel hasil (misal: HasilUjian)
    public function hasil()
    {
        return $this->belongsTo(HasilUjian::class, 'ID_Hasil', 'Id_Hasil');
    }

    // Relasi ke tabel pengambilan sertifikat (misal: Sertifikat)
    public function sertifikat()
    {
        return $this->hasOne(PengambilanSertifikat::class, 'id_pengambilan', 'id_pengambilan');
    }
}