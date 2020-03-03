<?php

namespace Delos\Dgp\Services\Request;

use Carbon\Carbon;

/**
 * Class Car
 * @package Delos\Dgp\Services\Request
 */
class Car extends ChildRequestDecorator
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function createRequest(array $data)
    {
        $request = $this->request->createRequest($data);

        if (isset($data['has_car'])) {
            $carData = $data['car'];
            $request->car()->create([
                'car_type_id'      => $carData['car_type_id'],
                'withdrawal_date'  => $this->getDateTime($carData['withdrawal_date'], $carData['withdrawal_hour']),
                'return_date'      => $this->getDateTime($carData['return_date'], $carData['return_hour']),
                'withdrawal_place' => $carData['withdrawal_place'] ?? '',
                'return_place'     => $carData['return_place'] ?? '',
                'first_driver_id'  => $carData['first_driver_id'],
                'client_pay'       => $carData['client_pay'] ?? false
            ]);
        }

        return $request;
    }

    private function getDateTime(string $date, string $time)
    {
        $date     = "{$date} {$time}";
        $dateTime = Carbon::createFromFormat('d/m/Y h:i a', $date);
        return $dateTime;
    }
}