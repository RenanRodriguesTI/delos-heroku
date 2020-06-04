<?php

namespace Delos\Dgp\Listeners;

use Carbon\Carbon;
use Delos\Dgp\Events\BankSlipGenerated;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class NotifyBankSlipGenerated
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
     * @param  BankSlipGenerated  $event
     * @return void
     */
    public function handle(BankSlipGenerated $event)
    {
        $transaction = $event->paymentTransaction;

        $this->mailer->send('emails.generated-bank-slip', compact('transaction'), function (Message $message) use ($transaction) {
            $subject = "Seu boleto foi gerado (anexo)";

            //Modificação feita para teste não comitar essa classe
            $message->to(env('TEST_DESTINATION_EMAIL'), $transaction->groupCompany->paymentInformation->name);
            // $message->to($transaction->groupCompany->paymentInformation->email, $transaction->groupCompany->paymentInformation->name);
            $message->attachData(Storage::get($this->getFullPath($transaction)), 'boleto.pdf');
            $message->subject($subject);
        });
    }

    private function getFullPath($paymentTransaction): string
    {
        return 'Pdfs/' . $paymentTransaction->groupCompany->id . '/' . Carbon::now()->month . '/' . $paymentTransaction->id . '.pdf';
    }
}
