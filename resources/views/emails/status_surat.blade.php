@component('mail::message')
# Status Pengajuan Surat TOEIC

Halo {{ $nama }},

Pengajuan surat TOEIC Anda telah **{{ strtoupper($status) }}**.

@if($status == 'disetujui')
Silakan unduh surat Anda melalui portal TOEIC.
@else
Silakan periksa kembali data dan unggah ulang sesuai instruksi.
@endif

@isset($catatan)
> **Catatan:** {{ $catatan }}
@endisset

@component('mail::button', ['url' => url('/pengajuan')])
Lihat Pengajuan
@endcomponent

Terima kasih.

UPA TOEIC
@endcomponent
