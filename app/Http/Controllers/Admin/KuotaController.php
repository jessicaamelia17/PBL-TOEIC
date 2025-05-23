<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KuotaController extends Controller
{
    public function update(Request $request)
    {

        $request->validate([
            'kuota_total' => 'required|integer|min:0',
            'status_pendaftaran' => 'required|boolean',
        ]);

        DB::table('kuota')->where('id', 1)->update([
            'kuota_total' => $request->kuota_total,
            'status_pendaftaran' => $request->status_pendaftaran,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Kuota berhasil diperbarui!');
    }
}