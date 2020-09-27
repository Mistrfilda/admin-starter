<?php

declare(strict_types=1);

namespace App\AppAdminRole;

use App\AppAdmin\AppAdmin;
use App\Doctrine\IEntity;
use App\Doctrine\SimpleUuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_admin_role")
 */
class AppAdminRole implements IEntity
{
	use SimpleUuid;

	/**
	 * @ORM\Column(type="string", unique=true)
	 */
	private string $role;

	/**
	 * @var Collection<int, AppAdmin>
	 * @ORM\ManyToMany(targetEntity="App\AppAdmin\AppAdmin", mappedBy="roles")
	 */
	private Collection $users;

	public function __construct(string $role)
	{
		$this->id = Uuid::uuid4();
		$this->role = $role;
		$this->users = new ArrayCollection();
	}

	public function getRole(): string
	{
		return $this->role;
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
