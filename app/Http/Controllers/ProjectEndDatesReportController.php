<?php

namespace Delos\Dgp\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Readers\LaravelExcelReader;

class ProjectEndDatesReportController extends Controller
{
    public function index()
    {
        $projects = $this->getProjects();

        $format = request()->query('format');

        if ($format === 'xlsx') {
            $filename = resource_path('views/reports/projetos-com-datas-de-finalizacao-diferentes.xlsx');
            return $this->toExcel($filename, $projects);
        }

        return view('reports/projects-with-different-end-dates', [
            'projects' => $projects
        ]);
    }

    public function getProjects()
    {
        return DB::table('projects as p')
            ->join('users as u', 'u.id', '=', 'p.owner_id')
            ->select([
                'p.compiled_cod',
                'p.description',
                'u.name as owner',
                'p.start',
                'p.finish',
                'p.last_activity',
                'p.deleted_at',
                DB::raw('datediff(p.deleted_at, p.finish) as diff')
            ])
            ->where(DB::raw('date(p.deleted_at)'), '>', DB::raw('date(p.finish)'))
            ->orderByDesc('p.deleted_at')
            ->get()
            ->map(function ($project) {
                return [
                   'cod' => $project->compiled_cod,
                    'description' => $project->description,
                    'owner' => $project->owner,
                    'start' => Carbon::parse($project->start)->format('d/m/Y'),
                    'finish' => Carbon::parse($project->finish)->format('d/m/Y'),
                    'last_activity' => $project->last_activity ? Carbon::parse($project->last_activity)->format('d/m/Y') : null,
                    'deleted_at' => Carbon::parse($project->deleted_at)->format('d/m/Y'),
                    'diff' => $project->diff
                ];
            })
            ->toArray();
    }

    public function toExcel(string $filename, array $data)
    {
        Excel::load($filename, function (LaravelExcelReader $reader) use ($data) {
            $reader->sheet(0, function (LaravelExcelWorksheet $sheet) use ($data) {
                $sheet->fromArray($data, null, 'A2', false, false);
            });
        })
        ->download('xlsx');
    }
}