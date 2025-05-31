<!DOCTYPE html>
<html>
<head>
    <title>Daftar Sertifikat</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3>Daftar Mahasiswa Pengambilan Sertifikat TOEIC </h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Program Studi</th>
                <th>Tanggal Diambil</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sertifikats as $index => $item)
                @php $mahasiswa = $item->hasilUjian->mahasiswa ?? null; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mahasiswa->nama ?? '-' }}</td>
                    <td>{{ $mahasiswa->nim ?? '-' }}</td>
                    <td>{{ $mahasiswa->prodi->Nama_Prodi ?? '-' }}</td>
                    <td>
                        @if($item->Tanggal_Diambil && $item->Tanggal_Diambil != '0000-00-00')
                            {{ date('d-m-Y', strtotime($item->Tanggal_Diambil)) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->Status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>