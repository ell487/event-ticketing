<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketAvailableNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $event;

    public function __construct($user, $event) {
        $this->user = $user;
        $this->event = $event;
    }

    public function build() {
        return $this->subject('Kabar Gembira! Tiket Tersedia Lagi')
                    ->html("<h1>Halo {$this->user->name}!</h1>
                            <p>Tiket untuk event <strong>{$this->event->title}</strong> baru saja tersedia lagi karena ada update.</p>
                            <p>Buruan beli sekarang sebelum diambil orang lain!</p>
                            <a href='".route('user.events.show', $this->event->id)."'>Klik di sini untuk beli tiket</a>");
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Available Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
