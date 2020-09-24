<?php

declare(strict_types=1);

namespace App\UI\Base\Chart\Control;


use App\UI\Base\Chart\IChartDataProvider;

interface ChartControlFactory
{
	public function create(string $type, string $cardHeading, IChartDataProvider $chartDataProvider): ChartControl;
}
