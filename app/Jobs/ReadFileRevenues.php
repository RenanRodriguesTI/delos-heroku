<?php

namespace Delos\Dgp\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Delos\Dgp\Jobs\ImportRevenues;
use Exception;

class ReadFileRevenues implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        Storage::disk('local')->put('file.xlsx', Storage::disk('s3')->get('file.xlsx'));
        Excel::filter('chunk')->load(Storage::disk('local')->path('file.xlsx'))->formatDates(true)->chunk(100, function($results) use($user)
            {
               
                    $load = Excel::load(Storage::disk('local')->path('file.xlsx'), function($reader) {
                })->getActiveSheet()->getHighestRow();
                dispatch((new ImportRevenues($results->toArray(),$load,$user)))->onConnection('database');

            });
    }

    public function failed(Exception $exception)
    {
        var_dump($exception->getMessage());
    }
}
