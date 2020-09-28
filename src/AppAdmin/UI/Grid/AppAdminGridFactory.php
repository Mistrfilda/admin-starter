<?php

declare(strict_types=1);

namespace App\AppAdmin\UI\Grid;

use App\AppAdmin\AppAdminRepository;
use App\Right\Right;
use App\Right\RightService;
use App\UI\Base\Control\AdminDatagrid;
use App\UI\Base\Control\AdminDatagridFactory;

class AppAdminGridFactory
{
	private AdminDatagridFactory $gridFactory;

	private AppAdminRepository $appAdminRepository;

	private RightService $rightService;

	public function __construct(
		AdminDatagridFactory $gridFactory,
		AppAdminRepository $appAdminRepository,
		RightService $rightService
	) {
		$this->gridFactory = $gridFactory;
		$this->appAdminRepository = $appAdminRepository;
		$this->rightService = $rightService;
	}

	public function create(): AdminDatagrid
	{
		$grid = $this->gridFactory->create();

		$grid->setDataSource($this->appAdminRepository->createQueryBuilder());
		$grid->addColumnText('id', 'ID')->setFilterText();
		$grid->addColumnText('name', 'Name')->setSortable()->setFilterText();
		$grid->addColumnText('username', 'User name')->setSortable()->setFilterText();
		$grid->addColumnText('email', 'Email')->setSortable()->setFilterText();

		if ($this->rightService->isCurrentUserAllowed(Right::EDIT_USER)) {
			$grid->addAction('edit', 'Edit', 'AppAdminForm:edit')
				->setIcon('cog')
				->setClass('btn btn-sm btn-success');
		}

		if ($this->rightService->isCurrentUserAllowed(Right::RIGHTS)) {
			$grid->addAction('rights', 'Rights', 'AppAdminRightForm:edit')
				->setIcon('list')
				->setClass('btn btn-sm btn-info');
		}

		return $grid;
	}
}
