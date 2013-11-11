<?php namespace Leitom\Boilerplate;

use Leitom\Boilerplate\Extensions\Eloquent\Model;

class User extends Model {

	protected $table = 'users';

	protected $softDelete = true;

	protected $guarded = array('password');

	protected $fillable = array('firstname', 'lastname', 'email', 'username', 'password');

	public static $rules = array(
		'firstname' => 'required',
		'lastname' => 'required',
		'email' => 'required:unique',
		'username' => 'required:unique',
		'password' => 'required:min6'
	);

}
