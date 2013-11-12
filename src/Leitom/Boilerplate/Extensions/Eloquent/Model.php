<?php namespace Leitom\Boilerplate\Extensions\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Validation\Validator as Validator;
use Illuminate\Support\MessageBag;
use \Leitom\Boilerplate\Extensions\ValidatorInterface;
use Auth;

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
	 * Validate all model data here
	 * Based on the rules set in array $this->rules
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		$check = $this->validator->make($this->attributes, static::$rules);
		
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
	 * If audit are enabled for the model
	 * then we set the created by with info from the Auth instance
	 *
	 * @return void
	 */
	protected function setCreatedBy()
	{
		$this->attributes['created_by'] = Auth::check() ? Auth::User()->id : 1;
	}

	/**
	 * If audit are enabled for the model
	 * then we set the updated by with info from the Auth instance
	 *
	 * @return void
	 */
	protected function setUpdatedBy()
	{
		$this->attributes['updated_by'] = Auth::check() ? Auth::User()->id : 1;
	}

	/**
	 * Laravel Eloquent models comes with a handy boot function
	 * this allows us to listen to events created by the model
	 * 
	 * @return boolean
	 */
	protected static function boot()
	{
		parent::boot();
		
		// Event listeners
		static::saving(function($model)
		{
			return $model->validate();
		});
	}

}