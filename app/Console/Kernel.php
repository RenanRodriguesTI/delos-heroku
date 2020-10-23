<?php

namespace Delos\Dgp\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SendMissingActivitiesEmailsToCollaborators::class,
        Commands\SendMissingMembersActivitiesEmailsToOwner::class,
        Commands\SendAllCollaboratorsMissingActivitiesToManager::class,
        Commands\PopulateMissingActivities::class,
        Commands\OvertimeApproval::class,
        Commands\ApprovedActivitiesEmail::class,
        Commands\RequestSummary::class,
        Commands\AbsencesEmailToHumanResources::class,
        Commands\CreateZipWithInvoicesFileFromDebitMemosFinishedYesterday::class,
        Commands\UpdatePermissions::class,
        Commands\VerifyTherePaymentToDo::class,
        Commands\CheckIfThereIsCompanyDefaulting::class,
        Commands\UpdateTasksFromProjectType::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:requests-summary tuesday thursday')
             ->fridays();

        $schedule->command('email:requests-summary friday monday')
            ->tuesdays();

        $schedule->command('email:approved-activities');

        $schedule->command('email:overtime-approval');

        $schedule->command('populate:missing-activities');

        // $schedule->command('email:missing-collaborators')
        //     ->mondays();

        // $schedule->command('email:missing-members-activities')
        //     ->mondays();

        // $schedule->command('email:all-missing-activities')
        //     ->mondays();

        $schedule->command('email:absences')
            ->mondays();

        $schedule->command('make:zip --debitMemos');
//
//        $schedule->command('signature:payment');
//
//        $schedule->command('signature:defaulting');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
