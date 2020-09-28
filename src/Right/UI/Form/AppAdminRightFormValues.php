<?php

declare(strict_types=1);

namespace App\Right\UI\Form;

use Nette\SmartObject;

class AppAdminRightFormValues
{
	use SmartObject;

	/** @var array<int, string> */
	public array $roles;
}
