<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'Id_Admin';
    public $timestamps = false;

    protected $fillable = ['Username', 'Password'];
}
