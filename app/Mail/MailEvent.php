<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailEvent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('c11e1f8be0-aa6419@inbox.mailtrap.io', 'Mailtrap')
            ->subject('Event Purchase')
            ->view('event-mail-detail')
            ->with(
                [
                    "transaction" => $this->transaction
                ]
            );
    }
}
