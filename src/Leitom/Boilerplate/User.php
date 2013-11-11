<?php namespace Leitom\Boilerplate;

use \Leitom\Boilerplate\Extensions\Eloquent\BoilerplateModel;

class User extends BoilerplateModel {

	protected $table = 'users';

	protected $guarded = array('password');

	public static $rules = array(
		'firstname' => 'required',
		'lastname' 	=> 'required',
		'email' 	=> 'required|unique:users',
		'username' 	=> 'required|unique:users',
		'password' 	=> 'required'
	);

}
