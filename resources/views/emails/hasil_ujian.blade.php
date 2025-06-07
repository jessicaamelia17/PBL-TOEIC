@component('mail::message')
# Hasil Ujian TOEIC

@if($hasil->pendaftaran && $hasil->pendaftaran->mahasiswa)
Halo {{ $hasil->pendaftaran->mahasiswa->nama }},
@else
Halo Peserta TOEIC,
@endif

Berikut adalah hasil ujian TOEIC Anda:

- **Listening:** {{ $hasil->Listening_2 }}
- **Reading:** {{ $hasil->Reading_2 }}
- **Total:** {{ $hasil->total_skor_2 }}

@component('mail::button', ['url' => url('/hasil-ujian')])
Lihat Hasil Lengkap
@endcomponent

Terima kasih atas partisipasi Anda.

UPA TOEIC
@endcomponent
