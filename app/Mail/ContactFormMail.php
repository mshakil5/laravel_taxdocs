<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $array;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    
     public function __construct($array)
     {
         $this->array = $array;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    
    public function build()
    {
        return $this->from('info@taxdocs.co.uk', 'Taxdocs')
        ->to($this->array['contactmail'], 'Taxdocs')
        ->subject('New contact message form Taxdocs')
        ->replyTo('kmushakil22@gmail.com')
        ->markdown('emails.contactmail');

    }
}
