<?php namespace Leitom\Boilerplate\Extensions\Validator;

class BoilerplateValidator extends \Illuminate\Validation\Validator {
	
	public function validateHas($attr, $value, $params)
	{
	    if ( ! count($params))
	    {
	        throw new \InvalidArgumentException('The has validation rule expects at least one parameter, 0 given.');
	    }
    
    	foreach ($params as $param)
    	{
	        switch ($param)
	        {
	            case 'num':
	                $regex = '/\pN/';
	                break;
	            case 'letter':
	                $regex = '/\pL/';
	                break;
	            case 'lower':
	                $regex = '/\p{Ll}/';
	                break;
	            case 'upper':
	                $regex = '/\p{Lu}/';
	                break;
	            case 'special':
	                $regex = '/[\pP\pS]/';
	                break;
	            default:
	                $regex = $param;
	        }
        
        	if ( ! preg_match($regex, $value)) return false;
        }
    	
    	return true;
	}

}