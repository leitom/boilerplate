<?php namespace Leitom\Boilerplate\Composers;

use Config, Request;

class AppMasterComposer {
	
	public function compose($view)
	{
		$view->with('title', Config::get('leitom.boilerplate::appName').' / '.Request::segment(2));
	}

}