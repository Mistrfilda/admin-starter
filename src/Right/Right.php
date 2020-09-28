<?php

declare(strict_types=1);

namespace App\Right;

use App\AppAdmin\AppAdmin;
use App\Doctrine\IEntity;
use App\Doctrine\SimpleUuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 * @ORM\Table(name="admin_right")
 */
class Right implements IEntity
{
	use SimpleUuid;

	public const USERS = 'users';

	public const EDIT_USER = 'edit_user';

	public const RIGHTS = 'roles';

	public const ALL = [
		self::USERS,
		self::EDIT_USER,
		self::RIGHTS,
	];

	/**
	 * @ORM\Column(type="string", unique=true, name="right_name")
	 */
	private string $right;

	/**
	 * @var Collection<int, AppAdmin>
	 * @ORM\ManyToMany(targetEntity="App\AppAdmin\AppAdmin", mappedBy="rights")
	 */
	private Collection $users;

	public function __construct(string $role)
	{
		$this->id = Uuid::uuid4();
		$this->right = $role;
		$this->users = new ArrayCollection();
	}

	public function getRight(): string
	{
		return $this->right;
	}

	/**
	 * @return AppAdmin[]
	 */
	public function getUsers(): array
	{
		return $this->users->toArray();
	}

	public function addUser(AppAdmin $appAdmin): void
	{
		if ($this->users->contains($appAdmin) === false) {
			$this->users->add($appAdmin);
		}
	}

	public function removeUser(AppAdmin $appAdmin): void
	{
		if ($this->users->contains($appAdmin)) {
			$this->users->removeElement($appAdmin);
		}
	}
}
