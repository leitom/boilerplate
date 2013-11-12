<?php

class UrlHelperTest extends TestCase {
	
	public function setUp()
	{
		parent::setUp();

		$this->urlHelper = $this->app['BoilerplateURL'];
	}

	public function testRoute()
	{
		$return = $this->urlHelper->route('sessions.store');
		$this->assertEquals('app.sessions.store', $return);
	}

}