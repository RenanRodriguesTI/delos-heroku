<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 12/12/17
     * Time: 17:40
     */

    namespace Delos\Dgp\Repositories\Criterias;

    use Illuminate\Database\Eloquent\Builder;

    /**
     * Trait CommonCriteriaTrait
     * @package Delos\Dgp\Repositories\Criterias
     */
    trait CommonCriteriaTrait
    {
        /**
         * If exists relation apply where null or not null sql from relation
         *
         * @param Builder $model
         * @param string  $relation
         * @param string  $column
         * @param string  $method
         *
         * @return Builder|static
         */
        public function applyWhereNullOrNotNullInsideWhereHas(Builder $model, string $relation, string $column, string $method)
        {
            return $model->whereHas($relation, function (Builder $query) use ($method, $column) {
                $query->$method($column);
            });
        }

        /**
         * @param string  $input
         * @param Builder $model
         * @param string  $column
         *
         * @return Builder
         */
        public function applyFilterUsingWhereIn(string $input, Builder $model, string $column = ''): Builder
        {
            $column = $column == '' ? $input : $column;

            $inputFound = $this->getRequestInput($input);

            return $this->isValidArray($inputFound) ? $model->whereIn($column, $inputFound) : $model;
        }

        /**
         * @param string      $input
         * @param Builder     $model
         * @param string|null $relation
         * @param string      $column
         *
         * @return Builder
         */
        public function applyFilterUsingWhereNotNullOrNull(string $input, Builder $model, string $relation = null, string $column = ''): Builder
        {
            $column = $column == '' ? $input : $column;

            $method = $this->getRequestInput($input);

            if ( $relation ) {
                return $method && ($method == 'whereNull' || $method == 'whereNotNull') ? $this->applyWhereNullOrNotNullInsideWhereHas($model, $relation, $column, $method) : $model;
            }

            return $method && ($method == 'whereNull' || $method == 'whereNotNull') ? $model->$method($column) : $model;
        }

        /**
         * @param string $input
         *
         * @return mixed
         */
        private function getRequestInput(string $input)
        {
            return app('request')->get($input);
        }

        /**
         * @param $array
         *
         * @return bool
         */
        private function isValidArray($array): bool
        {
            return is_array($array) && !empty($array);
        }
    }