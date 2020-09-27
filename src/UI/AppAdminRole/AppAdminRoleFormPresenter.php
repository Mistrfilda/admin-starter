<?php

declare(strict_types=1);

namespace App\UI\AppAdminRole;

use App\AppAdminRole\UI\Form\AppAdminRoleFormFactory;
use App\UI\Base\BasePresenter;
use App\UI\Base\Control\AdminForm;
use Nette\Application\BadRequestException;
use Ramsey\Uuid\Nonstandard\Uuid;

class AppAdminRoleFormPresenter extends BasePresenter
{
	private AppAdminRoleFormFactory $appAdminRoleFormFactory;

	public function __construct(AppAdminRoleFormFactory $appAdminRoleFormFactory)
	{
		parent::__construct();
		$this->appAdminRoleFormFactory = $appAdminRoleFormFactory;
	}

	public function renderEdit(string $id): void
	{
	}

	protected function createComponentAppAdminRoleForm(): AdminForm
	{
		$id = $this->getParameter('id');
		if ($id === null) {
			throw new BadRequestException();
		}

		$onSuccess = function (): void {
			$this->flashMessage('Roles updated');
			$this->presenter->redirect('this');
		};

		return $this->appAdminRoleFormFactory->create(Uuid::fromString($id), $onSuccess);
	}
}
