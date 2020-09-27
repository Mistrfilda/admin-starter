<?php

declare(strict_types=1);

namespace App\AppAdminRole;

use App\AppAdmin\AppAdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Throwable;

class AppAdminRoleFacade
{
	private EntityManagerInterface $entityManager;

	private AppAdminRepository $appAdminRepository;

	private AppAdminRoleRepository $appAdminRoleRepository;

	public function __construct(
		EntityManagerInterface $entityManager,
		AppAdminRepository $appAdminRepository,
		AppAdminRoleRepository $appAdminRoleRepository
	) {
		$this->entityManager = $entityManager;
		$this->appAdminRepository = $appAdminRepository;
		$this->appAdminRoleRepository = $appAdminRoleRepository;
	}

	public function create(string $role): AppAdminRole
	{
		$role = new AppAdminRole($role);
		$this->entityManager->persist($role);
		$this->entityManager->flush();
		$this->entityManager->refresh($role);
		return $role;
	}

	public function processAll(): void
	{
		foreach (Role::ALL as $role) {
			try {
				$this->appAdminRoleRepository->getByRole($role);
			} catch (Throwable $e) {
				$role = new AppAdminRole($role);
				$this->entityManager->persist($role);
			}
		}

		$this->entityManager->flush();
		$this->entityManager->clear();
	}

	/**
	 * @param array<int, string> $values
	 */
	public function updateUserRoles(UuidInterface $userId, array $values): void
	{
		$user = $this->appAdminRepository->getById($userId);
		$roles = $this->appAdminRoleRepository->findAll();

		foreach ($roles as $role) {
			if (in_array($role->getId()->toString(), $values, true)) {
				$role->addUser($user);
				$user->addRole($role);
			} else {
				$role->removeUser($user);
				$user->removeRole($role);
			}
		}

		$this->entityManager->flush();
		$this->entityManager->refresh($user);
	}

	/**
	 * @param array<string, string> $roles
	 */
	public function addRolesToUser(UuidInterface $userId, array $roles): void
	{
		$user = $this->appAdminRepository->getById($userId);
		$roles = $this->appAdminRoleRepository->findByRoles($roles);
		foreach ($roles as $role) {
			$role->addUser($user);
			$user->addRole($role);
		}

		$this->entityManager->flush();
		$this->entityManager->refresh($user);
	}
}
