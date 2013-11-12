<?php namespace Leitom\Boilerplate;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Leitom\Boilerplate\Extensions\Eloquent\Model;

class UserProfile extends Model {

	protected $table = 'userprofiles';

	protected $guarded = array('id', 'user_id', 'created_by', 'updated_by');

	public static $rules = array();

	protected $audit = true;

	public function user()
	{
		return $this->belongsTo('Leitom\Boilerplate\User');
	}

}
