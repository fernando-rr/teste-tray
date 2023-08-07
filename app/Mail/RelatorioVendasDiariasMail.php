<?php

namespace App\Mail;

use App\DTOs\Vendas\VendasRelatorioDiarioDTO;
use App\Models\Venda;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RelatorioVendasDiariasMail extends Mailable
{
    use Queueable, SerializesModels;

    public $relatorioDiario;

    /**
     * Create a new message instance.
     */
    public function __construct(VendasRelatorioDiarioDTO $relatorioDiario)
    {
        $this->relatorioDiario = $relatorioDiario;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Relatorio de vendas diárias',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: '/mail/relatorios.vendas-diarias',
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
