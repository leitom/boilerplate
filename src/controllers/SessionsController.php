<?php namespace Leitom\Boilerplate\Controllers;

use View, Auth, Input, Redirect, Config, MessageBag;

class SessionsController extends BaseController {

	/**
	 * Master layout for all the subviews
	 *
	 * @var string $layout
	 */
	protected $layout = 'leitom.boilerplate::public_master';

	/**
	 * Constructor takes care of dependency injections
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Protect against csrf
		$this->beforeFilter('csrf', array('only' => array('store')));
	}

	/**
	 * Show the form for logging in
	 *
	 * @return Response
	 */
	public function create()
	{
        $this->layout->content = View::make('leitom.boilerplate::login');
	}

	/**
	 * Try to log the user in
	 *
	 * @return Response
	 */
	public function store()
	{
		$credentials = array(
			'username' => Input::get('username'),
			'password' => Input::get('password'),
			'active'   => 1
		);
		
		if (Auth::attempt($credentials, Input::get('remember'))) return Redirect::intended('app/dashboard');

		return Redirect::to("$this->prefix/$this->loginAlias")->withInput()->with('loginError', trans('leitom.boilerplate::sessions.wrong_username_or_password'));
	}

	/**
	 * Log the user out
	 *
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();

		return Redirect::to("$this->prefix/$this->loginAlias")->with('logoutMessage', trans('leitom.boilerplate::sessions.logged_out'));
	}

}
