<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin'; // atau 'admins' sesuai nama tabel Anda

    protected $primaryKey = 'Id_Admin'; // jika pakai primary key custom


    protected $fillable = [
        'Username',
        'Password',
    ];

    protected $hidden = [
        'Password',
    ];

    public function getAuthIdentifierName()
    {
        return 'Username';
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->primaryKey);
    }
}
