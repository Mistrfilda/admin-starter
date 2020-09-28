<?php

declare(strict_types=1);

namespace App\Right\Command;

use App\Right\RightFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessNewRightsCommand extends Command
{
	private RightFacade $appAdminRoleFacade;

	public function __construct(RightFacade $appAdminRoleFacade)
	{
		parent::__construct();
		$this->appAdminRoleFacade = $appAdminRoleFacade;
	}

	protected function configure(): void
	{
		parent::configure();
		$this->setName('user:rights:process');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$output->writeln('Processing roles');
		$this->appAdminRoleFacade->processAll();
		$output->writeln('<info>Roles processed</info>');
		return 0;
	}
}
