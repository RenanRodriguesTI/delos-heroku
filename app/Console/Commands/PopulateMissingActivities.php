<?php

namespace Delos\Dgp\Console\Commands;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use DatePeriod;
use Illuminate\Support\Facades\DB;

class PopulateMissingActivities extends Command
{
    private const COLLABORATOR_ROLE_ID = 1;
    private const MINIMUM_AMOUNT_OF_HOURS_PER_DAY = 8;
    protected $signature = 'populate:missing-activities';
    protected $description = 'Populate Missing Activities';

    public function handle()
    {
        DB::beginTransaction();
        DB::table('missing_activities')->truncate();

        $yesterday = Carbon::yesterday()->endOfDay();
        $systemUsage = Carbon::create('2017', '01', '02');

        $this->getCollaborators()
            ->each(function ($collaborator) use ($yesterday, $systemUsage) {

                $start = Carbon::parse($collaborator->admission);

                if ($start->lt($systemUsage)) {
                    $start = $systemUsage;
                }

                $start->startOfDay();
                $period = new DatePeriod($start, CarbonInterval::day(), $yesterday);

                /** @var $day Carbon */
                foreach ($period as $day) {
                    if (!$this->isWorkingDay($day)) continue;

                    $hours = $this->sumHoursByUserIdAndDate($collaborator->id, $day);

                    if ($hours >= self::MINIMUM_AMOUNT_OF_HOURS_PER_DAY) continue;

                    DB::table('missing_activities')
                        ->insert([
                            'user_id' => $collaborator->id,
                            'hours' => self::MINIMUM_AMOUNT_OF_HOURS_PER_DAY - $hours,
                            'date' => $day->toDateString(),
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString()
                        ]);

                }

            });
        DB::commit();
    }

    private function getCollaborators()
    {
        return DB::table('users')
            ->where('role_id', self::COLLABORATOR_ROLE_ID)
            ->whereNull('deleted_at')
            ->get();
    }

    private function sumHoursByUserIdAndDate(int $userId, Carbon $date)
    {
        return DB::table('activities')
            ->where('user_id', $userId)
            ->where('date', $date->toDateString())
            ->sum('hours');
    }

    private function isWorkingDay(Carbon $day)
    {
        if ($day->isWeekend()) return false;

        $hasHoliday = (bool) DB::table('holidays')
            ->where('date', $day->toDateString())
            ->count();

        if ($hasHoliday) return false;

        return true;
    }
}
