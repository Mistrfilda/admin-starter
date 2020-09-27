<?php

declare(strict_types=1);

namespace App\AppAdminRole;

class Role
{
	public const USERS = 'users';

	public const EDIT_USER = 'edit_user';

	public const ROLES = 'roles';

	public const ALL = [
		self::USERS,
		self::EDIT_USER,
		self::ROLES,
	];
}
