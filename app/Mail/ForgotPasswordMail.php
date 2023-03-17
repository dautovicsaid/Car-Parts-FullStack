<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $link;
    protected $flag;

    public function __construct($link, $flag)
    {
        $this->link=$link;
        $this->flag=$flag;
    }



    public function envelope()
    {
        return new Envelope(
            subject: __('mail.password-' . $this->flag),
        );
    }


    public function content()
    {
        return new Content(
            view: 'emails.reset_password',
            with: [
                'link'=>$this->link,
                'flag'=>$this->flag,
            ]
        );
    }


    public function attachments()
    {
        return [];
    }
}
