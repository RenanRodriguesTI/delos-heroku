<?php

namespace Delos\Dgp\Events;

use Delos\Dgp\Entities\PaymentInformation;
use Delos\Dgp\Entities\PaymentTransaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BillingToDo
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var PaymentInformation
     */
    public $paymentInformation;
    /**
     * @var PaymentTransaction
     */
    public $paymentTransaction;

    /**
     * Create a new event instance.
     *
     * @param PaymentInformation $paymentInformation
     * @param PaymentTransaction $paymentTransaction
     */
    public function __construct(PaymentInformation $paymentInformation = null, PaymentTransaction $paymentTransaction)
    {
        $this->paymentInformation = $paymentInformation;
        $this->paymentTransaction = $paymentTransaction;
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
