<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\PaymentTransaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BankSlipApproved
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var PaymentTransaction
     */
    public $paymentTransaction;

    /**
     * Create a new event instance.
     *
     * @param PaymentTransaction $transaction
     * @internal param PaymentTransaction $paymentTransaction
     */
    public function __construct(PaymentTransaction $transaction)
    {
        $this->paymentTransaction = $transaction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
