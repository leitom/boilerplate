<?php namespace Leitom\Boilerplate\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class UrlHelper extends Facade {
	
	protected static function getFacadeAccessor() { return 'BoilerplateURL'; }

}