<?php

declare(strict_types=1);

namespace App\UI\Base\Menu;

class MenuGroup
{
	private string $label;

	private bool $showLabel;

	private ?string $right;

	/** @var MenuItem[] */
	private array $menuItems;

	/**
	 * MenuGroup constructor.
	 * @param MenuItem[] $menuItems
	 */
	public function __construct(string $label, bool $showLabel, ?string $right, array $menuItems)
	{
		$this->label = $label;
		$this->showLabel = $showLabel;
		$this->menuItems = $menuItems;
		$this->right = $right;
	}

	public function getLabel(): string
	{
		return $this->label;
	}

	public function shouldShowLabel(): bool
	{
		return $this->showLabel;
	}

	/**
	 * @return MenuItem[]
	 */
	public function getMenuItems(): array
	{
		return $this->menuItems;
	}

	public function getRight(): ?string
	{
		return $this->right;
	}
}
