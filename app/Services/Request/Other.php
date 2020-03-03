<?php

    namespace Delos\Dgp\Services\Request;

    /**
     * Class Other
     * @package Delos\Dgp\Services\Request
     */
    class Other extends ChildRequestDecorator
    {
        /**
         * @param array $data
         *
         * @return mixed
         */
        public function createRequest(array $data)
        {
            $request = $this->request->createRequest($data);

            if ( $this->hasOther($data) ) {
                $extraExpenses = $data['extra']['other'];

                $request->extraExpenses()->create([
                                                      'description' => $extraExpenses['description'],
                                                      'value'       => $extraExpenses['value']
                                                  ]);
            }

            return $request;
        }

        /**
         * Check if has other from value
         *
         * @param array $data
         *
         * @return bool
         */
        private function hasOther(array $data)
        {
            return isset($data['extra']) && $data['extra']['other']['value'];
        }
    }