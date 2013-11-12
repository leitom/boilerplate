<?php namespace Leitom\Boilerplate;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Leitom\Boilerplate\Extensions\Eloquent\Model;

class UserProfile extends Model {

	protected $table = 'userprofiles';

	protected $guarded = array();

	public static $rules = array();

	public function user()
	{
		return $this->belongsTo('Leitom\Boilerplate\User');
	}

}
