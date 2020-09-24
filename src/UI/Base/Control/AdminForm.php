<?php

declare(strict_types=1);

namespace App\UI\Base\Control;

use Nette\Application\UI\Form;

class AdminForm extends Form
{
	private bool $isAjax = false;

	public function ajax(): void
	{
		$this->isAjax = true;
	}

	public function isAjax(): bool
	{
		return $this->isAjax;
	}
}
