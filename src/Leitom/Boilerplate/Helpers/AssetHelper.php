<?php namespace Leitom\Boilerplate\Helpers;

class AssetHelper {

	/**
	 * Root path to leitom/boilerplate assets
	 *
	 * @var string $packagePath
	 */
	protected $packagePath = '/packages/leitom/boilerplate/';

	/**
	 * Get styles from the boilerplate part of the application
	 *
	 * @param string $path
	 * @return HTML::style
	 */
	public function style($path = '')
	{
		if($fullPath = $this->getFile('css', $path)) return \HTML::style($fullPath);
	}

	/**
	 * Get scripts from the boilerplate part of the application
	 *
	 * @param string $path
	 * @return HTML::script
	 */
	public function script($path = '')
	{
		if($fullPath = $this->getFile('js', $path)) return \HTML::script($fullPath);
	}

	/**
	 * Get images from the boilerplate part of the application
	 *
	 * @param string $path
	 * @return string
	 */
	public function image($path = '')
	{
		if($fullPath = $this->getFile('img', $path)) return $fullPath;
	}

	/**
	 * Check if a required file exists and return it
	 *
	 * @param string $type
	 * @param string $path
	 * @return string/boolean
	 */
	private function getFile($type, $path)
	{
		if($type && $path)
		{
			$filePath = "$this->packagePath$type/$path";
			
			if(file_exists(public_path().$filePath)) return $filePath;

			return false;
		}
	}

}