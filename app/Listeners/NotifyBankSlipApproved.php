<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Delos\Dgp\Events\BankSlipApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyBankSlipApproved
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * Create the event listener.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  BankSlipApproved  $event
     * @return void
     */
    public function handle(BankSlipApproved $event)
    {
        $transaction = $event->paymentTransaction;

        $this->mailer->send('emails.approved-bank-slip', compact('transaction'), function (Message $message) use ($transaction) {
            $subject = "Recebemos seu pagamento";

            $message->to($transaction->groupCompany->paymentInformation->email, $transaction->groupCompany->paymentInformation->name);
            $message->subject($subject);
        });
    }
}
