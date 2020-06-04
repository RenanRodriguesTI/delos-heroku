<?php

namespace Delos\Dgp\Reports;

use Delos\Dgp\Exceptions\FileDoesNotExistException;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use Illuminate\Support\Facades\Config;
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

    protected function export(array $data, string $filename,$extension='',$columnsfloats =[], string $sheetName = 'report')
    {
        if(!file_exists($filename)) {
            throw new FileDoesNotExistException("The file $filename does not exist");
        }

        if($extension){
            $this->extension = $extension;
        }
        Config::set('excel.csv.delimiter', ';');
        Config::set('excel.csv.use_bom',true);

        Excel::load($filename, function (LaravelExcelReader $reader) use($data, $sheetName,$columnsfloats) {
            $sheet = $reader->getExcel()->getActiveSheet();
            foreach($columnsfloats as $column){
                $sheet->getStyle($column)->getNumberFormat()
            ->setFormatCode('0.00');
            }
            $sheet->getStyle('P')->getNumberFormat()
            ->setFormatCode('0.00');
            $sheet->fromArray($data, null, 'A2', false, false);

        })->download($extension);
    }
}