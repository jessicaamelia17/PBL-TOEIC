<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanModel extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'Id_Jurusan';
    public $timestamps = false;

    public function prodi()
    {
        return $this->hasMany(ProdiModel::class, 'Id_Jurusan');
    }
}
