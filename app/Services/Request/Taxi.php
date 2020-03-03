<?php

    namespace Delos\Dgp\Services\Request;

    /**
     * Class Taxi
     * @package Delos\Dgp\Services\Request
     */
    class Taxi extends ChildRequestDecorator
    {
        /**
         * @param array $data
         *
         * @return mixed
         */
        public function createRequest(array $data)
        {
            $request = $this->request->createRequest($data);

            if ( $this->hasTaxi($data) ) {

                $request->extraExpenses()->create([
                                                      'description' => 'Taxi',
                                                      'value'       => $data['extra']['taxi']['value'],
                                                  ]);
            }

            return $request;
        }

        /**
         * Check if has taxi from value
         *
         * @param array $data
         *
         * @return mixed
         */
        private function hasTaxi(array $data)
        {
            return isset($data['extra']) && $data['extra']['taxi']['value'];
        }
    }