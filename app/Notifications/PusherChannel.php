<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 09/08/17
 * Time: 14:36
 */

namespace Delos\Dgp\Notifications;


use Illuminate\Notifications\Notification;

class PusherChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toPusher($notifiable);
    }
}