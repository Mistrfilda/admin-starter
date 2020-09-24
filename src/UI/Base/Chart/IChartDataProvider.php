<?php

declare(strict_types=1);

namespace App\UI\Base\Chart;

interface IChartDataProvider
{
	public function getChartData(): ChartData;
}
