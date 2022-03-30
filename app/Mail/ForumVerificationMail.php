<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ForumVerificationMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $username)
    {
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = URL::temporarySignedRoute('forum.verification',now()->addMinutes(5), ['username' => ($this->username)]);
        return $this->markdown('mail.forum-verification-mail', ['url' => $url, 'username' => $this->username]);
    }
}
