<!DOCTYPE html>
<html>
<head>
    <title>Hasil TOEIC</title>
    <style>
        body { font-family: sans-serif; line-height: 1.5; }
        .content { width: 80%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 6px 10px; border: 1px solid #000; text-align: left; }
    </style>
</head>
<body>
    <div class="content">
        <div class="header">
            <h2>Hasil Ujian TOEIC</h2>
        </div>
        <p><strong>Nama:</strong> {{ $hasil->Nama }}</p>
        <p><strong>NIM:</strong> {{ $hasil->NIM }}</p>
        <table>
            <tr><th>Listening 1</th><td>{{ $hasil->Listening }}</td></tr>
            <tr><th>Reading 1</th><td>{{ $hasil->Reading }}</td></tr>
            <tr><th>Skor 1</th><td>{{ $hasil->Skor }}</td></tr>
            <tr><th>Listening 2</th><td>{{ $hasil->Listening_2 }}</td></tr>
            <tr><th>Reading 2</th><td>{{ $hasil->Reading_2 }}</td></tr>
            <tr><th>Skor 2</th><td>{{ $hasil->Skor_2 }}</td></tr>
            <tr><th>Status</th><td>{{ $hasil->Status }}</td></tr>
        </table>
    </div>
</body>
</html>