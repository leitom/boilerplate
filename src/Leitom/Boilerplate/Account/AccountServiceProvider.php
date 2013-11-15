<?php namespace Leitom\Boilerplate\Account;

use View, Config;
use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerAccountBroker();

		$this->registerAccountRepository();

		$this->registerFacades();

		$this->registerCommands();
	}

	/**
	 * Register the account broker instance.
	 *
	 * @return void
	 */
	protected function registerAccountBroker()
	{
		$this->app['account.broker'] = $this->app->share(function($app)
		{
			// The account repository is responsible for storing the user e-mail addresses
			// and activation tokens. It will be used to verify the tokens are valid.
			// We will resolve an implementation here.
			$accountActivationRepository = $app['account.repository'];

			//$users = $app['Leitom\Boilerplate\Repositories\UsersRepositoryInterface'];
			$users = $app['auth']->driver()->getProvider();

			$view = $app['config']->get('leitom.boilerplate::accountActivationEmailView');

			// The Account broker uses the activation repository to validate tokens and send
			// account activation e-mails
			return new AccountBroker(

				$accountActivationRepository, $users, $app['mailer'], $view

			);
		});
	}

	/**
	 * Register the account repository implementation.
	 *
	 * @return void
	 */
	protected function registerAccountRepository()
	{
		$app = $this->app;

		$app['account.repository'] = $app->share(function($app)
		{
			$connection = $app['db']->connection();

			// The database account repository is an implementation of the account activation repo
			// interface, and is responsible for the actual storing of auth tokens and
			// their e-mail addresses. We will inject this table and hash key to it.
			$table = $app['config']->get('leitom.boilerplate::accountActivationTable');

			$key = $app['config']['app.key'];

			$expire = $app['config']->get('leitom.boilerplate::accountActivationExpire', 2629743);

			return new DatabaseAccountActivationRepository($connection, $table, $key, $expire);
		});
	}

	/**
	 * Register the account related console commands.
	 *
	 * @return void
	 */
	protected function registerCommands()
	{
		$app = $this->app;

		$app['command.leitom.boilerplate.account.make'] = $app->share(function($app)
		{
			return new Console\MakeActivationsCommand($app['files']);
		});

		$app['command.leitom.boilerplate.account.clear'] = $app->share(function($app)
		{
			return new Console\ClearExpiredActivationsCommand;
		});

		$this->commands('command.leitom.boilerplate.account.make', 'command.leitom.boilerplate.account.clear');
	}

	/**
	 * Register facades
	 *
	 * @return void
	 */
	protected function registerFacades()
	{
		// Connect parts to the laravel application boot
		$this->app->booting(function()
		{
			// Load facades aliases
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			// Account facade
			$loader->alias('Account', 'Leitom\Boilerplate\Account\Facades\Account');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('account.repository', 'account.broker', 'command.leitom.boilerplate.account');
	}

}
