<?php

declare(strict_types=1);

namespace App\UI\AppAdminRight;

use App\Right\Right;
use App\Right\UI\Form\AppAdminRightFormFactory;
use App\UI\Base\BasePresenter;
use App\UI\Base\Control\AdminForm;
use Nette\Application\BadRequestException;
use Ramsey\Uuid\Nonstandard\Uuid;

class AppAdminRightFormPresenter extends BasePresenter
{
	private AppAdminRightFormFactory $appAdminRoleFormFactory;

	public function __construct(AppAdminRightFormFactory $appAdminRoleFormFactory)
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
			$this->flashMessage('Rights updated');
			$this->presenter->redirect('this');
		};

		return $this->appAdminRoleFormFactory->create(Uuid::fromString($id), $onSuccess);
	}

	protected function getRightForPresenter(): ?string
	{
		return Right::RIGHTS;
	}
}
