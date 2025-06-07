<?php

namespace App\Mail;


use App\Models\PendaftarModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\RegistrasiModel;
use Illuminate\Support\Facades\Log;



class InfoUjianMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $peserta;

    public function __construct(RegistrasiModel $peserta)
    {
        $this->peserta = $peserta;
    }

    public function build()
    {
        Log::info('Menyiapkan email untuk: ' . $this->peserta->mahasiswa->email);
        return $this->subject('Informasi Jadwal Ujian TOEIC')
                    ->markdown('emails.info_ujian');
    }



    /**
     * Get the message envelope.
     */
    
}
