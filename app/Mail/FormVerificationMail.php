<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use \Linkeys\UrlSigner\Facade\UrlSigner;

class FormVerificationMail extends Mailable
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
        $link = UrlSigner::generate(route('form.verification', ['username' => ($this->username)]), [], null, 1);
        $url = $link->getFullUrl();
        return $this->markdown('mail.form-verification-mail', ['url' => $url, 'username' => $this->username]);
    }
}
