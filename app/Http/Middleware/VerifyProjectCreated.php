<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 25/04/17
 * Time: 14:13
 */

namespace Delos\Dgp\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;

class VerifyProjectCreated
{
    public function handle($request, Closure $next)
    {
        if ($this->projectIsCreated($request))
        {
            return redirect()->route('projects.index');
        }

        return $next($request);
    }

    private function projectIsCreated($request): bool
    {
        $projectRepository = app(ProjectRepository::class);
        $requestBody = $request->all();

        $projects = $projectRepository->findWhere([
            'company_id' => $requestBody['company_id'],
            'financial_rating_id' => $requestBody['financial_rating_id'],
            'project_type_id' => $requestBody['project_type_id'],
            'owner_id' => $requestBody['owner_id'],
            'co_owner_id' => $requestBody['co_owner_id'] ?? null,
            'budget' => $requestBody['budget'],
            'proposal_number' => $requestBody['proposal_number'],
            'proposal_value' => $requestBody['proposal_value'],
            'start' => Carbon::createFromFormat('d/m/Y', $requestBody['start'])->format('Y-m-d'),
            'finish' => Carbon::createFromFormat('d/m/Y', $requestBody['finish'])->format('Y-m-d')
        ]);

        return $projects->count() > 0;
    }
}