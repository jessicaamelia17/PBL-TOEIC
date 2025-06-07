<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusSuratMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $status;
    public $catatan;

    public function __construct($nama, $status, $catatan)
    {
        $this->nama = $nama;
        $this->status = $status;
        $this->catatan = $catatan;
    }

    public function build()
    {
        return $this->subject('Status Pengajuan Surat TOEIC Anda')
                    ->markdown('emails.status_surat');
    }
}
