<?php

declare(strict_types=1);

namespace App\AppAdminRole\UI\Form;

use Nette\SmartObject;

class AppAdminRoleFormValues
{
	use SmartObject;

	/** @var array<int, string> */
	public array $roles;
}
