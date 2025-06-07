@component('mail::message')
# Informasi Jadwal Ujian TOEIC

Halo {{ $peserta->mahasiswa->nama }},

Berikut adalah detail ujian TOEIC Anda:

- **Tanggal:** {{ $peserta->jadwal->Tanggal_Ujian }}
- **Sesi:** {{ $peserta->sesi->nama_sesi ?? '-' }}
- **Room:** {{ $peserta->room->nama_room }}
- **Zoom ID:** {{ $peserta->room->zoom_id }}
- **Zoom Password:** {{ $peserta->room->zoom_password }}

@component('mail::button', ['url' => 'http://localhost/PBL-TOEIC/public/mahasiswa/schedule'])
Lihat Jadwal Ujian
@endcomponent

Semoga sukses!

UPA TOEIC
@endcomponent
