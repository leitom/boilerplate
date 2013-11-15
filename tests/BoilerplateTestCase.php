<?php

use \Mockery as m;

class BoilerplateTestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../../../bootstrap/start.php';
	}

	public function mock($class)
	{
		$mock = m::mock($class);
		
		$this->app->instance($class, $mock);
		
		return $mock;
	}
	
	protected $nestedViewData = array();

    public function registerNestedView($view)
    {
      View::composer($view, function($view){
        $this->nestedViewsData[$view->getName()] = $view->getData();
      }); 
    }

    /**
     * Assert that the given view has a given piece of bound data.
     *
     * @param  string|array  $key
     * @param  mixed  $value
     * @return void
     */
    public function assertNestedViewHas($view, $key, $value = null)
    {
        if (is_array($key)) return $this->assertNestedViewHasAll($view, $key);

        if ( ! isset($this->nestedViewsData[$view]))
        {
            return $this->assertTrue(false, 'The view was not called.');
        }

        $data = $this->nestedViewsData[$view];

        if (is_null($value))
        {
            $this->assertArrayHasKey($key, $data);
        }
        else
        {
            if(isset($data[$key]))
              $this->assertEquals($value, $data[$key]);
            else 
              return $this->assertTrue(false, 'The View has no bound data with this key.');            
        }
    }

   	/**
     * Assert that the view has a given list of bound data.
     *
     * @param  array  $bindings
     * @return void
     */
    public function assertNestedViewHasAll($view, array $bindings)
    {
		foreach ($bindings as $key => $value)
        {
        	if (is_int($key))
            {
                $this->assertNestedViewHas($view, $value);
            }
            else
            {
                $this->assertNestedViewHas($view, $key, $value);
            }
  	 	}
  	}

  	public function assertNestedView($view)
  	{
    	$this->assertArrayHasKey($view, $this->nestedViewsData);
  	}
	
	public function tearDown()
	{
		m::close();
	}
	
}
