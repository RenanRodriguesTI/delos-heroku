<?php

namespace Delos\Dgp\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Repositories\Contracts\HolidayApiRepository;
use Carbon\Carbon;
use Exception;

class HolidayApiController extends Controller
{
    public function year(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'date_format:Y'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'found' => false,
                    'message' => $validator->getMessageBag()
                ], 422);
            }

            $date = $request->input('date') ? Carbon::createFromFormat('Y', $request->input('date')) : Carbon::now();

            $holidays = app(HolidayApiRepository::class)
                ->skipPresenter(false)
                ->scopeQuery(function ($query) use ($date) {
                    return $query->whereRaw("str_to_date(date,'%Y') = str_to_date({$date->format('Y')},'%Y')");
                })->all();

            if (count($holidays['data']) == 0) {
                return response()->json([
                    'found' => false,
                    'message' => 'not found Holidays'
                ], 404);
            }

            return response()->json([
                'found' => true,
                'holidays' => $holidays['data']
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'found' => false,
                'message' => 'error internal server'
            ], 500);
        }
    }
}
