<?php namespace Leitom\Boilerplate\Providers;

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
		Config::package('leitom/boilerplate', __DIR__.'/../../../config', 'leitom.boilerplate');

		// Language path
		Lang::addNamespace('leitom.boilerplate', __DIR__.'/../../../lang');

		// View path
		View::addNamespace('leitom.boilerplate', __DIR__.'/../../../views');

		// Require filters and routes
		require __DIR__.'/../../../filters.php';
		require __DIR__.'/../../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Asset provider
		$this->app->register('Leitom\Boilerplate\Providers\HelperServiceProvider');

		// Repository provider
		$this->app->register('Leitom\Boilerplate\Providers\RepositoryServiceProvider');

		// View composer provider
		$this->app->register('Leitom\Boilerplate\Providers\ViewComposerServiceProvider');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}