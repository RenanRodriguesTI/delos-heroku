<?php

    namespace Delos\Dgp\Services\Request;

    /**
     * Class Toll
     * @package Delos\Dgp\Services\Request
     */
    class Toll extends ChildRequestDecorator
    {
        /**
         * @param array $data
         *
         * @return mixed
         */
        public function createRequest(array $data)
        {
            $request = $this->request->createRequest($data);

            if ( $this->hasToll($data) ) {
                $request->extraExpenses()->create([
                                                      'description' => 'Pedágio',
                                                      'value'       => $data['extra']['toll']['value']
                                                  ]);
            }

            return $request;
        }

        /**
         * Check if has toll from value
         *
         * @param array $data
         *
         * @return bool
         */
        private function hasToll(array $data)
        {
            return isset($data['extra']) && $data['extra']['toll']['value'];
        }
    }