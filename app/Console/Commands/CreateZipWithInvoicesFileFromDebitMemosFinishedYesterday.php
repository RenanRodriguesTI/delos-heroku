<?php

namespace Delos\Dgp\Console\Commands;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Contracts\DebitMemoRepository;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Symfony\Component\Console\Helper\ProgressBar;

class CreateZipWithInvoicesFileFromDebitMemosFinishedYesterday extends Command
{
    protected $signature = 'make:zip {--debitMemos}';
    protected $description = 'Create zip from debit memos that has been finished yesterday';
    private $repository;
    private const AWS_PATH = 'Downloads/Zips/InvoicesFromProjectAndND/';
    private $filesystem;
    private $zip;

    public function __construct(DebitMemoRepository $repository, Filesystem $filesystem, ZipArchive $zip)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->filesystem = $filesystem;
        $this->zip = $zip;
    }

    public function handle()
    {
        if ($this->hasOption('debitMemos')) {
            $debitMemos = $this->getDebitMemos();
            $progress = $this->getProgress();
            $progress->start();

            foreach ($debitMemos as $debitMemo) {
                $expenses = $this->getExpenses($debitMemo);

                $project = $this->getProjectFromExpenses($expenses);

                $this->generate($project, $debitMemo, $expenses, $progress);
            }

            Storage::disk('local')->deleteDirectory(self::AWS_PATH);

            $progress->finish();
            $this->info(PHP_EOL . PHP_EOL . 'Created to: ' . $this->getNumbersDebiMemo($debitMemos));
        }
    }

    private function NDPathOnAws($user, $debitMemo, string $fileName) : string
    {
        return 'ND' . $debitMemo->code . '/' . $user->id . '-' . $user->name . '/' . $fileName;
    }

    private function createFileFromContentRetrievingOnS3(string $name, string $content) : void
    {
        Storage::disk('local')->put($name, $content);
    }

    private function getFileNameAndExtensionToZip(string $newName, string $oldNameAndExtension) : string
    {
        return $newName . '.' . explode('.', $oldNameAndExtension)[1];
    }

    private function fullNamePathOnAWS(int $projectId, int $userId, string $file) : string
    {
        return 'images/invoices/' . session('groupCompanies')[0] . '/' . $projectId . '/' . $userId . '/' . $file;
    }

    private function getPathZipOnAWS($project, $debitMemo, $user) : string
    {
        return self::AWS_PATH . $project->compiled_cod . '/' . 'ND' . $debitMemo->code . '/' . $user->id . '-' . $user->name . '/';
    }

    private function getProjectFromExpenses(array $expenses)
    {
        return $expenses[0]->request->project;
    }

    private function createOrOverwriteZip($project, $debitMemo): void
    {
        $this->zip->open(storage_path() . '/app/' . self::AWS_PATH . $project->compiled_cod . '/' . 'ND' . $debitMemo->code . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
    }

    private function getFileContent($project, $expense): string
    {
        $content = $this->filesystem->get($this->fullNamePathOnAWS($project->id, $expense->user->id, $expense->s3_name));
        return $content;
    }

    private function getExpenses($debitMemo) : array
    {
        $expenses = [];
        foreach ($debitMemo->requests as $request) {
            foreach ($request->expenses as $expense) {
                array_push($expenses, $expense);
            }
        }

        return $expenses;
    }

    private function getCountExpenses($debitMemos)
    {
        $count = 0;

        foreach ($debitMemos as $debitMemo) {
            foreach ($debitMemo->requests as $request) {
                foreach ($request->expenses as $expense) {
                    $count++;
                }
            }
        }

        return $count;
    }

    private function generate($project, $debitMemo, $expenses, $progress): void
    {
        $this->createOrOverwriteZip($project, $debitMemo);

        $this->info(PHP_EOL . 'Downloading invoices file from ND' . $debitMemo->number);

        foreach ($expenses as $expense) {
            $content = $this->getFileContent($project, $expense);
            $pathToZipOnAWS = $this->getPathZipOnAWS($project, $debitMemo, $expense->user);
            $nameToFileOnAWS = $this->getFileNameAndExtensionToZip((string)$expense->invoice, $expense->s3_name);

            $this->createFileFromContentRetrievingOnS3($pathToZipOnAWS . $nameToFileOnAWS, $content);
            $this->zip->addFile(storage_path() . '/app/' . $pathToZipOnAWS . $nameToFileOnAWS, $this->NDPathOnAws($expense->user, $debitMemo, $nameToFileOnAWS));

            $progress->advance();
        }

        $this->zip->close();

        $zipContent = Storage::disk('local')->get(self::AWS_PATH . $project->compiled_cod . '/' . 'ND' . $debitMemo->code . '.zip');

        $this->info(PHP_EOL . 'Uploading: ND' . $debitMemo->number);

        $this->filesystem->put(self::AWS_PATH . $project->compiled_cod . '/' . 'ND' . $debitMemo->code . '.zip', $zipContent, 'public');
    }

    private function getDebitMemos()
    {
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        $debitMemos = $this->repository->makeModel()->where(function (Builder $query) use ($yesterday) {
            $query->where('finish_at', 'like', "%{$yesterday}%");
        })->get();
        return $debitMemos;
    }

    private function getProgress()
    {
        return new ProgressBar($this->getOutput(), $this->getCountExpenses($this->getDebitMemos()));
    }

    private function getNumbersDebiMemo(iterable $debitMemos) : string
    {
        $numbers = "";

        foreach ($debitMemos as $debitMemo) {
            $numbers == "" ? $numbers .= "ND{$debitMemo->number}" : $numbers .= ", ND{$debitMemo->number}";
        }

        return $numbers;
    }
}