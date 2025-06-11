<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Surat Pengajuan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Daftar Surat Pengajuan</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Tanggal Pengajuan</th>
                <th>Status Verifikasi</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuan as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->NIM }}</td>
                <td>{{ $item->mahasiswa->nama ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}</td>
                <td>{{ ucfirst($item->status_verifikasi) }}</td>
                <td>{{ $item->catatan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
