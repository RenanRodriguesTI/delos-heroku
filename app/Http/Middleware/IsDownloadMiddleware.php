<?php

namespace Delos\Dgp\Http\Middleware;

use Closure;
use Delos\Dgp\Reports\ExcelReport;

class IsDownloadMiddleware
{
    use ExcelReport;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('report') == 'xlsx') {
            foreach ($next($request)->original->getData() as $data) {
                if ($data->isDownloadable) {
                    $fileName = base_path() . $this->getFullPath() . $this->getFileName($request, $next) . '.xlsx';
                    $this->download($data->toArray(), $fileName);
                }
            }
        }
        return $next($request);
    }

    public function getFullPath(): string
    {
        return '/resources/views/reports/';
    }

    public function getFileName($request, Closure $next)
    {
        return explode('.', $next($request)->original->name())[1];
    }
}
