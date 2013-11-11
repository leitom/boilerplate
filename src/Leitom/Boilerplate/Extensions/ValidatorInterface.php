<?php namespace Leitom\Boilerplate\Extensions;

interface ValidatorInterface {
	
	/**
	 * Function that runs the actual validation
	 *
	 * @return boolean
	 */
	public function validate();

	/**
	 * Return all validation errors in the message bag
	 *
	 * @return Illuminate\Support\MessageBag
	 */
	public function getValidatorErrors();
	
	/**
	 * If there are validation errors we can check that by calling
	 * this function
	 *
	 * @return boolean
	 */
	public function hasValidatorErrors();
	
}