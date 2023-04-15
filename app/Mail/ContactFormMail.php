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
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Contact Form Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
    public function build()
    {
        
        // return $this->view('emails.contactmail')
        //              ->from($this->array['from'],'TaxDocs Contact Mail')
        //              ->cc($this->array['cc'])
        //              ->to($this->array['cc'], 'TaxDocs Contact Mail')
        //              ->replyTo($this->array['cc'],'TaxDocs Contact Mail')
        //              ->subject($this->array['subject']);

        // return $this->from('info@taxdocs.co.uk','TaxDocs Contact Mail')
		//     ->to('info@taxdocs.co.uk', 'TaxDocs Contact Mail')
        //     ->view('emails.contactmail')
        //     ->with([
        //         'contact' => $this->array
        //     ]);

        return $this->from('info@eminentint.com', 'TaxDocs Contact Mail')
        ->subject('New mail form TaxDocs Contact Mail')
        ->replyTo($this->array['from'])
        ->markdown('emails.contactmail');

    }
}
