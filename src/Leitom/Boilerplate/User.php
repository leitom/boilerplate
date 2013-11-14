<?php namespace Leitom\Boilerplate;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Leitom\Boilerplate\Extensions\Eloquent\Model;

class User extends Model implements UserInterface, RemindableInterface {

	protected $table = 'users';

	protected $hidden = array('password');

	protected $fillable = array('username', 'email', 'email_confirmation', 'password', 'password_confirmation', 'active');

	protected $audit = true;

	protected $rules = array(
		'create' => array(
			'email' 	=> 'required|email|unique:users|confirmed',
			'username' 	=> 'required|unique:users|min:4',
			'password' 	=> 'required|min:6|confirmed|has:upper,lower,num'
		)
	);

	/**
	 * A user has one profile
	 *
	 * @return Eloquent relationship
	 */
	public function userProfile()
	{
		return $this->hasOne('Leitom\Boilerplate\UserProfile');
	}

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

}