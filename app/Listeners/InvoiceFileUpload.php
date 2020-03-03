<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\SavedExpense;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\Request;

class InvoiceFileUpload implements ShouldQueue
{

    private $storage;
    private $request;

    public function __construct(Storage $storage, Request $request)
    {
        $this->storage = $storage;
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  SavedExpense  $event
     * @return void
     */
    public function handle(SavedExpense $event)
    {
        $expense = $event->expense;

        $fileName = $this->getFilenameWithItsExtension($expense->id);

        $fullFilename = $this->getFullPath($expense). '/' . $fileName;

        if ($this->request->method() == 'PUT')
        {
            $this->storage->delete($this->getFullPath($expense) . '/' . $expense->s3_name);
        }

        $fileRenamed = $this->moveAndRename($this->getFullPath($expense), $fileName);

        $this->putOnDisk($fileRenamed, $fullFilename);

        $expense->update(['s3_name' => $fileName]);
    }

    private function getFilenameWithItsExtension(string $name) : string
    {
        return $name . '.' .  $this->getUploadedFile('invoice_file')->getClientOriginalExtension();
    }

    private function moveAndRename(string $path, string $name)
    {
        return $this->getUploadedFile('invoice_file')->move($path, $name);
    }

    private function getContentFile($file)
    {
        return file_get_contents($file);
    }

    private function getFullPath($expense) : string
    {
        return 'images/invoices';
    }

    private function getUploadedFile(string $nameOfFile)
    {
        return $this->request->file($nameOfFile);
    }

    private function putOnDisk($file, $fullPath) : void
    {
        $contents = $this->getContentFile($file);
        
        $this->storage->put($fullPath, $contents, 'public');
    }
}
