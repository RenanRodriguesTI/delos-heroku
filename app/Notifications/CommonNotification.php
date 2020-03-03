<?php

namespace Delos\Dgp\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Pusher\Pusher;

class CommonNotification extends Notification
{
    use Queueable, PusherTrait;
    /**
     * @var Pusher
     */
    private $pusher;
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new notification instance.
     *
     * @param Pusher $pusher
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [PusherChannel::class, 'database'];
    }

    public function toPusher($notifiable)
    {
        $eventName = env('APP_ENV') == 'production' ? 'notificationsOnProduction' : 'notificationsOnLocal';
        return $this->pusher()->trigger('notifications', $eventName, $this->data);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        unset($this->data['user']);
        return [
            $this->data
        ];
    }
}
