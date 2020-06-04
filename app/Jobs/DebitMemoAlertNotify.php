<?php

namespace Delos\Dgp\Jobs;

use Delos\Dgp\Entities\DebitMemo;
use Delos\Dgp\Mail\DebitMemoAlertExceedsEmail;
use Delos\Dgp\Notifications\PusherTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class DebitMemoAlertNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, PusherTrait;
    /**
     * @var DebitMemo
     */
    private $debitMemo;

    /**
     * Create a new job instance.
     *
     * @param DebitMemo $debitMemo
     */
    public function __construct(DebitMemo $debitMemo)
    {
        $this->debitMemo = $debitMemo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $alerts = $this->debitMemo->alerts;

        foreach ($alerts as $alert) {
            if ($this->debitMemo->value_total_without_mask > $alert->value_without_mask) {

                $this->sendEmail($alert);
                $this->sendNotification($alert);

                $alert->delete();
            }
        }
    }

    /**
     * Send Pusher notification
     * @param $alert
     */
    private function sendNotification($alert): void
    {
        $title = "O valor da ND{$this->debitMemo->code} passou de R$ {$alert->value}";
        $data = [
            'debitMemoCode' => $this->debitMemo->code,
            'debitMemoValue' => $this->debitMemo->value_total,
            'alertValue' => $alert->value
        ];

        $this->notify($alert->user, $title, "O valor atual da ND é de R$ {$this->debitMemo->value_total}", 'emails.debit-memo-alert-trigged', $data);
    }

    /**
     * @param $alert
     */
    private function sendEmail($alert): void
    {
        $data = [
            'debitMemoCode' => $this->debitMemo->code,
            'debitMemoValue' => $this->debitMemo->value_total,
            'alertValue' => $alert->value
        ];

        app(Mailer::class)->send('emails.debit-memo-alert-trigged', $data, function (Message $message) use ($alert) {
            $message->subject("O valor da ND{$this->debitMemo->code} passou de R$ {$alert->value}");
            $message->to(env('TEST_DESTINATION_EMAIL'));
        });
    }
}
