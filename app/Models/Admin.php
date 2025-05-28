<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin'; // Sesuaikan jika tabelnya 'admins'

    protected $primaryKey = 'Id_Admin'; // Jika memang primary key-nya ini

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'Id_Admin'; // Pastikan field ini unik
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
