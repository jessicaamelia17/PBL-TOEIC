<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiUjianModel extends Model
{
    use HasFactory;

    protected $table = 'sesi_ujian';
    protected $primaryKey = 'id_sesi';
    public $timestamps = true;

    protected $fillable = [
        'id_jadwal',
        'nama_sesi',
        'waktu_mulai',
        'waktu_selesai',
    ];

    // Relasi ke jadwal ujian
    public function jadwal()
    {
        return $this->belongsTo(JadwalUjianModel::class, 'Id_Jadwal', 'Id_Jadwal');
    }

    // Relasi ke room ujian
    public function rooms()
    {
        return $this->hasMany(RoomUjianModel::class, 'id_sesi', 'id_sesi');
    }

    
}
