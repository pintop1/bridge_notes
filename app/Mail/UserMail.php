<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $my_msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($my_msg)
    {
        $this->my_msg = $my_msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->my_msg['subject'])
            ->view('mail.general');
    }
}
