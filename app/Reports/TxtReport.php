<?php

namespace Delos\Dgp\Reports;

use Delos\Dgp\Exceptions\FileDoesNotExistException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class TxtReport implements TxtReportInterface
{
    private const LINE_IDENTIFICATION_LENGTH =  2;
    private const TYPE_EXPENSE_LENGTH =  1;
    private const INVOICE_LENGTH =  13;
    private const ISSUE_DATE_LENGTH =  8;
    private const DUE_DATE_LENGTH =  8;
    private const VALUE_LENGTH =  72;
    private const SUPPLIER_IDENTIFICATION_LENGTH =  1;
    private const SUPPLIER_NUMBER_LENGTH =  14;
    private const CHECKING_ACCOUNT_LENGTH =  20;
    private const FINANCIAL_CLASSIFICATION_NUMBER_LENGTH =  72;
    private const EXPENSE_TYPE_LENGTH =  57;
    private const DISCOUNT_EXPIRATION_LENGTH =  28;
    private const MULCT_EXPIRATION_LENGTH =  8;

    private const TYPE_DESCRIPTION_LENGTH = 1;
    private const DESCRIPTION_LENGTH = 996;

    private $filesystem;
    private $filePathName;
    private $content = '';

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->filePathName = 'reports/expenses/expenses.txt';
        $this->createFileIfDoesNotExist();
    }

    public function generate(Collection $expenses)
    {
        $this->eraseTxtFile();
        foreach ($expenses as $expense) {
            $this->fillFirstLineWithInfoExpense($expense);
            $this->fillSecondLineWithDescriptionExpense($expense);
            $this->fillThirdLineWithEmptySpaces();

            $expense->update(['exported' => true]);
        }

        return \Storage::disk('local')->put($this->filePathName, iconv('UTF-8', 'Windows-1252', $this->content), 'public');
    }

    private function fillFirstLineWithInfoExpense($expense)
    {
        $this->concatStringToContent('20', self::LINE_IDENTIFICATION_LENGTH)
            ->concatStringToContent('1', self::TYPE_EXPENSE_LENGTH)
            ->concatStringToContent($expense->invoice, self::INVOICE_LENGTH)
            ->concatStringToContent($expense->issue_date->format('dmY'), self::ISSUE_DATE_LENGTH)
            ->concatStringToContent($expense->issue_date->format('dmY'), self::DUE_DATE_LENGTH)
            ->concatStringToContent($expense->value, self::VALUE_LENGTH)
            ->concatStringToContent('1', self::SUPPLIER_IDENTIFICATION_LENGTH)
            ->concatStringToContent($expense->user->supplier_number ?? '', self::SUPPLIER_NUMBER_LENGTH)
            ->concatStringToContent($expense->user->account_number, self::CHECKING_ACCOUNT_LENGTH)
            ->concatStringToContent($expense->request->project->compiled_cod ?? $expense->project->compiled_cod, self::FINANCIAL_CLASSIFICATION_NUMBER_LENGTH)
            ->concatStringToContent($expense->paymentType->cod, self::EXPENSE_TYPE_LENGTH)
            ->concatStringToContent($expense->issue_date->format('dmY'), self::DISCOUNT_EXPIRATION_LENGTH)
            ->concatStringToContent($expense->issue_date->format('dmY'), self::MULCT_EXPIRATION_LENGTH, true);
    }

    private function fillSecondLineWithDescriptionExpense($expense)
    {
        $this->concatStringToContent('08', self::LINE_IDENTIFICATION_LENGTH)
            ->concatStringToContent('7', self::TYPE_DESCRIPTION_LENGTH)
            ->concatStringToContent($expense->description . ' ' . $expense->note, self::DESCRIPTION_LENGTH, true);
    }

    private function fillThirdLineWithEmptySpaces()
    {
        $this->concatStringToContent('99', self::LINE_IDENTIFICATION_LENGTH)
        ->concatStringToContent('', 997, true);
    }

    private function concatStringToContent(string $string, int $maximumLength, bool $wrapLine = false)
    {
        $this->content .= $this->stringPaddingWithSpacesToRight($string, $maximumLength, $wrapLine);
        return $this;
    }

    private function eraseTxtFile() : void
    {
        $this->filesystem->put($this->filePathName, '');
    }

    private function stringPaddingWithSpacesToRight(string $string, int $length, bool $wrapLine)
    {
        $stringWithSpaces = str_pad($string, $length, ' ', STR_PAD_RIGHT);

        if(true === $wrapLine) {
            $stringWithSpaces .= PHP_EOL;
        }

        return $stringWithSpaces;
    }

    public function createFileIfDoesNotExist()
    {
        $file = storage_path('app/' . $this->filePathName);

        if(!file_exists($file)) {
            $this->filesystem->put($this->filePathName, '');
        }
    }
}