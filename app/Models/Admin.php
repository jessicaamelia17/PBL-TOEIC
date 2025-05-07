<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin'; // atau 'admins' sesuai nama tabel Anda

    protected $primaryKey = 'Id_Admin'; // jika pakai primary key custom

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
