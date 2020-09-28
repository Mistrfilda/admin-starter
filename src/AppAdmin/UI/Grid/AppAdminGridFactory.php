<?php

declare(strict_types=1);

namespace App\AppAdmin\UI\Grid;

use App\AppAdmin\AppAdminRepository;
use App\UI\Base\Control\AdminDatagrid;
use App\UI\Base\Control\AdminDatagridFactory;

class AppAdminGridFactory
{
	private AdminDatagridFactory $gridFactory;

	private AppAdminRepository $appAdminRepository;

	public function __construct(
		AdminDatagridFactory $gridFactory,
		AppAdminRepository $appAdminRepository
	) {
		$this->gridFactory = $gridFactory;
		$this->appAdminRepository = $appAdminRepository;
	}

	public function create(): AdminDatagrid
	{
		$grid = $this->gridFactory->create();

		$grid->setDataSource($this->appAdminRepository->createQueryBuilder());
		$grid->addColumnText('id', 'ID')->setFilterText();
		$grid->addColumnText('name', 'Name')->setSortable()->setFilterText();
		$grid->addColumnText('username', 'User name')->setSortable()->setFilterText();
		$grid->addColumnText('email', 'Email')->setSortable()->setFilterText();

		$grid->addAction('edit', 'Edit', 'AppAdminForm:edit')
			->setIcon('cog')
			->setClass('btn btn-sm btn-success');

		$grid->addAction('rights', 'Rights', 'AppAdminRightForm:edit')
			->setIcon('list')
			->setClass('btn btn-sm btn-info');

		return $grid;
	}
}
