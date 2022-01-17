<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

     /**
     * The order instance.
     *
     * @var \App\Models\Order
     */
    public Order $order;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */

    public function __construct(Order $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Koop Hardware Order Confirmation')
                    ->view('mail.order-mail')
                    ->replyTo('koophardware.onlinestore@gmail.com', 'Koop Hardware Online Store');
    }
}
