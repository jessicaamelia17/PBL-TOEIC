<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilUjian;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilController extends Controller
{
    public function index()
    {
        $results = HasilUjian::all()->map(function ($r) {
            $r->Skor = $r->Listening + $r->Reading;
            $r->Skor_2 = $r->Listening_2 + $r->Reading_2;
            $r->Status = $r->Skor_2 >= 700 ? 'Lulus' : 'Tidak Lulus';
            return $r;
        });

        return view('hasil-ujian.index', compact('results'));
    }

    public function viewPdf($id)
    {
        $hasil = HasilUjian::findOrFail($id);
        $hasil->Skor = $hasil->Listening + $hasil->Reading;
        $hasil->Skor_2 = $hasil->Listening_2 + $hasil->Reading_2;
        $hasil->Status = $hasil->Skor_2 >= 700 ? 'Lulus' : 'Tidak Lulus';

        $pdf = PDF::loadView('pdf.hasil-individu', compact('hasil'));
        return $pdf->stream('Hasil_TOEIC_' . $hasil->NIM . '.pdf');
    }

    public function downloadPdf($id)
    {
        $hasil = HasilUjian::findOrFail($id);
        $hasil->Skor = $hasil->Listening + $hasil->Reading;
        $hasil->Skor_2 = $hasil->Listening_2 + $hasil->Reading_2;
        $hasil->Status = $hasil->Skor_2 >= 700 ? 'Lulus' : 'Tidak Lulus';

        $pdf = PDF::loadView('pdf.hasil-individu', compact('hasil'));
        return $pdf->download('Hasil_TOEIC_' . $hasil->NIM . '.pdf');
    }

    public function viewAllPdf()
    {
        $results = HasilUjian::all()->map(function ($r) {
            $r->Skor = $r->Listening + $r->Reading;
            $r->Skor_2 = $r->Listening_2 + $r->Reading_2;
            $r->Status = $r->Skor_2 >= 700 ? 'Lulus' : 'Tidak Lulus';
            return $r;
        });

        $pdf = PDF::loadView('pdf.hasil-semua', compact('results'));
        return $pdf->stream('Hasil_Semua_TOEIC.pdf');
    }

    public function downloadAllPdf()
    {
        $results = HasilUjian::all()->map(function ($r) {
            $r->Skor = $r->Listening + $r->Reading;
            $r->Skor_2 = $r->Listening_2 + $r->Reading_2;
            $r->Status = $r->Skor_2 >= 700 ? 'Lulus' : 'Tidak Lulus';
            return $r;
        });

        $pdf = PDF::loadView('pdf.hasil-semua', compact('results'));
        return $pdf->download('Hasil_Semua_TOEIC.pdf');
    }
}