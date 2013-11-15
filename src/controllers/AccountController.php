<?php namespace Leitom\Boilerplate\Controllers;

use View, Config, Input, Redirect, Account;
use \Leitom\Boilerplate\Repositories\UsersRepositoryInterface;

class AccountController extends BaseController {

	protected $layout = 'leitom.boilerplate::public_master';

	protected $users;

	public function __construct(UsersRepositoryInterface $users)
	{
		$this->users = $users;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make(Config::get('leitom.boilerplate::newAccountView'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		$user = $this->users->create($input);

		if ( ! $user->hasValidatorErrors())
		{
			$path = strlen($this->routePrefix) > 0 ? "$this->routePrefix.account.show" : "account.show";

			Account::sendActivation($user->email, $path, function($m, $user)
			{
				$m->subject('User Account Activation on boilerplate.com');
			});

			// Show the configured sent page.
			$this->layout->content = View::make(Config::get('leitom.boilerplate::activationSentView', compact('user'));
		}

		return Redirect::to("{$this->prefix}account/create")->withErrors($user->getValidatorErrors())->withInput();
	}

	/**
	 * Edit resource
	 *
	 * @return Response
	 */
	public function show($token)
	{
		$user = Account::activate($token);

		if($user)
			return Redirect::to("$this->prefix$this->loginAlias")->with('logoutMessage', trans('leitom.boilerplate::account.account_activated'));
		else
			$this->layout->content = View::make(Config::get('leitom.boilerplate::activationTokenInvalidView'));
	}

}