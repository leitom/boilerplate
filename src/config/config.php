<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Application name
	|--------------------------------------------------------------------------
	|
	| Application name shown in title bar and on page
	|
	*/

	'appName' => 'App',

	/*
	|--------------------------------------------------------------------------
	| Application base prefix
	|--------------------------------------------------------------------------
	|
	| The default base prefix of the boilerplate are << app >>
	| This can be changed here
	|
	*/

	'prefix' => 'app',

	/*
	|--------------------------------------------------------------------------
	| Alias for the login route
	|--------------------------------------------------------------------------
	|
	| Default the login alias is << login >> with prefix app
	|
	*/	

	'loginAlias' => 'login',

	/*
	|--------------------------------------------------------------------------
	| Alias for the logout route
	|--------------------------------------------------------------------------
	|
	| Default the logout alias is << logout >> with prefix app
	|
	*/	

	'logoutAlias' => 'logout',

	/*
	|--------------------------------------------------------------------------
	| Allow user registrations
	|--------------------------------------------------------------------------
	|
	| The boilerplate comes with a user registration view and logic
	| If you dont want it set it to false
	|
	*/

	'allowUserRegistrations' => true,

	/*
	|--------------------------------------------------------------------------
	| User registration default roles
	|--------------------------------------------------------------------------
	|
	| If your application allows user registration we can define wich roles
	| to be appended to the user upon registration
	|
	*/

	'userRegistrationDefaultRoles' => array()

);