<?php namespace Leitom\Boilerplate\Controllers;

use View, Config, Input, Redirect, Account;
use \Leitom\Boilerplate\Repositories\UsersRepositoryInterface;

class AccountController extends BaseController {

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
			$path = strlen($this->routePrefix) > 0 ? "$this->routePrefix.account.update" : "account.update";

			Account::sendActivation($user->email, $path);

			return Redirect::to("$this->prefix$this->loginAlias")->with('logoutMessage', trans('leitom.boilerplate::account.account_created'));
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
		Account::activate($token, function($user)
		{
			return Redirect::to("$this->prefix$this->loginAlias")->with('logoutMessage', trans('leitom.boilerplate::account.account_activated'));
		});
		
		return "Token not valid";
	}

}