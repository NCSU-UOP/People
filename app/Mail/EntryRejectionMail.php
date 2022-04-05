<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class EntryRejectionMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $username;
    protected $feedback;
    protected $preferedname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $preferedname, String $username, array $feedback)
    {
        $this->username = $username;
        $this->feedback = $feedback;
        $this->preferedname = $preferedname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = URL::signedRoute('forum.resubmit', ['username' => ($this->username)]);
        return $this->markdown('mail.entry-rejection-mail', ['url' => $url, 'feedback' => ($this->feedback), 'name' => ($this->preferedname)]);

    }
}
