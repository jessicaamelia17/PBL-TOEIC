<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalUjianModel extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ujian';
    protected $primaryKey = 'Id_Jadwal'; // sudah benar

    protected $fillable = [
        'Tanggal_Ujian',
        'kuota_max',
        'kuota_terpakai',
        'status_registrasi',
    ];

    public $timestamps = true;

    // Tambahkan ini agar route binding pakai ID_Jadwal, bukan 'id'
    public function getRouteKeyName()
    {
        return 'ID_Jadwal';
    }
}
