<!DOCTYPE html>
<html>
<head>
    <title>Hasil TOEIC Semua Peserta</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Hasil Ujian TOEIC Semua Peserta</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Tanggal Ujian</th>
                <th>Listening 1</th>
                <th>Reading 1</th>
                <th>Skor 1</th>
                <th>Listening 2</th>
                <th>Reading 2</th>
                <th>Skor 2</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $r)
                <tr>
                    <td>{{ $r->pendaftaran->mahasiswa->nama ?? '-' }}</td>
                    <td>{{ $r->pendaftaran->NIM ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->pendaftaran->jadwal->Tanggal_Ujian)->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $r->listening_1 ?? '-' }}</td>
                    <td>{{ $r->reading_1 ?? '-' }}</td>
                    <td>{{ $r->total_skor_1 ?? '-' }}</td>
                    <td>{{ $r->Listening_2 ?? '-' }}</td>
                    <td>{{ $r->Reading_2 ?? '-' }}</td>
                    <td>{{ $r->total_skor_2 ?? '-' }}</td>
                    <td>{{ $r->Status ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
