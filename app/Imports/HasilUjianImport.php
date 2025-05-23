<?php

namespace App\Imports;

use App\Models\HasilUjian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HasilUjianImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new HasilUjian([
            'Nama' => $row['nama'] ?? null,
            'NIM' => $row['nim'] ?? null,
            'Listening_1' => $row['listening_1'] ?? 0,
            'Reading_1' => $row['reading_1'] ?? 0,
            'Skor_1' => $row['skor_1'] ?? 0,
            'Listening_2' => $row['listening_2'] ?? 0,
            'Reading_2' => $row['reading_2'] ?? 0,
            'Skor_2' => $row['skor_2'] ?? 0,
            'Tanggal_Ujian' => $row['tanggal_ujian'] ?? null,
            'Status' => $row['status'] ?? null,
        ]);
    }
}