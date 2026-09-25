<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(string $otp, string $resetUrl)
    {
        $this->otp      = $otp;
        $this->resetUrl = $resetUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address') ?: config('auth.admin_email', 'mahaconstructions2013@gmail.com');
        $fromName    = config('mail.from.name') ?: 'Maha Construction';

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Admin Password Reset',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-password-reset',
            text: 'emails.admin-password-reset-text',
            with: [
                'otp'      => $this->otp,
                'resetUrl' => $this->resetUrl,
            ],
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
