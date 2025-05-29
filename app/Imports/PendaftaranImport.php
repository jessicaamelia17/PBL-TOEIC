<?php

namespace App\Imports;

use App\Models\PendaftarModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PendaftaranImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new PendaftarModel([
            'Nama' => $row['nama'] ?? null,
            'No.WA' => $row['no_wa'] ?? null,
            'Email' => $row['email'] ?? null,
            'Jurusan' => $row['jurusan'] ?? null,
            'Prodi' => $row['prodi'] ?? null,
            'Tanggal_Pendaftaran' => $row['tanggal_ujian'] ?? null,
        ]);
    }
}