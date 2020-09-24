<?php

declare(strict_types=1);

namespace App\UI\Base\templates;


use App\AppAdmin\AppAdmin;
use App\UI\Base\BasePresenter;
use App\UI\Base\Menu\MenuGroup;
use Nette\Security\User;
use stdClass;

/**
 * @property User $user
 * @property string $baseUrl
 * @property string $basePath
 * @property mixed $flashes
 * @property BasePresenter $presenter
 * @property AppAdmin $appAdmin
 * @property MenuGroup[] $menuItems
 * @property stdClass $_l
 * @property stdClass $_g
 * @property stdClass $_b
 * @method bool isLinkCurrent(string $destination = null, $args = [])
 * @method bool isModuleCurrent(string $module)
 * @method string|null getModalComponentName()
 */
class LayoutTemplate
{
}
