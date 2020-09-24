<?php

declare(strict_types=1);

namespace App\UI\Base\Modal;

interface ModalRendererControlFactory
{
	public function create(): ModalRendererControl;
}
