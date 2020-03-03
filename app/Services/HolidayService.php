<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\HolidayRepository;

class HolidayService extends AbstractService
{
	public function repositoryClass() : string
	{
		return HolidayRepository::class;
	}
}