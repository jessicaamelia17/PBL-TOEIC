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
    ];

    public function jurusan()
    {
        return $this->belongsTo(JurusanModel::class, 'id_Jurusan', 'Id_Jurusan');
    }

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'id_Prodi', 'Id_Prodi');
    }
}
