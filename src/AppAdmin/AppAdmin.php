<?php

declare(strict_types=1);

namespace App\AppAdmin;

use App\AppAdminRole\AppAdminRole;
use App\Doctrine\IEntity;
use App\Doctrine\SimpleUuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_admin")
 */
class AppAdmin implements IEntity
{
	use SimpleUuid;

	/**
	 * @ORM\Column(type="string")
	 */
	private string $name;

	/**
	 * @ORM\Column(type="string", unique=true)
	 */
	private string $username;

	/**
	 * @ORM\Column(type="string", unique=true)
	 */
	private string $email;

	/**
	 * @ORM\Column(type="string")
	 */
	private string $password;

	/**
	 * @var Collection<int, AppAdminRole>
	 * @ORM\ManyToMany(targetEntity="App\AppAdminRole\AppAdminRole", inversedBy="users")
	 */
	private Collection $roles;

	public function __construct(
		string $name,
		string $username,
		string $email,
		string $password
	) {
		$this->id = Uuid::uuid4();
		$this->name = $name;
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;

		$this->roles = new ArrayCollection();
	}

	public function update(
		string $name,
		string $email
	): void {
		$this->name = $name;
		$this->email = $email;
	}

	public function updatePassword(string $password): void
	{
		$this->password = $password;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @return AppAdminRole[]
	 */
	public function getRoles(): array
	{
		return $this->roles->toArray();
	}

	public function addRole(AppAdminRole $appAdminRole): void
	{
		if ($this->roles->contains($appAdminRole) === false) {
			$this->roles->add($appAdminRole);
		}
	}

	public function removeRole(AppAdminRole $appAdminRole): void
	{
		if ($this->roles->contains($appAdminRole)) {
			$this->roles->removeElement($appAdminRole);
		}
	}
}
