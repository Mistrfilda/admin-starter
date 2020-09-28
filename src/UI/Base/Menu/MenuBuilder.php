<?php

declare(strict_types=1);

namespace App\UI\Base\Menu;

use App\Right\Right;

class MenuBuilder
{
	/**
	 * @return MenuGroup[]
	 */
	public function buildMenu(): array
	{
		return [
			new MenuGroup('Dashboard', false, null, [
				new MenuItem('Dashboard', 'default', 'fas fa-fw fa-tachometer-alt', 'Dashboard', null),
			]),
			new MenuGroup('Users', true, Right::USERS, [
				new MenuItem('AppAdminGrid', 'default', 'fas fa-fw fa-users', 'Users', Right::USERS),
			]),
		];
	}
}
