<?php namespace Leitom\Boilerplate;

use View, Config, Lang;
use Illuminate\Support\ServiceProvider;

class BoilerplateServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Init the package
		$this->package('leitom/boilerplate');

		// Config path
		Config::package('leitom/boilerplate', __DIR__.'/../../config', 'leitom.boilerplate');

		// Language path
		Lang::addNamespace('leitom.boilerplate', __DIR__.'/../../lang');

		// View path
		View::addNamespace('leitom.boilerplate', __DIR__.'/../../views');

		// Require filters and routes
		require __DIR__.'/../../filters.php';
		require __DIR__.'/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerServiceProviders();

		$this->registerCommands();
	}

	/**
	 * Register all the service providers that boilerplate depend on
	 *
	 * @return void
	 */
	protected function registerServiceProviders()
	{
		// Extensions provider
		$this->app->register('Leitom\Boilerplate\Extensions\ExtensionsServiceProvider');

		// Asset provider
		$this->app->register('Leitom\Boilerplate\Helpers\HelperServiceProvider');

		// Repository provider
		$this->app->register('Leitom\Boilerplate\Repositories\RepositoryServiceProvider');

		// View composer provider
		$this->app->register('Leitom\Boilerplate\Composers\ViewComposerServiceProvider');

		// Account service provider
		$this->app->register('Leitom\Boilerplate\Account\AccountServiceProvider');
	}

	/**
	 * Register the main boilerplate related console commands.
	 *
	 * @return void
	 */
	protected function registerCommands()
	{
		$app = $this->app;

		$app['command.leitom.boilerplate.install'] = $app->share(function($app)
		{
			return new Console\InstallBoilerplateCommand($app['files']);
		});

		$this->commands('command.leitom.boilerplate.install');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.leitom.boilerplate');
	}

}