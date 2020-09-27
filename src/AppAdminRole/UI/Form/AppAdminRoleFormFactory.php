<?php

declare(strict_types=1);

namespace App\AppAdminRole\UI\Form;

use App\AppAdmin\AppAdminRepository;
use App\AppAdminRole\AppAdminRoleFacade;
use App\AppAdminRole\AppAdminRoleRepository;
use App\UI\Base\Control\AdminForm;
use App\UI\Base\Control\AdminFormFactory;
use Nette\Forms\Form;
use Ramsey\Uuid\UuidInterface;

class AppAdminRoleFormFactory
{
	private AdminFormFactory $formFactory;

	private AppAdminRepository $appAdminRepository;

	private AppAdminRoleFacade $appAdminRoleFacade;

	private AppAdminRoleRepository $appAdminRoleRepository;

	public function __construct(
		AdminFormFactory $formFactory,
		AppAdminRepository $appAdminRepository,
		AppAdminRoleFacade $appAdminRoleFacade,
		AppAdminRoleRepository $appAdminRoleRepository
	) {
		$this->formFactory = $formFactory;
		$this->appAdminRepository = $appAdminRepository;
		$this->appAdminRoleFacade = $appAdminRoleFacade;
		$this->appAdminRoleRepository = $appAdminRoleRepository;
	}

	public function create(UuidInterface $userId, callable $onSuccess): AdminForm
	{
		$form = $this->formFactory->create(AppAdminRoleFormValues::class);

		$form->addCheckboxList('roles', 'Roles', $this->appAdminRoleRepository->findPairs());
		$form->onSuccess[] = function (Form $form, AppAdminRoleFormValues $values) use ($userId, $onSuccess): void {
			$this->process($userId, $values);
			$onSuccess();
		};

		$this->setDefaults($form, $userId);

		$form->addSubmit('submit', 'Submit');
		return $form;
	}

	private function setDefaults(AdminForm $form, UuidInterface $userId): void
	{
		$user = $this->appAdminRepository->getById($userId);
		$defaults = [];
		foreach ($user->getRoles() as $role) {
			$defaults['roles'][] = $role->getId();
		}

		$form->setDefaults($defaults);
	}

	private function process(UuidInterface $userId, AppAdminRoleFormValues $values): void
	{
		$this->appAdminRoleFacade->updateUserRoles(
			$userId,
			$values->roles
		);
	}
}
