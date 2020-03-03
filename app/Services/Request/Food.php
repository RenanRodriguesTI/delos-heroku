<?php

    namespace Delos\Dgp\Services\Request;

    use Carbon\Carbon;

    /**
     * Class Food
     * @package Delos\Dgp\Services\Request
     */
    class Food extends ChildRequestDecorator
    {
        /**
         * @param array $data
         *
         * @return mixed
         */
        public function createRequest(array $data)
        {
            $request = $this->request->createRequest($data);

            if ( $this->hasFood($data) ) {
                $request->extraExpenses()->create([
                                                      'description' => 'Alimentação',
                                                      'value'       => $this->getFoodValue($data)
                                                  ]);
            }

            return $request;
        }

        /**
         * Check if has food from date of start and finish
         *
         * @param array $data
         *
         * @return bool
         */
        private function hasFood(array $data): bool
        {
            return isset($data['extra']) && $data['extra']['food']['start'] && $data['extra']['food']['finish'];
        }

        /**
         * Get total of food value from period and amount of collaborators
         *
         * @param array $data
         *
         * @return int
         */
        private function getFoodValue(array $data): int
        {
            $start  = Carbon::createFromFormat('d/m/Y', $data['extra']['food']['start'])->startOfDay();
            $finish = Carbon::createFromFormat('d/m/Y', $data['extra']['food']['finish'])->addDay(2)->startOfDay();

            $days                = $start->diffInDays($finish);
            $collaboratorsAmount = count($data['request']['collaborators']);

            return $days * 60 * $collaboratorsAmount;
        }
    }