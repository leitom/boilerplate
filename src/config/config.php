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
	| Login view
	|--------------------------------------------------------------------------
	|
	| The login view the application should use
	|
	*/	

	'loginView' => 'leitom.boilerplate::login',

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
	| Default app page
	|--------------------------------------------------------------------------
	|
	| Default login page for the application
	| When a user logs in we try to serve the request url, but if that does
	| not exists we provide a default one.
	|
	*/	

	'defaultAppPage' => 'dashboard',

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
	| New account view
	|--------------------------------------------------------------------------
	|
	| The login view the application should use
	|
	*/	

	'newAccountView' => 'leitom.boilerplate::account.create',

	/*
	|--------------------------------------------------------------------------
	| Activation sent view
	|--------------------------------------------------------------------------
	|
	| The view to show when an activation email is sent
	|
	*/	

	'activationSentView' => 'leitom.boilerplate::account.sent',

	/*
	|--------------------------------------------------------------------------
	| Activation invalid view
	|--------------------------------------------------------------------------
	|
	| The view to show when an token is invalid
	|
	*/	

	'activationTokenInvalidView' => 'leitom.boilerplate::account.invalid_token',

	/*
	|--------------------------------------------------------------------------
	| Account activation email view
	|--------------------------------------------------------------------------
	|
	| The view to use for parsing and sending an account activation email
	|
	*/	

	'accountActivationEmailView' => 'leitom.boilerplate::account.emails.activation',

	/*
	|--------------------------------------------------------------------------
	| Account activation table
	|--------------------------------------------------------------------------
	|
	| The table to use for account activation
	|
	*/	

	'accountActivationTable' => 'useractivations',

	/*
	|--------------------------------------------------------------------------
	| Account activation expire
	|--------------------------------------------------------------------------
	|
	| When a account activation should expire
	| Default is prox. one month
	|
	*/	

	'accountActivationExpire' => 2629743,
	
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