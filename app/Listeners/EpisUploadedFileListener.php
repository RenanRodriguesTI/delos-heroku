<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Delos\Dgp\Events\EpisUploadedFile;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\Request;

class EpisUploadedFileListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
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
     * @param  object  $event
     * @return void
     */
    public function handle(EpisUploadedFile $event)
    {
        $epi = $event->epi;
        $fileName = $this->getFilenameWithItsExtension($epi->id);
        $fullFilename = $this->getFullPath(). '/' . $fileName;

        
        if ($this->request->method() == 'PUT')
        {
            $this->storage->delete($this->getFullPath($epi) . '/' . $epi->file_s3);
        }

        $fileRenamed = $this->moveAndRename($this->getFullPath($epi), $fileName);
        $this->putOnDisk($fileRenamed, $fullFilename);

        $epi->update(['file_s3' => $fileName,
        'filename'=>$this->getUploadedFile('file')->getClientOriginalName()]);
    }

    private function getUploadedFile(string $nameOfFile)
    {
        return $this->request->file($nameOfFile);
    }

    private function getFullPath() : string
    {
        return 'epis/uploads';
    }

    private function getContentFile($file)
    {
        return file_get_contents($file);
    }

    private function getFilenameWithItsExtension(string $name) : string
    {
        return $name . '.' .  $this->getUploadedFile('file')->getClientOriginalExtension();
    }

    private function putOnDisk($file, $fullPath) : void
    {
        $contents = $this->getContentFile($file);
        
        $this->storage->put($fullPath, $contents, 'public');
    }

    private function moveAndRename(string $path, string $name)
    {
        return $this->getUploadedFile('file')->move($path, $name);
    }



}
