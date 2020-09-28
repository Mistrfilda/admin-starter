<?php

declare(strict_types=1);

namespace App\Right\UI\Form;

use App\AppAdmin\AppAdminRepository;
use App\Right\RightFacade;
use App\Right\RightRepository;
use App\UI\Base\Control\AdminForm;
use App\UI\Base\Control\AdminFormFactory;
use Nette\Forms\Form;
use Ramsey\Uuid\UuidInterface;

class AppAdminRightFormFactory
{
	private AdminFormFactory $formFactory;

	private AppAdminRepository $appAdminRepository;

	private RightFacade $appAdminRoleFacade;

	private RightRepository $appAdminRoleRepository;

	public function __construct(
		AdminFormFactory $formFactory,
		AppAdminRepository $appAdminRepository,
		RightFacade $appAdminRoleFacade,
		RightRepository $appAdminRoleRepository
	) {
		$this->formFactory = $formFactory;
		$this->appAdminRepository = $appAdminRepository;
		$this->appAdminRoleFacade = $appAdminRoleFacade;
		$this->appAdminRoleRepository = $appAdminRoleRepository;
	}

	public function create(UuidInterface $userId, callable $onSuccess): AdminForm
	{
		$form = $this->formFactory->create(AppAdminRightFormValues::class);

		$form->addCheckboxList('roles', 'Roles', $this->appAdminRoleRepository->findPairs());
		$form->onSuccess[] = function (Form $form, AppAdminRightFormValues $values) use ($userId, $onSuccess): void {
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
		foreach ($user->getRights() as $role) {
			$defaults['roles'][] = $role->getId();
		}

		$form->setDefaults($defaults);
	}

	private function process(UuidInterface $userId, AppAdminRightFormValues $values): void
	{
		$this->appAdminRoleFacade->updateUserRoles(
			$userId,
			$values->roles
		);
	}
}
