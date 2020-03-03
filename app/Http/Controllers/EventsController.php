<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 28/07/17
 * Time: 15:17
 */

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Entities\Event;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    private $model;
    private $request;

    public function __construct(Event $event, Request $request)
    {
        $this->model = $event;
        $this->request = $request;
    }

    public function index()
    {
        $events = $this->model->orderBy('name', 'asc')->paginate(10);
        return view('events.index', compact('events'));
    }

    public function emails(int $id)
    {
        $event = $this->model->find($id);

        $users = $this->getUsersToAdd($event);

        return view('events.emails', compact('event', 'users'));
    }

    public function addEmail(int $id)
    {
        $this->validate($this->request, [
            'users' => 'required|exists:users,id'
        ]);

        foreach ($this->request->get('users') as $UserId) {
            $this->model->find($id)->users()->attach($UserId);
        }

        return redirect()->route('events.emails', ['id' => $id]);
    }

    public function removeEmail(int $id, int $userId)
    {
        $this->model->find($id)->users()->detach($userId);

        return redirect()->route('events.emails', ['id' => $id]);
    }

    /**
     * Get possible users to attach in a event
     * @param $event
     * @return mixed
     */
    private function getUsersToAdd($event)
    {
        $users = app(UserRepository::class)->findWhereNotIn('id', $event->users->pluck('id')->toArray())
            ->pluck('name', 'id');
        return $users;
    }
}