<?php

declare(strict_types=1);

namespace App\UI\Base\Filter;


use App\UI\Base\Control\AdminDatagrid;


class NullableStringFilter
{
	public function format(?string $nullableString): string
	{
		if ($nullableString === null) {
			return AdminDatagrid::NULLABLE_PLACEHOLDER;
		}

		return $nullableString;
	}
}
