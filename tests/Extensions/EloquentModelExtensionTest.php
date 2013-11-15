<?php 

use \Mockery as m;
use Leitom\Boilerplate\Extensions\Eloquent\Model;

/**
 * Create an instance of the IdeaModel because it's an abstract class
 */
class ExtensionTest extends Model {
	
	protected $table = 'test';
	
	protected $rules = array(
		'testValue' => 'required',
		'email'		=> 'required|email'
	);

}

class EloquentModelExtensionTest extends BoilerplateTestCase {
	use \Way\Tests\ModelHelpers;
	
	public function testThatValidationFails()
	{
		$response = m::mock('StdClass');
		$response->shouldReceive('passes')->once()->andReturn(false);
		$response->shouldReceive('messages')->once()->andReturn(array('messages' => array()));
		
        $validation = m::mock('Illuminate\Validation\Validator');
        $validation->shouldReceive('make')
                   ->once()
                   ->andReturn($response);
		
		$model = new ExtensionTest(array(), $validation);
		
		$this->assertFalse($model->validate(), 'Validator did not fail');
		
		$this->assertTrue($model->hasValidatorErrors(), 'Validator boolean did not return false');
	}
	
	public function testThatValidationPasses()
	{
		$response = m::mock('StdClass');
        $response->shouldReceive('passes')->once()->andReturn(true);

        $validation = m::mock('Illuminate\Validation\Validator');
        $validation->shouldReceive('make')
                   ->once()
                   ->andReturn($response);
		
		$model = new ExtensionTest(array(), $validation);
		$model->testValue = 'Testing!';
		$model->email = 'test@test.no';
		
		$this->assertTrue($model->validate(), 'Validator did fail');
		
		$this->assertFalse($model->hasValidatorErrors(), 'Validator boolean dit not return true');
	}
	
}