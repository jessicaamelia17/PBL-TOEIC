<!DOCTYPE html>
<html>
<head>
    <title>Daftar Hasil Ujian</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3>Daftar Hasil Ujian TOEIC</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Listening 1</th>
                <th>Reading 1</th>
                <th>Total Skor 1</th>
                <th>Listening 2</th>
                <th>Reading 2</th>
                <th>Total Skor 2</th>
                <th>Tanggal Ujian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ optional($row->mahasiswa)->nama ?? '-' }}</td>
                    <td>{{ $row->NIM }}</td>
                    <td>{{ $row->listening_1 }}</td>
                    <td>{{ $row->reading_1 }}</td>
                    <td>{{ $row->total_skor_1 }}</td>
                    <td>{{ $row->Listening_2 }}</td>
                    <td>{{ $row->Reading_2 }}</td>
                    <td>{{ $row->total_skor_2 }}</td>
                    <td>
                        {{ optional($row->jadwal)->Tanggal_Ujian 
                            ? \Carbon\Carbon::parse($row->jadwal->Tanggal_Ujian)->format('d-m-Y') 
                            : '-' }}
                    </td>
                    <td>{{ $row->Status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>