<?php namespace Leitom\Boilerplate\Controllers;

use View, Config;

class BaseController extends \Controller {

	/**
	 * Url/route prefix for the application
	 * This var can be configured in the config file
	 *
	 * @var string $prefix
	 */
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
		$this->prefix = Config::get('leitom.boilerplate::prefix');

		// Login alias
		$this->loginAlias = Config::get('leitom.boilerplate::loginAlias');

		// Logout alias
		$this->logoutAlias = Config::get('leitom.boilerplate::logoutAlias');
	}

}