<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalUjianModel extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ujian';
    protected $primaryKey = 'Id_Jadwal';
    public $timestamps = true;

    protected $fillable = [
        'Tanggal_Ujian',
        'kuota_max',
        'kuota_terpakai',
    ];

    public function getRouteKeyName()
    {
        return 'Id_Jadwal';
    }

    public function sesi()
    {
        return $this->hasMany(SesiUjianModel::class, 'id_jadwal', 'id_jadwal');
    }

        // optional: accessor
    public function getIdJadwalAttribute()
    {
        return $this->attributes['Id_Jadwal'];
    }
        // Relasi ke peserta pendaftaran
    public function peserta()
    {
        return $this->hasMany(RegistrasiModel::class, 'id_jadwal', 'Id_Jadwal');
    }
}
