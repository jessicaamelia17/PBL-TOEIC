<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiModel extends Model
{
    protected $table = 'prodi';
    protected $primaryKey = 'Id_Prodi';
    public $timestamps = false;

    public function jurusan()
    {
        return $this->belongsTo(JurusanModel::class, 'Id_Jurusan');
    }
}
