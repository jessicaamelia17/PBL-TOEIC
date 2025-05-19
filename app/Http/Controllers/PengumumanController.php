<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{

public function index()
{
    $pengumuman = Pengumuman::orderBy('Tanggal_Pengumuman', 'desc')->paginate(10);
    return view('pengumuman.index', compact('pengumuman'));
}


public function show($id)
{
    $pengumuman = \App\Models\Pengumuman::findOrFail($id);
    return view('pengumuman.show', compact('pengumuman'));
}


}
