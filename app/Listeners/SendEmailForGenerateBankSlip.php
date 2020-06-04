<?php

namespace Delos\Dgp\Listeners;

use Carbon\Carbon;
use Delos\Dgp\Entities\Event;
use Delos\Dgp\Events\BillingToDo;
use Delos\Dgp\Repositories\Contracts\HolidayRepository;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailForGenerateBankSlip
{

    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {

        $this->mailer = $mailer;
    }
    /**
     * Handle the event.
     *
     * @param  BillingToDo  $event
     * @return void
     */
    public function handle(BillingToDo $event)
    {
        $paymentInformation = $event->paymentInformation;
        $paymentTransaction = $event->paymentTransaction;
        $billingDate = $this->getDueDateToBankSlip($paymentTransaction->billing_date);

        $this->mailer->send('emails.generate-bank-slip', compact('paymentTransaction', 'paymentInformation', 'billingDate'), function (Message $message) {
            $subject = "Cobrança para fazer";

            foreach ($this->getReceivers() as $receiver) {
                // $message->to($receiver['email'], $receiver['name']);
                //Não comitar arquivo
                $message->to(env('TEST_DESTINATION_EMAIL'), $receiver['name']);
            }
            $message->priority(5);
            $message->subject($subject);
        });
    }

    private function getReceivers()
    {
        return app(Event::class)->where('name', 'signed-plan')->get()->first()->users->toArray();
    }

    /**
     * Getting correct due date from day generated bank slip
     * @param Carbon $date
     * @return Carbon
     */
    public function getDueDateToBankSlip(Carbon $date): Carbon
    {
        $date = $date->now()->addDay(3);
        $holidays = $this->getHolidays();

        if ($date->isSaturday()) {
            $date->addDay(1);
        }else if ($date->isSunday()) {
            $date->addDay(2);
        }else if ($date->isMonday()) {
            $date->addDay(2);
        }else if ($date->isTuesday()) {
            $date->addDay(1);
        }

        while ($holidays->contains($date->format('Y-m-d'))) {
            $date->addDay();
        }

        return $date;
    }

    private function getHolidays()
    {
        $holidays = app(HolidayRepository::class)
            ->pluck('date')
            ->map(function ($item) {
                return $item->format('Y-m-d');
            });
        return $holidays;
    }
}
