<?php namespace Leitom\Boilerplate\Controllers;

use View, Config;

class BaseController extends \Controller {

	/**
	 * Url/route prefix for the application
	 * This var can be configured in the config file
	 *
	 * @var string $prefix
	 */
	protected $routePrefix = '';
	protected $prefix = '';

	/**
	 * Alias for the login route
	 * This var can be configured in the config file
	 *
	 * @var string $loginAlias
	 */
	protected $loginAlias = '';

	/**
	 * Alias for the login route
	 * This var can be configured in the config file
	 *
	 * @var string $logoutAlias
	 */
	protected $logoutAlias = '';

	/**
	 * The default app page
	 *
	 * @var string $defaultAppPage
	 */
	protected $defaultAppPage = '';

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}

		// Get routes and aliases from config
		
		// Base prefix
		$this->routePrefix = Config::get('leitom.boilerplate::prefix') ?: '';
		$this->prefix = $this->routePrefix.'/' ?: '';

		// Login alias
		$this->loginAlias = Config::get('leitom.boilerplate::loginAlias');

		// Logout alias
		$this->logoutAlias = Config::get('leitom.boilerplate::logoutAlias');

		// Default app page
		$this->defaultAppPage = Config::Get('leitom.boilerplate::defaultAppPage');
	}

}