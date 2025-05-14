<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomUjianModel extends Model
{
    use HasFactory;

    protected $table = 'room_ujian';
    protected $primaryKey = 'id_room';
    public $timestamps = true;

    protected $fillable = [
        'id_sesi',
        'nama_room',
        'zoom_id',
        'zoom_password',
        'kapasitas',
    ];

    // Relasi ke sesi ujian
    public function sesi()
    {
        return $this->belongsTo(SesiUjianModel::class, 'id_sesi', 'id_sesi');
    }

    // Relasi ke peserta pendaftaran
    public function peserta()
    {
        return $this->hasMany(RegistrasiModel::class, 'id_room', 'id_room');
    }


}
