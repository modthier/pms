<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\UserRequest;

class NewRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserRequest $userRequest)
    {
        $this->userRequest = $userRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.request.new');
    }
}
