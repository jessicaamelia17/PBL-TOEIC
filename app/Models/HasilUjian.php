<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujian'; // Nama tabel di database

    protected $primaryKey = 'Id_Hasil'; // Primary key tabel (jika tidak 'id')

    protected $fillable = [
        'NIM',
        'Skor',
        'Tanggal_Ujian',
        'Status', 
    ];

    public $timestamps = true; // Gunakan timestamps jika tabel pakai created_at & updated_at
}
