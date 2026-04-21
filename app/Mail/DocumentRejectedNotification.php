<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentRejectedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $user, public $document, public $application)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: '❌ Document Rejected - ' . $this->document->document_type,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.document-rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
