<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
{
    $results = [
        [
            'name' => 'Deva Selviana',
            'nim' => '2341760060',
            'listening' => 400,
            'reading' => 385,
            'tanggal_ujian' => '2025-04-30',
        ],
        [
            'name' => 'Fachry Akbar Bagaskara',
            'nim' => '234170120',
            'listening' => 350,
            'reading' => 360,
            'tanggal_ujian' => '2025-04-28',
        ],
        [
            'name' => 'Jessica Amelia',
            'nim' => '2341760077',
            'listening' => 420,
            'reading' => 410,
            'tanggal_ujian' => '2025-04-29',
        ],
        [
            'name' => 'Valina Adzra Nora Aqila',
            'nim' => '2341760066',
            'listening' => 370,
            'reading' => 380,
            'tanggal_ujian' => '2025-04-27',
        ],
        [
            'name' => 'Veren Regina Tirsya',
            'nim' => '2341760127',
            'listening' => 430,
            'reading' => 390,
            'tanggal_ujian' => '2025-04-26',
        ],
    ];

    return view('hasil-ujian.index', compact('results'));
    }
}
