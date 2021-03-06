<?php

declare(strict_types=1);

namespace App\AppAdmin;

use Nette\Security\User;

class CurrentAppAdminGetter
{
	private User $user;

	private AppAdminRepository $appAdminRepository;

	public function __construct(User $user, AppAdminRepository $appAdminRepository)
	{
		$this->user = $user;
		$this->appAdminRepository = $appAdminRepository;
	}

	public function isLoggedIn(): bool
	{
		return $this->user->isLoggedIn();
	}

	public function getLoggedAppAdmin(): AppAdmin
	{
		if (! $this->isLoggedIn() || $this->user->getIdentity() === null) {
			throw new AppAdminNotLoggedInException();
		}

		return $this->appAdminRepository->getById($this->user->getIdentity()->getId());
	}

	public function login(string $username, string $password): void
	{
		$this->user->login($username, $password);
	}

	public function logout(): void
	{
		$this->user->logout(true);
	}
}
