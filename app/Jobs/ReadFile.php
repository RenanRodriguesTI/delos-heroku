<?php

namespace Delos\Dgp\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Delos\Dgp\Jobs\ImportRevenues;
use Exception;

class ReadFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Storage::disk('heroku')->put('file.xlsx', Storage::disk('s3')->get('file.xlsx'));

        var_dump( Storage::disk('heroku')->path('file.xlsx'));

           Excel::filter('chunk')->load(Storage::disk('heroku')->path('file.xlsx'))->formatDates(true)->chunk(100, function($results)
            {

                    $load = Excel::load('storage/app/file.xlsx', function($reader) {
                })->getActiveSheet()->getHighestRow();
                dispatch((new ImportRevenues($results->toArray(),$load,'renanrodriguesmachado2@gmail.com')))->onConnection('database');

            });
    }

    public function failed(Exception $exception)
    {
        var_dump($exception->getMessage());
    }
}
