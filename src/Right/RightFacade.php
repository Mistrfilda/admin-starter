<?php

declare(strict_types=1);

namespace App\Right;

use App\AppAdmin\AppAdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Throwable;

class RightFacade
{
	private EntityManagerInterface $entityManager;

	private AppAdminRepository $appAdminRepository;

	private RightRepository $rightRepository;

	public function __construct(
		EntityManagerInterface $entityManager,
		AppAdminRepository $appAdminRepository,
		RightRepository $rightRepository
	) {
		$this->entityManager = $entityManager;
		$this->appAdminRepository = $appAdminRepository;
		$this->rightRepository = $rightRepository;
	}

	public function create(string $role): Right
	{
		$role = new Right($role);
		$this->entityManager->persist($role);
		$this->entityManager->flush();
		$this->entityManager->refresh($role);
		return $role;
	}

	public function processAll(): void
	{
		foreach (Right::ALL as $role) {
			try {
				$this->rightRepository->getByRole($role);
			} catch (Throwable $e) {
				$role = new Right($role);
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
		$roles = $this->rightRepository->findAll();

		foreach ($roles as $role) {
			if (in_array($role->getId()->toString(), $values, true)) {
				$role->addUser($user);
				$user->addRight($role);
			} else {
				$role->removeUser($user);
				$user->removeRight($role);
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
		$roles = $this->rightRepository->findByRoles($roles);
		foreach ($roles as $role) {
			$role->addUser($user);
			$user->addRight($role);
		}

		$this->entityManager->flush();
		$this->entityManager->refresh($user);
	}
}
