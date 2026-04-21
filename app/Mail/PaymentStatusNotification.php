<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $status;
    public $payment;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $status, $payment, $reason = null)
    {
        $this->user = $user;
        $this->status = $status;
        $this->payment = $payment;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status === 'approved' 
            ? '✅ Payment Approved - Legal Bruz'
            : '❌ Payment Rejected - Legal Bruz';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-status',
            with: [
                'user' => $this->user,
                'status' => $this->status,
                'payment' => $this->payment,
                'reason' => $this->reason,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
