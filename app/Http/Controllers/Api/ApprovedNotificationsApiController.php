<?php

namespace Delos\Dgp\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Repositories\Contracts\ApprovedNotificationRepository;
use Carbon\Carbon;
use Exception;

class ApprovedNotificationsApiController extends Controller
{
    public function allByUser(Request $request, int $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'date' => 'date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'found' => false,
                    'message' => $validator->getMessageBag()
                ], 422);
            }

            $date = $request->input('date') ? Carbon::parse( $request->input('date')): null;

            $approvedNotifications = app(ApprovedNotificationRepository::class)->skipPresenter(false)->scopeQuery(function ($query) use ($id, $date) {
                if ($date) {
                    return $query->where('created_at', '>=', $date)
                    ->where('user_id', $id)
                    ->orderBy('created_at', 'desc');
                }
                return $query->where('user_id', $id)
                    ->orderBy('created_at', 'desc');
            })->all();

            if (count($approvedNotifications['data']) ==0) {
                return response()->json([
                    'found' => false,
                    'message' => 'not found Approved Notifications ',
                ], 404);
            }

            return response()->json([
                'found' => true,
                'approvedNotifications' => $approvedNotifications['data']
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'found' => false,
                'message' => 'error internal server'
            ], 500);
        }
    }

    public function approvedByUser(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'found' => false,
                    'message' => $validator->getMessageBag()
                ], 422);
            }

            $date = $request->input('date') ? Carbon::parse( $request->input('date')): null;

            $approvedNotifications = app(ApprovedNotificationRepository::class)
                ->skipPresenter(false)
                ->scopeQuery(function ($query) use ($id, $date) {
                    if ($date) {
                        return $query->where('created_at', '>=', $date)
                        ->where('user_id', $id)
                        ->where('approved',true)
                        ->orderBy('created_at', 'desc');
                    }
                    return $query->where('user_id', $id)
                        ->where('approved',true)
                        ->orderBy('created_at', 'desc');
                })->all();

            if (count($approvedNotifications['data']) ==0) {
                return response()->json([
                    'found' => false,
                    'message' => 'not found Approved Notifications'
                ], 404);
            }

            return response()->json([
                'found' => true,
                'approvedNotifications' => $approvedNotifications['data']
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'found' => false,
                'message' => 'error internal server'
            ], 500);
        }
    }

    public function reprovedByUser(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'date'
            ]);

            $date = $request->input('date') ? Carbon::parse( $request->input('date')): null;

            if ($validator->fails()) {
                return response()->json([
                    'found' => false,
                    'message' => $validator->getMessageBag()
                ], 422);
            }


            $approvedNotifications = app(ApprovedNotificationRepository::class)
                ->skipPresenter(false)
                ->scopeQuery(function ($query) use ($id, $date) {
                    if ($date) {
                        return $query->where('created_at', '>=', $date)
                        ->where('user_id', $id)
                        ->where('approved',false)
                        ->orderBy('created_at', 'desc');
                    }
                    return $query->where('user_id', $id)
                        ->where('approved',false)
                        ->orderBy('created_at', 'desc');
                })->all();

            if (count($approvedNotifications['data']) ==0) {
                return response()->json([
                    'found' => false,
                    'message' => 'not found Approved Notifications'
                ], 404);
            }

            return response()->json([
                'found' => true,
                'approvedNotifications' => $approvedNotifications['data']
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'found' => false,
                'message' => 'error internal server'
            ], 500);
        }
    }
}
