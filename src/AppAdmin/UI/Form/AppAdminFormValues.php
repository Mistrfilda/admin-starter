<?php

declare(strict_types=1);

namespace App\AppAdmin\UI\Form;

use Nette\SmartObject;

class AppAdminFormValues
{
	use SmartObject;

	public string $name;

	public string $username;

	public string $email;

	public ?string $password;
}
