<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengambilanSertifikat extends Model
{
    protected $table = 'pengambilan_sertifikat';
    protected $primaryKey = 'id_pengambilan';

    protected $fillable = [
        'Id_Hasil', 'NIM', 'Nama', 'Program_Studi', 'Tanggal_Diambil', 'Status'
    ];
    public function hasilUjian()
    {
        return $this->belongsTo(HasilUjian::class, 'Id_Hasil');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'NIM', 'nim');
    }
    public function riwayat()
{
    return $this->belongsTo(RiwayatPendaftar::class, 'id_pengambilan', 'id_pengambilan');
}

}