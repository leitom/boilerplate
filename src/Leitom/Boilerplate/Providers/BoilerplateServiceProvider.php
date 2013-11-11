<?php namespace Leitom\Boilerplate\Providers;

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
		$this->package('leitom/boilerplate', 'leitom.boilerplate');

		// Require
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
		// View path
		\View::addNamespace('leitom.boilerplate', __DIR__.'/../../../views');

		// Asset helper
		$this->app->register('Leitom\Boilerplate\Providers\HelperServiceProvider');
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