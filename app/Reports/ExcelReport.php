<?php

namespace Delos\Dgp\Reports;

use Delos\Dgp\Exceptions\FileDoesNotExistException;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Readers\LaravelExcelReader;

trait ExcelReport
{
    protected $extension = 'xlsx';

    protected function download(array $data, string $filename, string $sheetName = 'report')
    {
        if(!file_exists($filename)) {
            throw new FileDoesNotExistException("The file $filename does not exist");
        }

        Excel::load($filename, function (LaravelExcelReader $reader) use($data, $sheetName) {

            $sheet = $reader->getExcel()->getActiveSheet();
            $sheet->fromArray($data, null, 'A2', false, false);

        })->download($this->extension);
    }
}