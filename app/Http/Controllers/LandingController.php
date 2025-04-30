<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class LandingController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::orderBy('Tanggal_Pengumuman', 'desc')->get();

        return view('welcome', compact('pengumuman'));
    }
}
