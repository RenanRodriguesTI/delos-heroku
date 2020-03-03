<?php

    namespace Delos\Dgp\Services\Request;

    use Carbon\Carbon;

    /**
     * Class Ticket
     * @package Delos\Dgp\Services\Request
     */
    class Ticket extends ChildRequestDecorator
    {
        /**
         * @param array $data
         *
         * @return mixed
         */
        public function createRequest(array $data)
        {
            $request = $this->request->createRequest($data);

            if ( isset($data['has_ticket']) ) {
                $ticketData = $data['ticket'];
                $ticket     = $request->tickets();

                $ticket->create([
                                    'arrival'         => $this->getDateTime($ticketData['going_arrival_date'], $ticketData['going_arrival_time']),
                                    'from_airport_id' => $ticketData['going_from_airport_id'],
                                    'to_airport_id'   => $ticketData['going_to_airport_id'],
                                    'preview'         => false,
                                    'client_pay'      => $ticketData['client_pay'] ?? false
                                ]);

                $ticket->create([
                                    'arrival'         => $this->getDateTime($ticketData['back_arrival_date'], $ticketData['back_arrival_time']),
                                    'from_airport_id' => $ticketData['back_from_airport_id'],
                                    'to_airport_id'   => $ticketData['back_to_airport_id'],
                                    'preview'         => $ticketData['has_preview'] ?? false,
                                    'client_pay'      => $ticketData['client_pay'] ?? false
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