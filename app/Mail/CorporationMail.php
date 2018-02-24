<?php

namespace App\Mail;

use App\Corporation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CorporationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $corporation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Corporation $corp)
    {
        $this->corporation = $corp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('locum@example.com')
            ->view('email.corporation')->with([
                'corporation_name' => $this->corporation->name,
            ]);
    }
}
