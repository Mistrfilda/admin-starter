<?php

declare(strict_types=1);

namespace App\AppAdmin\UI\Form;

use App\AppAdmin\AppAdminFacade;
use App\AppAdmin\AppAdminRepository;
use App\UI\Base\Control\AdminForm;
use App\UI\Base\Control\AdminFormFactory;
use Nette\Forms\Form;
use Ramsey\Uuid\UuidInterface;

class AppAdminFormFactory
{
	private AdminFormFactory $formFactory;

	private AppAdminRepository $appAdminFormRepository;

	private AppAdminFacade $appAdminFacade;

	public function __construct(
		AdminFormFactory $formFactory,
		AppAdminRepository $appAdminFormRepository,
		AppAdminFacade $appAdminFacade
	) {
		$this->formFactory = $formFactory;
		$this->appAdminFormRepository = $appAdminFormRepository;
		$this->appAdminFacade = $appAdminFacade;
	}

	public function create(?UuidInterface $id, callable $onSuccess): AdminForm
	{
		$form = $this->formFactory->create(AppAdminFormValues::class);

		$form->addText('name', 'Name')->setRequired();

		$username = $form->addText('username', 'Username');

		$form->addText('email', 'Email')
			->addRule(Form::EMAIL)
			->setRequired();

		$password = $form->addPassword('password', 'Password')
			->setNullable();

		if ($id !== null) {
			$username->setDisabled();
			$this->setDefaults($id, $form);
		} else {
			$password->setRequired();
			$username->setRequired();
		}

		$form->onSuccess[] = function (AdminForm $form, AppAdminFormValues $appAdminFormValues) use ($id, $onSuccess): void {
			if ($id !== null) {
				$this->updateAppAdmin($form, $appAdminFormValues, $id);
			} else {
				$this->createAppAdmin($form, $appAdminFormValues);
			}

			$onSuccess();
		};

		$form->addSubmit('submit', 'Submit');

		return $form;
	}

	private function setDefaults(UuidInterface $id, AdminForm $form): void
	{
		$appAdmin = $this->appAdminFormRepository->getById($id);
		$form->setDefaults([
			'name' => $appAdmin->getName(),
			'username' => $appAdmin->getUsername(),
			'email' => $appAdmin->getEmail(),
		]);
	}

	private function createAppAdmin(AdminForm $form, AppAdminFormValues $appAdminFormValues): void
	{
		if ($appAdminFormValues->password === null) {
			/** @phpstan-ignore-next-line */
			$form['password']->addError('Password is required');
			return;
		}

		$this->appAdminFacade->createAppAdmin(
			$appAdminFormValues->name,
			$appAdminFormValues->username,
			$appAdminFormValues->email,
			$appAdminFormValues->password
		);
	}

	private function updateAppAdmin(AdminForm $form, AppAdminFormValues $appAdminFormValues, UuidInterface $id): void
	{
		$this->appAdminFacade->updateAppAdmin(
			$id,
			$appAdminFormValues->name,
			$appAdminFormValues->password,
			$appAdminFormValues->email
		);
	}
}
