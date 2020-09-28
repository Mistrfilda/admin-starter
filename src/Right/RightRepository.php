<?php

declare(strict_types=1);

namespace App\Right;

use App\Doctrine\BaseRepository;
use App\Doctrine\NoEntityFoundException;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends BaseRepository<Right>
 */
class RightRepository extends BaseRepository
{
	public function getById(UuidInterface $id): Right
	{
		/** @var Right|null $right */
		$right = $this->doctrineRepository->findOneBy(['id' => $id]);

		if ($right === null) {
			throw new NoEntityFoundException();
		}

		return $right;
	}

	public function getByRole(string $role): Right
	{
		/** @var Right|null $right */
		$right = $this->doctrineRepository->findOneBy(['role' => $role]);

		if ($right === null) {
			throw new NoEntityFoundException();
		}

		return $right;
	}

	/**
	 * @param string[] $ids
	 * @return Right[]
	 */
	public function findByIds(array $ids): array
	{
		$qb = $this->doctrineRepository->createQueryBuilder('right');
		$qb->andWhere($qb->expr()->in('right.id', $ids));

		return $qb->getQuery()->getResult();
	}

	/**
	 * @param string[] $rights
	 * @return Right[]
	 */
	public function findByRoles(array $rights): array
	{
		$qb = $this->doctrineRepository->createQueryBuilder('right');
		$qb->andWhere($qb->expr()->in('right.role', $rights));

		return $qb->getQuery()->getResult();
	}

	/**
	 * @return Right[]
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
			$pairs[$role->getId()->toString()] = $role->getRight();
		}

		return $pairs;
	}

	public function createQueryBuilder(): QueryBuilder
	{
		return $this->doctrineRepository->createQueryBuilder('right');
	}
}
