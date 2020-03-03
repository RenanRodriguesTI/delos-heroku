<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 09/08/17
 * Time: 14:32
 */

namespace Delos\Dgp\Notifications;


use Delos\Dgp\Entities\User;
use Pusher\Pusher;

trait PusherTrait
{
    /**
     * @return Pusher
     */
    public function pusher()
    {
        return (new Pusher(env('PUSHER_KEY'), env('PUSHER_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => 'us2',
            'encrypted' => true
        ]));
    }

    /**
     * @param User $userToNotify
     * @param string $title
     * @param string $message
     * @param string $view
     * @param array $compact
     */
    public function notify(User $userToNotify, string $title, string $message, string $view, array $compact) : void
    {
        $userToNotify->notify(new CommonNotification(['title' => $title, 'message' => $message, 'view' => view($view, $compact)->render(), 'userId' => $userToNotify->id]));
    }
}