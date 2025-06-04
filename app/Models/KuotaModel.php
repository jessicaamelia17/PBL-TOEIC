<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaModel extends Model
{
    protected $table = 'kuota';
    protected $fillable = ['kuota_total', 'status_pendaftaran'];

    public function jadwal()
    {
        return $this->hasMany(JadwalUjianModel::class, 'id_kuota');
    }
}
