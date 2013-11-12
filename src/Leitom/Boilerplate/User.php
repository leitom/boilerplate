<?php namespace Leitom\Boilerplate;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Leitom\Boilerplate\Extensions\Eloquent\Model;

class User extends Model implements UserInterface, RemindableInterface {

	protected $table = 'users';

	protected $hidden = array('password');

	protected $fillable = array('username', 'email', 'password');

	protected $audit = true;

	public static $rules = array(
		'email' 	=> 'required|unique:users',
		'username' 	=> 'required|unique:users',
		'password' 	=> 'required|min:6'
	);

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * A user has one profile
	 *
	 * @return Eloquent relationship
	 */
	public function userProfile()
	{
		return $this->hasOne('Leitom\Boilerplate\UserProfile');
	}

}