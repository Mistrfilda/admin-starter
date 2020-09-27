<?php

declare(strict_types=1);

namespace App\UI\Base\Menu;

class MenuBuilder
{
	/**
	 * @return MenuGroup[]
	 */
	public function buildMenu(): array
	{
		return [
			new MenuGroup('Dashboard', false, [
				new MenuItem('Dashboard', 'default', 'fas fa-fw fa-tachometer-alt', 'Dashboard'),
			]),
			new MenuGroup('Users', true, [
				new MenuItem('AppAdminGrid', 'default', 'fas fa-fw fa-users', 'Users'),
			]),
		];
	}
}
