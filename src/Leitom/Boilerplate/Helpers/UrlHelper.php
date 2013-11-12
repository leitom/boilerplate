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
	 * Return a route with prefix
	 *
	 * @param string $route
	 * @return string
	 */
	public function route($route)
	{
		if( ! empty($this->prefix)) return "$this->prefix.$route";

		return $route;
	}

	/**
	 * Return a url based on a route with prefix
	 *
	 * @param string $route
	 * @return string
	 */
	public function routeTo($route)
	{
		if( ! empty($this->prefix)) return route("$this->prefix.$route");

		return route($route);
	}

	/**
	 * Return a url with prefix
	 *
	 * @param string $url
	 * @return string
	 */
	public function to($url)
	{
		return url("$this->prefix/$url");
	}
}