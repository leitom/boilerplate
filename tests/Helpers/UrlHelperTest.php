<?php

class UrlHelperTest extends BoilerplateTestCase {
	
	public function setUp()
	{
		parent::setUp();

		$this->prefix = Config::get('leitom.boilerplate::prefix');

		$this->urlHelper = $this->app['BoilerplateURL'];
	}

	public function testRoute()
	{
		$return = $this->urlHelper->route('sessions.store');

		if( ! empty($this->prefix))
			$this->assertEquals("$this->prefix.sessions.store", $return);
		else
			$this->assertEquals("sessions.store", $return);
	}

	public function testTo()
	{
		$return = $this->urlHelper->to('new-account');

		if( ! empty($this->prefix))
			$this->assertEquals(Config::Get('app.url').'/app/new-account', $return);
		else
			$this->assertEquals(Config::Get('app.url').'/new-account', $return);
	}

	public function testRouteTo()
	{
		$return = $this->urlHelper->routeTo('sessions.create');

		if( ! empty($this->prefix))
			$this->assertEquals(Config::get('app.url').'/app/sessions/create', $return);
		else
			$this->assertEquals(Config::get('app.url').'/sessions/create', $return);
	}

}