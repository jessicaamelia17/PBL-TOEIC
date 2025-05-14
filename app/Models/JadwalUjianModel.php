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
        'status_registrasi',
    ];

    public function getRouteKeyName()
    {
        return 'Id_Jadwal';
    }

    public function sesi()
    {
        return $this->hasMany(SesiUjianModel::class, 'Id_Jadwal', 'Id_Jadwal');
    }

        // optional: accessor
    public function getIdJadwalAttribute()
    {
        return $this->attributes['Id_Jadwal'];
    }
}
