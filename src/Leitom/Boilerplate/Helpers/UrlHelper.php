<?php namespace Leitom\Boilerplate\Helpers;

use Config;

class UrlHelper {

	/**
	 * Applications defined prefix in config
	 *
	 * @var string $prefix
	 */
	protected $prefix;

	public function __construct()
	{
		$this->prefix = Config::get('leitom.boilerplate::prefix');
	}

	/**
	 * return a route with prefix
	 *
	 * @param string $route
	 * @return string
	 */
	public function route($route)
	{
		return "$this->prefix.$route";
	}

}