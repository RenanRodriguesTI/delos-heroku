<?php

    namespace Delos\Dgp\Services\Request;

    /**
     * Class Lodging
     * @package Delos\Dgp\Services\Request
     */
    class Lodging extends ChildRequestDecorator
    {
        /**
         * @param array $data
         *
         * @return mixed
         */
        public function createRequest(array $data)
        {
            $request = $this->request->createRequest($data);

            if ( isset($data['has_lodging']) ) {
                $lodgingData = $data['lodging'];
                $request->lodging()->create($lodgingData);
            }

            return $request;
        }
    }