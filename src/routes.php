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
Route::group(array('prefix' => 'app'), function()
{
	// All open routes

	// Alias for app/sessions/create
	Route::get('login', 'Leitom\Boilerplate\Controllers\SessionsController@create');

	// Alias for app/sessions/destroy
	Route::get('logout', 'Leitom\Boilerplate\Controllers\SessionsController@destroy');

	// All handeling of sessions goes to the sessions controller
	Route::resource('sessions', 'Leitom\Boilerplate\Controllers\SessionsController');

	// All routes and actions secured by the auth filter
	
	Route::group(array('before' => 'auth'), function()
	{
		Route::get('dashboard', function()
		{
			return "Welcome to the dashboard!";
		});
	});
});