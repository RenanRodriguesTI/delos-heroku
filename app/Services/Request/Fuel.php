<?php

    namespace Delos\Dgp\Services\Request;

    /**
     * Class Fuel
     * @package Delos\Dgp\Services\Request
     */
    class Fuel extends ChildRequestDecorator
    {
        /**
         * @param array $data
         *
         * @return mixed
         */
        public function createRequest(array $data)
        {
            $request = $this->request->createRequest($data);

            if ( $this->hasFuel($data) ) {
                $request->extraExpenses()->create([
                                                      'description' => 'Gasolina',
                                                      'value'       => $data['extra']['fuel']['value']
                                                  ]);
            }

            return $request;
        }

        /**
         * Check if has fuel from value
         *
         * @param array $data
         *
         * @return bool
         */
        private function hasFuel(array $data)
        {
            return isset($data['extra']) && $data['extra']['fuel']['value'];
        }
    }