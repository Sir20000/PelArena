<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ServerPurchased extends Mailable
{
    use Queueable, SerializesModels;

    public $serverDetails;

    public function __construct($serverDetails)
    {
        $this->serverDetails = $serverDetails;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Demo Email Subject',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.server_purchased',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
