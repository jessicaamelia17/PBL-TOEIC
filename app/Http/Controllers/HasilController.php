<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilUjian;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilController extends Controller
{
    public function index()
    {
        $results = HasilUjian::all()->map(function ($result) {
            $total1 = $result->Listening + $result->Reading;
            $total2 = $result->Listening_2 + $result->Reading_2;
            $result->Skor = $total1;
            $result->Skor_2 = $total2;
            $result->Status = $total2 >= 700 ? 'Lulus' : 'Tidak Lulus';
            return $result;
        });

        return view('hasil-ujian.index', compact('results'));
    }


    public function viewPdf($id)
    {
        $hasil = HasilUjian::findOrFail($id);

        $hasil->Skor = $hasil->Listening + $hasil->Reading;
        $hasil->Skor_2 = $hasil->Listening_2 + $hasil->Reading_2;
        $hasil->Status = $hasil->Skor_2 >= 700 ? 'Lulus' : 'Tidak Lulus';

        $pdf = PDF::loadView('Hasil TOEIC.pdf', compact('hasil'));
        return $pdf->stream('Hasil TOEIC'.$hasil->NIM.'.pdf');
    }

    public function downloadPdf($id)
    {
        $hasil = HasilUjian::findOrFail($id);

        $hasil->Skor = $hasil->Listening + $hasil->Reading;
        $hasil->Skor_2 = $hasil->Listening_2 + $hasil->Reading_2;
        $hasil->Status = $hasil->Skor_2 >= 700 ? 'Lulus' : 'Tidak Lulus';

        $pdf = PDF::loadView('Hasil TOEIC.pdf', compact('hasil'));
        return $pdf->download('Hasil TOEIC'.$hasil->NIM.'.pdf');
    }
}