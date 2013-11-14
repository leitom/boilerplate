<?php namespace Leitom\Boilerplate;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Leitom\Boilerplate\Extensions\Eloquent\Model;

class UserProfile extends Model {

	protected $table = 'userprofiles';

	protected $fillable = array('firstname', 'middlename', 'lastname');
	
	protected $audit = true;

	protected $rules = array(
		'create' => array(
			'firstname' => 'required',
			'lastname' 	=> 'required'
		)
	);

	public function user()
	{
		return $this->belongsTo('Leitom\Boilerplate\User');
	}

}
