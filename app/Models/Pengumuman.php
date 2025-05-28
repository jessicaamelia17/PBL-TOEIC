<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengumuman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengumuman';
    protected $primaryKey = 'Id_Pengumuman';
    public $timestamps = true;

    protected $fillable = [
        'Judul',
        'Isi',
        'Tanggal_Pengumuman',
        'Created_By',
        'file_pengumuman',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'Created_By', 'Id_Admin');
    }
}
