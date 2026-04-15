<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hore! Pembayaran Tiket Lo Dikonfirmasi 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket_paid', // Ini ngarah ke file view HTML email
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
