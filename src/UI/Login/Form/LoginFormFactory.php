<?php

declare(strict_types=1);

namespace App\UI\Login\Form;

use App\AppAdmin\CurrentAppAdminGetter;
use App\UI\Base\Control\AdminForm;
use App\UI\Base\Control\AdminFormFactory;
use Nette\Security\AuthenticationException;

class LoginFormFactory
{
	private AdminFormFactory $adminFormFactory;

	private CurrentAppAdminGetter $currentAppAdminGetter;

	public function __construct(
		AdminFormFactory $adminFormFactory,
		CurrentAppAdminGetter $currentAppAdminGetter
	) {
		$this->adminFormFactory = $adminFormFactory;
		$this->currentAppAdminGetter = $currentAppAdminGetter;
	}

	public function create(callable $onSuccess): AdminForm
	{
		$form = $this->adminFormFactory->create(LoginFormDTO::class);

		$form->addText('username', 'Username')
			->setRequired();

		$form->addPassword('password', 'Password')
			->setRequired();

		$form->addSubmit('submit', 'Submit');

		$form->onSuccess[] = function (AdminForm $form, LoginFormDTO $values) use ($onSuccess): void {
			try {
				$this->currentAppAdminGetter->login($values->username, $values->password);
			} catch (AuthenticationException $e) {
				$form->addError('Invalid username/password combination');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}
