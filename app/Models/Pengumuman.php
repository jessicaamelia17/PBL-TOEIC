<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';
    protected $primaryKey = 'Id_Pengumuman';
    public $timestamps = true;

    protected $fillable = [
        'Judul',
        'Isi',
        'Tanggal_Pengumuman',
        'Created_By',
    ];
}

