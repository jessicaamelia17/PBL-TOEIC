<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim'; // NIM sebagai primary key
    public $incrementing = false; // Karena NIM bukan auto-increment
    protected $keyType = 'string';


    protected $fillable = ['nim', 'nama', 'email', 'no_hp', 'Id_Jurusan', 'Id_Prodi', 'alamat', 'photo', 'tmpt_lahir', 'TTL', 'password'];

    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'nim'; // Laravel menggunakan 'nim' sebagai identifier login
    }

    public function getAuthPassword()
    {
        return $this->password;
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
