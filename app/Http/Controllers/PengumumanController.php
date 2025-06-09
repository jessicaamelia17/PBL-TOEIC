<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::orderBy('Tanggal_Pengumuman', 'desc')->paginate(10);
        $breadcrumb = [
            ['label' => __('users.home'), 'url' => route('landing')],
            ['label' => __('users.announcement'), 'url' => route('pengumuman')],
        ];
        return view('pengumuman.index', compact('pengumuman','breadcrumb'));
    }
    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
         $breadcrumb = [
        ['label' => __('users.home'), 'url' => route('landing')],
        ['label' => __('users.announcement'), 'url' => route('pengumuman')],
        ['label' => $pengumuman->Judul, 'url' => null],
    ];
        return view('pengumuman.show', compact('breadcrumb','pengumuman'));
    }
}
