<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email_body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_body)
    {
        $this->email_body = $email_body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.contact')
        ->subject('Contact form submitted')
        ->with([
            'email_body' => $this->email_body
        ]);
    }
}
