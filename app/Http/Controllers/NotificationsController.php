<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 14/08/17
 * Time: 15:21
 */

namespace Delos\Dgp\Http\Controllers;

use Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->orderby('id', 'desc')->pluck('data');

        return view('notifications.index', compact('notifications'));
    }
}