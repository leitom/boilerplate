<?php

/*
|--------------------------------------------------------------------------
| Leitom\Boilerplate Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// All routes in the Leitom\Boilerplate are default prefixed with << app >>
Route::group(array('prefix' => Config::get('leitom.boilerplate::prefix')), function()
{
	// All open routes

	// Alias for app/sessions/create
	Route::get(Config::get('leitom.boilerplate::loginAlias'), 'Leitom\Boilerplate\Controllers\SessionsController@create');

	// Alias for app/sessions/destroy
	Route::get(Config::get('leitom.boilerplate::logoutAlias'), 'Leitom\Boilerplate\Controllers\SessionsController@destroy');

	// All handeling of sessions goes to the sessions controller
	Route::resource('sessions', 'Leitom\Boilerplate\Controllers\SessionsController', array('only' => array('create', 'store', 'destroy')));

	// Create a new account
	Route::resource('account', 'Leitom\Boilerplate\Controllers\AccountController', array('only' => array('create', 'store', 'show')));

	// All routes and actions secured by the auth filter
	
	Route::group(array('before' => 'auth'), function()
	{
		Route::get('dashboard', function()
		{
			$routes = Route::getRoutes();
			$results = array();
			foreach ($routes as $name => $route) {
				$action = $route->getAction() ?: 'Closure';
				$results[] = array(
					'host'   => $route->getHost(),
					'method' => head($route->getMethods()),
					'uri'    => $route->getPath(),
					'name'   => str_contains($name, ' ') ? '' : $name,
					'action' => $action
				);
			}
			var_dump(array_filter($results)); exit;
		});
	});
});