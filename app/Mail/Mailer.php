<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_data;

    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
    }

    public function build()
    {
        return $this->subject($this->mail_data['subject'])
                    ->view('admin.newsletter.email_temp')
                    ->with('mail_data', $this->mail_data);
    }
}
