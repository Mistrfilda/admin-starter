<?php

declare(strict_types=1);

namespace App\Right;

use App\AppAdmin\AppAdmin;
use App\AppAdmin\CurrentAppAdminGetter;

class RightService
{
	private CurrentAppAdminGetter $currentAppAdminGetter;

	public function __construct(CurrentAppAdminGetter $currentAppAdminGetter)
	{
		$this->currentAppAdminGetter = $currentAppAdminGetter;
	}

	public function isCurrentUserAllowed(?string $right): bool
	{
		return $this->isUserAllowed($this->currentAppAdminGetter->getLoggedAppAdmin(), $right);
	}

	public function isUserAllowed(AppAdmin $user, ?string $right): bool
	{
		if ($right === null) {
			return true;
		}

		return $user->hasRight($right);
	}

	public function checkRight(AppAdmin $user, ?string $right): void
	{
		if ($this->isUserAllowed($user, $right) === false) {
			throw new AppAdminNotAllowedException();
		}
	}
}
