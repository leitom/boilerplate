<?php namespace Leitom\Boilerplate\Composers;

use Config, Request;

class PublicMasterComposer {
	
	public function compose($view)
	{
		$view->with('title', Config::get('leitom.boilerplate::appName').' / '.Request::segment(2));
	}

}