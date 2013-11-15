<?php namespace Leitom\Boilerplate\Account\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ClearExpiredActivationsCommand extends Command {
	
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'leitom.boilerplate:clear-activations';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Flush expired activations.';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->laravel['account.repository']->deleteExpired();

		$this->info('Expired activations cleared!');
	}
}
