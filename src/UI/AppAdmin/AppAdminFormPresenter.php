<?php

declare(strict_types=1);

namespace App\UI\AppAdmin;

use App\AppAdmin\UI\Form\AppAdminFormFactory;
use App\UI\AppAdmin\templates\AppAdminFormTemplate;
use App\UI\Base\BasePresenter;
use App\UI\Base\Control\AdminForm;
use Nette\Application\BadRequestException;
use Ramsey\Uuid\Uuid;

/**
 * @property AppAdminFormTemplate $template
 */
class AppAdminFormPresenter extends BasePresenter
{
	private AppAdminFormFactory $appAdminFormFactory;

	public function __construct(AppAdminFormFactory $appAdminFormFactory)
	{
		parent::__construct();
		$this->appAdminFormFactory = $appAdminFormFactory;
	}

	public function renderEdit(?string $id): void
	{
		$updateForm = false;
		if ($id !== null) {
			$updateForm = true;
		}

		$this->template->updateForm = $updateForm;
	}

	protected function createComponentCreateAppAdminForm(): AdminForm
	{
		$onSuccess = function (): void {
			$this->flashMessage('User successfully created');
			$this->presenter->redirect('AppAdminGrid:default');
		};

		return $this->appAdminFormFactory->create(null, $onSuccess);
	}

	protected function createComponentUpdateAppAdminForm(): AdminForm
	{
		$id = $this->getParameter('id');
		if ($id === null) {
			throw new BadRequestException();
		}

		$onSuccess = function (): void {
			$this->flashMessage('User successfully update');
			$this->presenter->redirect('AppAdminGrid:default');
		};

		return $this->appAdminFormFactory->create(Uuid::fromString($id), $onSuccess);
	}
}
