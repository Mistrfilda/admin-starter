<?php

declare(strict_types=1);

namespace App\UI\AppAdmin\templates;

use App\UI\Base\templates\BaseTemplate;
use Nette\SmartObject;

class AppAdminFormTemplate extends BaseTemplate
{
	use SmartObject;

	public bool $updateForm = false;
}
