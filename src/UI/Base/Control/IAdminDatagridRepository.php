<?php

declare(strict_types=1);

namespace App\UI\Base\Control;

use Doctrine\ORM\QueryBuilder;

interface IAdminDatagridRepository
{
	public function createQueryBuilder(): QueryBuilder;
}
