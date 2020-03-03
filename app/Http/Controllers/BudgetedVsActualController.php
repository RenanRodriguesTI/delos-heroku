<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Reports\BudgetedVsActualQueries;
use Maatwebsite\Excel\Facades\Excel;

class BudgetedVsActualController extends Controller
{
    /**
     * @var BudgetedVsActualQueries
     */
    private $queries;

    /**
     * Constructor class
     *
     * BudgetedVsActualController constructor.
     * @param BudgetedVsActualQueries $queries
     */
    public function __construct(BudgetedVsActualQueries $queries)
    {
        $this->queries = $queries;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isDownload = app('request')->input('download');
        if ($isDownload) {
            $this->downloadReport();
        }

        $months = $this->queries->convertToArray([
            'month',
            'year',
            'compiled_cod',
            'description',
            'budget',
            'proposal_value',
            'date_deleted',
            'name',
            'total_hours',
            'total_labor'
        ], $this->queries->getMonthsReport());

        $collaborators = $this->queries->convertToArray([
            'name',
            'value',
            'id'],$this->queries->getCollaborators());

        $hours = $this->queries->convertToArray([
            'compiled_cod',
            'status',
            'actual',
            'budget',
            'difference',
            'description'
        ], $this->queries->getBudgetedAndActualHours());

        $values = $this->queries->convertToArray([
            'compiled_cod',
            'status',
            'total_labor',
            'total_expenses',
            'expenses',
            'extra_expenses',
            'actual',
            'budget',
            'difference',
            'description',
            'projects.id'
        ], $this->queries->getBudgetedAndActualValues());

        $projects = $this->queries->getProjects();
        $years = $this->queries->getYears();
        $collaboratorsToSearch = $this->queries->getCollaboratorsToSearch();
        $monthsToSearch = ReportsController::MONTHS;

        return view('reports.budgetVsActual', compact('months', 'collaborators', 'hours', 'values', 'projects', 'years', 'collaboratorsToSearch', 'monthsToSearch'));
    }

    /**
     * Populate report excel and download
     */
    private function downloadReport() : void
    {
        $collaborators = $this->queries->convertToArray([
            'name',
            'value',
        ], $this->queries->getCollaborators());

        $hoursToReport = $this->queries->convertToArray([
            'compiled_cod',
            'status',
            'actual',
            'budget',
            'difference',
        ], $this->queries->getBudgetedAndActualHours());

        $valuesToReport = $this->queries->convertToArray([
            'compiled_cod',
            'status',
            'total_labor',
            'total_expenses',
            'actual',
            'budget',
            'difference'
        ], $this->queries->getBudgetedAndActualValues());

        $monthsToReport = $this->queries->convertToArray([
            'month',
            'year',
            'compiled_cod',
            'date_deleted',
            'name',
            'total_hours',
            'total_labor'
        ], $this->queries->getMonthsReport());

        Excel::load('resources/views/reports/budgetVsActual.xlsx', function ($reader) use ($monthsToReport, $collaborators, $hoursToReport, $valuesToReport) {

            $reader->sheet('Orçado x Real (Valor)')->setCellValue('D1', date('d/m/Y H:i:s'));
            $reader->sheet('Orçado x Real (Horas)')->setCellValue('C1', date('d/m/Y H:i:s'));
            $reader->sheet('Meses')->setCellValue('E1', date('d/m/Y H:i:s'));
            $reader->sheet('Colaboradores')->setCellValue('B1', date('d/m/Y H:i:s'));

            $reader->sheet('Orçado x Real (Valor)')->fromArray($valuesToReport, null, 'A4', false, false);
            $reader->sheet('Orçado x Real (Horas)')->fromArray($hoursToReport, null, 'A4', false, false);
            $reader->sheet('Meses')->fromArray($monthsToReport, null, 'A4', false, false);
            $reader->sheet('Colaboradores')->fromArray($collaborators, null, 'A4', false, false);

        })->download('xlsx');
    }
}
