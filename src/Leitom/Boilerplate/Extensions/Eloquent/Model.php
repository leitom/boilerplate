<?php namespace Leitom\Boilerplate\Extensions\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Validation\Validator as Validator;
use Illuminate\Support\MessageBag;
use \Leitom\Boilerplate\Extensions\ValidatorInterface;
use Auth, Str, Hash;

abstract class Model extends Eloquent implements ValidatorInterface {
	
	/**
     * Validator instance
     * 
     * @var Illuminate\Validation\Validator
     */
	protected $validator;
	
	/**
     * MessageBag instance
     * 
     * @var Illuminate\Support\MessageBag
     */
	protected $validateErrors;
	
	/**
	 * A simple boolean to check if the validation failed or not
	 * 
	 * @var boolean
	 */
	protected $validationFailed = false;
	
	/**
	 * List containing all the rules for the Eloquent model
	 * 
	 * @var array $rules
	 */
	protected static $rules = array();
	
	/** 
	 * Custom validation messages
	 *
	 * @var array $customMessages
	 */
	protected static $customMessages = array();

	/**
	 * If we should set the following fields:
	 * created_by, updated_by
	 *
	 * @var boolean $audit
	 */
	protected $audit = false;

	/**
	 * Reconstruct the Illuminate\Database\Eloquent\Model
	 * 
	 * @param array $attributes
	 * @param Illuminate\Validation\Validator
	 * @return void
	 */
	public function __construct(array $attributes = array(), Validator $validator = null)
	{
		parent::__construct($attributes);
		
		$this->validator = $validator ?: \App::make('validator');
		
		$this->validateErrors = new MessageBag;
	}
	
	/**
	 * Override the eloquent save method and do some work on our own
	 *
	 * @param array $options
	 * @return obj
	 */
	public function save(array $options = array())
	{
		if( ! empty($options)) $this->fill($options);

		if( ! $this->validate()) return false;

		$this->purgeRedundant();

		$this->autoHash();

		if($this->audit)
		{
			$this->setCreatedBy();
			$this->setUpdatedBy();
		}

		return parent::save($options);
	}

	/**
	 * Validate all model data here
	 * Based on the rules set in array $this->rules
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		$check = $this->validator->make($this->attributes, static::$rules, static::$customMessages);
		
		if ($check->passes()) return true;
		
		$this->validateErrors = $check->messages();
		$this->validationFailed = true;
		
		return false;
	}
	
	/**
	 * Get validation errors if the validation fails
	 * 
	 * @return Illuminate\Support\MessageBag
	 */
	public function getValidatorErrors()
	{
		return $this->validateErrors;
	}
	
	/**
	 * Check to see if there was any errors validating the model
	 * 
	 * @return boolean
	 */
	public function hasValidatorErrors()
	{
		return $this->validationFailed;
	}

	/**
	 * Purge Redundant fields
	 * Get rid of '_confirm' fields
	 *
	 * @param array $attributes
	 * @return void
	 */
	private function purgeRedundant()
	{
		$clean = array();

		foreach ($this->attributes as $key => $value)
		{
			if ( ! Str::endsWith($key, '_confirmation')) $clean[$key] = $value;
		}
	  
	  	$this->attributes = $clean;
	}

	/**
	 * Auto hash
	 * Auto hash passwords
	 *
	 * @return array $this->attributes
	 */
	private function autoHash()
	{
		if (isset($this->attributes['password']))
	  	{
	    	if ($this->attributes['password'] != $this->getOriginal('password'))
	    	{
	      		$this->attributes['password'] = Hash::make($this->attributes['password']);
	    	}
	  	}
	}

	/**
	 * If audit are enabled for the model
	 * then we set the created by with info from the Auth instance
	 *
	 * @return void
	 */
	protected function setCreatedBy()
	{
		if (Auth::check() && empty($this->attributes['created_by'])) $this->attributes['created_by'] = Auth::User()->id;
	}

	/**
	 * If audit are enabled for the model
	 * then we set the updated by with info from the Auth instance
	 *
	 * @return void
	 */
	protected function setUpdatedBy()
	{
		if (Auth::check())
		{
			if (Auth::User()->id != $this->getOriginal('updated_by')) $this->attributes['updated_by'] = Auth::User()->id;
		}
	}

}