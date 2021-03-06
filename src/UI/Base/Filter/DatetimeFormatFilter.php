<?php

declare(strict_types=1);

namespace App\UI\Base\Filter;

use App\Utils\Datetime\DatetimeFactory;
use DateTimeImmutable;

class DatetimeFormatFilter
{
	public function format(?DateTimeImmutable $datetime): string
	{
		if ($datetime === null) {
			return DatetimeFactory::DEFAULT_NULL_DATETIME_PLACEHOLDER;
		}

		return $datetime->format(DatetimeFactory::DEPARTURE_TABLE_DATETIME_FORMAT);
	}
}
