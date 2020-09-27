<?php

declare(strict_types=1);

namespace App\AppAdminRole;

use App\Doctrine\BaseRepository;
use App\Doctrine\NoEntityFoundException;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends BaseRepository<AppAdminRole>
 */
class AppAdminRoleRepository extends BaseRepository
{
	public function getById(UuidInterface $id): AppAdminRole
	{
		/** @var AppAdminRole|null $appAdminRole */
		$appAdminRole = $this->doctrineRepository->findOneBy(['id' => $id]);

		if ($appAdminRole === null) {
			throw new NoEntityFoundException();
		}

		return $appAdminRole;
	}

	public function getByRole(string $role): AppAdminRole
	{
		/** @var AppAdminRole|null $appAdminRole */
		$appAdminRole = $this->doctrineRepository->findOneBy(['role' => $role]);

		if ($appAdminRole === null) {
			throw new NoEntityFoundException();
		}

		return $appAdminRole;
	}

	/**
	 * @param string[] $ids
	 * @return AppAdminRole[]
	 */
	public function findByIds(array $ids): array
	{
		$qb = $this->doctrineRepository->createQueryBuilder('appAdminRole');
		$qb->andWhere($qb->expr()->in('appAdminRole.id', $ids));

		return $qb->getQuery()->getResult();
	}

	/**
	 * @param string[] $roles
	 * @return AppAdminRole[]
	 */
	public function findByRoles(array $roles): array
	{
		$qb = $this->doctrineRepository->createQueryBuilder('appAdminRole');
		$qb->andWhere($qb->expr()->in('appAdminRole.role', $roles));

		return $qb->getQuery()->getResult();
	}

	/**
	 * @return AppAdminRole[]
	 */
	public function findAll(): array
	{
		return $this->doctrineRepository->findAll();
	}

	/**
	 * @return array<string, string>
	 */
	public function findPairs(): array
	{
		$pairs = [];
		foreach ($this->findAll() as $role) {
			$pairs[$role->getId()->toString()] = $role->getRole();
		}

		return $pairs;
	}

	public function createQueryBuilder(): QueryBuilder
	{
		return $this->doctrineRepository->createQueryBuilder('appAdminRole');
	}
}
