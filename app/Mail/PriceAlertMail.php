<?php

namespace App\Mail;

use App\Models\PriceAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $priceAlert;
    public $currentPrice;

    /**
     * Create a new message instance.
     */
    public function __construct(PriceAlert $priceAlert, float $currentPrice)
    {
        $this->priceAlert = $priceAlert;
        $this->currentPrice = $currentPrice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎮 Alerta de Preço: ' . $this->priceAlert->product->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.price-alert',
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