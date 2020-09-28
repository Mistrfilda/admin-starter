<?php

declare(strict_types=1);

namespace App\UI\Base\templates;

use App\AppAdmin\AppAdmin;
use App\Right\RightService;
use App\UI\AppAdmin\AppAdminGridPresenter;
use App\UI\Base\Menu\MenuGroup;
use Nette\Security\User;
use Nette\SmartObject;

/**
 * @method bool isLinkCurrent(string $destination = null, $args = [])
 * @method bool isModuleCurrent(string $module)
 */
class BaseTemplate
{
	use SmartObject;

	public User $user;

	public string $baseUrl;

	public string $basePath;

	/** @var mixed[] */
	public array $flashes;

	public AppAdminGridPresenter $control;

	public AppAdminGridPresenter $presenter;

	public AppAdmin $appAdmin;

	/** @var MenuGroup[] */
	public array $menuItems;

	public RightService $rightService;
}
