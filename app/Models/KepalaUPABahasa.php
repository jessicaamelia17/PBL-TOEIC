<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaUPABahasa extends Model
{
    use HasFactory;
    protected $table = 'kepala_upa_bahasa';

    protected $fillable = [
        'nama', 'nip', 'pangkat', 'jabatan', 'ttd_path', 'is_active'
    ];
}
