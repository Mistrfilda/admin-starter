<?php

declare(strict_types=1);

namespace App\UI\Base\Map;

interface IMapObjectProvider
{
	/** @return MapObject[] */
	public function getMapObjects(): array;
}
