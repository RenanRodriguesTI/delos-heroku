<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 02/05/18
     * Time: 17:10
     */

    namespace Delos\Dgp\Services;


    use Carbon\Carbon;
    use Carbon\CarbonInterval;

    trait RangeTrait
    {
        /**
         * Get interval between two dates
         * @param string $start
         * @param string $end
         *
         * @return \DatePeriod
         */
        public function getDateRange(string $start, string $end): \DatePeriod
        {
            $startDate = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
            $endDate   = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();
            return new \DatePeriod($startDate, CarbonInterval::days(1), $endDate);
        }
    }