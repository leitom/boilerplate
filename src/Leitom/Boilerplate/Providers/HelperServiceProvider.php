<?php namespace Leitom\Boilerplate\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider {

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
	
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Asset helper
		$this->app['BoilerplateAsset'] = $this->app->share(function($app)
		{
			return new \Leitom\Boilerplate\Helpers\AssetHelper;
		});

		// Url helper
		$this->app['BoilerplateURL'] = $this->app->share(function($app)
		{
			return new \Leitom\Boilerplate\Helpers\UrlHelper;
		});

		// Connect parts to the laravel application boot
		$this->app->booting(function()
		{
			// Load facades aliases
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			// Assets
			$loader->alias('BoilerplateAsset', 'Leitom\Boilerplate\Helpers\Facades\AssetHelper');

			// Url
			$loader->alias('BoilerplateURL', 'Leitom\Boilerplate\Helpers\Facades\UrlHelper');
		});
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