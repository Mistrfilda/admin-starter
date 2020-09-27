<?php

declare(strict_types=1);

namespace App\AppAdminRole\Command;

use App\AppAdminRole\AppAdminRoleFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessNewRolesCommand extends Command
{
	private AppAdminRoleFacade $appAdminRoleFacade;

	public function __construct(AppAdminRoleFacade $appAdminRoleFacade)
	{
		parent::__construct();
		$this->appAdminRoleFacade = $appAdminRoleFacade;
	}

	protected function configure(): void
	{
		parent::configure();
		$this->setName('user:roles:process');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$output->writeln('Processing roles');
		$this->appAdminRoleFacade->processAll();
		$output->writeln('<info>Roles processed</info>');
		return 0;
	}
}
