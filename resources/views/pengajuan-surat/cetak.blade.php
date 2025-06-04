<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan TOEIC</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm 2cm 1.5cm 2cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .logo {
    float: left;
    width: 80px;
}

        .logo img {
            width: 100px; /* sebelumnya 70px → diperbesar */
            height: auto;
        }

        .instansi {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.3;
        }

        .subinstansi {
            text-align: center;
            font-size: 10pt;
            font-weight: normal;
        }

        hr.garis {
            border: 1px solid black;
            margin: 6px 0 12px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .isi {
            margin-top: 10px;
        }

        .isi table {
            width: 100%;
            margin-top: 5px;
        }

        .isi td {
            vertical-align: top;
            padding-bottom: 4px;
        }

        .paragraf {
            margin: 12px 0;
            text-align: justify;
        }

        .ttd {
            margin-top: 30px;
            text-align: right;
        }

        .lampiran {
            margin-top: 25px;
        }
        .header-text {
    text-align: center;
}
    </style>
</head>
<body>
    <table width="100%" style="margin-bottom: 5px;">
        <tr>
            <td width="15%" align="center">
                <img src="{{ public_path('images/polinema.png') }}" alt="Logo Polinema" style="width: 120px;">
            </td>
            <td width="85%" align="center">
                <div style="font-size: 12pt; font-weight: bold; line-height: 1.4;">
                    KEMENTERIAN PENDIDIKAN TINGGI,<br>
                    SAINS, DAN TEKNOLOGI<br>
                    UNIT PENUNJANG AKADEMIK BAHASA<br>
                    POLITEKNIK NEGERI MALANG
                </div>
                <div style="font-size: 10pt; line-height: 1.3;">
                    Jl. Soekarno Hatta No.9 Malang 65141 |
                    Telp (0341) 404424 – 404425 |
                    Fax (0341) 404420<br>
                    <i>Laman: www.polinema.ac.id</i>
                </div>
            </td>
        </tr>
    </table>
    
    <hr style="border: 2px solid black; margin: 4px 0 10px 0;">
    
    
    

    <div class="judul">
        SURAT KETERANGAN SUDAH MENGIKUTI TOEIC<br>
        <span style="font-weight: normal;">Nomor: ………/PL2. UPA BHS/{{ now()->year }}</span>
    </div>

    <div class="isi">
        <p>Yang bertanda tangan di bawah ini:</p>
        <table>
            <tr><td style="width: 35%;">Nama</td><td>: {{ $kepala->nama }}</td></tr>
            <tr><td>NIP</td><td>: {{ $kepala->nip }}</td></tr>
            <tr><td>Pangkat, Golongan, Ruang</td><td>: {{ $kepala->pangkat }}</td></tr>
            <tr><td>Jabatan</td><td>: {{ $kepala->jabatan }}</td></tr>
        </table>

        <p class="paragraf">Dengan ini menyatakan dengan sesungguhnya bahwa:</p>

        <table>
            <tr><td style="width: 35%;">Nama</td><td>: {{ $pengajuan->mahasiswa->nama }}</td></tr>
            <tr><td>NIM</td><td>: {{ $pengajuan->mahasiswa->nim }}</td></tr>
            <tr><td>Program Studi/Jurusan</td><td>: {{ $pengajuan->mahasiswa->prodi->Nama_Prodi }}</td></tr>
            <tr><td>Tempat, Tanggal Lahir</td><td>: {{ $pengajuan->mahasiswa->tmpt_lahir }}, {{ \Carbon\Carbon::parse($pengajuan->mahasiswa->TTL)->translatedFormat('d F Y') }}</td></tr>
            <tr><td>Alamat</td><td>: {{ $pengajuan->mahasiswa->alamat }}</td></tr>
        </table>

        <p class="paragraf">
            Telah mengikuti ujian TOEIC dan mendapat sertifikat yang diterbitkan oleh ETS sebanyak dua kali,
            dengan nilai di bawah 400 untuk Program D-III dan 450 untuk Program D-IV, dengan bukti sertifikat terlampir (dua berkas).
        </p>

        <p class="paragraf">
            Demikian surat keterangan ini dibuat sebagai pengganti syarat pengambilan ijazah dan agar dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div class="ttd">
        <p>Malang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Kepala UPA Bahasa,</p>
        @if($kepala->ttd_path)
        <img src="{{ public_path('storage/' . $kepala->ttd_path) }}" alt="TTD Kepala" style="width:120px;">
    @endif<br>
        <p><b>{{ $kepala->nama }}</b></p>
        <p>NIP. {{ $kepala->nip }}</p>
    </div>

    <div class="lampiran">
        <p><b>Lampiran:</b> Salinan 2 sertifikat TOEIC yang diterbitkan oleh ETS dan masih berlaku.</p>
    </div>
</body>
</html>
