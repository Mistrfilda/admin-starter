<?php

declare(strict_types=1);

namespace App\UI\AppAdmin;

use App\AppAdmin\UI\Grid\AppAdminGridFactory;
use App\UI\AppAdmin\templates\AppAdminGridTemplate;
use App\UI\Base\BasePresenter;
use App\UI\Base\Control\AdminDatagrid;

/**
 * @property AppAdminGridTemplate $template
 */
class AppAdminGridPresenter extends BasePresenter
{
	private AppAdminGridFactory $appAdminGridFactory;

	public function __construct(AppAdminGridFactory $appAdminGridFactory)
	{
		parent::__construct();
		$this->appAdminGridFactory = $appAdminGridFactory;
	}

	protected function createComponentAppAdminGrid(): AdminDatagrid
	{
		return $this->appAdminGridFactory->create();
	}
}
