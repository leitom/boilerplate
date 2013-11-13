<?php namespace Leitom\Boilerplate\Composers;

use View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider {

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
		// Public master
		View::composer('leitom.boilerplate::public_master', 'Leitom\Boilerplate\Composers\PublicMasterComposer');

		// App master
		View::composer('leitom.boilerplate::app_master', 'Leitom\Boilerplate\Composers\AppMasterComposer');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		
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