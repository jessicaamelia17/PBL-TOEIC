<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim'; // NIM sebagai primary key
    public $incrementing = false; // Karena NIM bukan auto-increment

    protected $fillable = ['nim', 'nama', 'email', 'no_hp', 'Id_Jurusan', 'Id_Prodi', 'alamat', 'photo', 'tmpt_lahir', 'TTL'];

    public function user()
    {
        return $this->hasOne(User::class, 'nim', 'nim');
    }

    public function jurusan()
    {
        return $this->belongsTo(JurusanModel::class, 'Id_Jurusan', 'Id_Jurusan');
    }

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'Id_Prodi', 'Id_Prodi');
    }
}