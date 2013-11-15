<?php

class SessionsTest extends BoilerplateTestCase {

	public function setUp()
	{
		parent::setUp();

		$this->prefix = Config::get('leitom.boilerplate::prefix');

		$this->defaultAppPage = Config::get('leitom.boilerplate::defaultAppPage');

		if( ! empty($this->prefix)) $this->prefix .= '/';
	}

	public function testCreate()
	{
		$this->call('GET', $this->prefix.'login');

		$this->assertResponseOk();

		$this->assertViewHas('title');
	}

	public function testStore()
	{
		Auth::shouldReceive('attempt')->once()->andReturn(true);

		$this->call('POST', $this->prefix.'sessions', array('username' => 'leirvik.tommy@gmail.com', 'password' => 'testing123'));

		if( ! empty($this->prefix))
			$this->assertRedirectedTo("$this->prefix$this->defaultAppPage");
		else
			$this->assertRedirectedTo('dashboard');
	}

	public function testStoreFails()
	{
		Auth::shouldReceive('attempt')->once()->andReturn(false);
		
		$this->call('POST', $this->prefix.'sessions');

		$this->assertSessionHas('loginError');

		$this->assertRedirectedTo($this->prefix.Config::get('leitom.boilerplate::loginAlias'));
	}

	public function testDestroy()
	{
		Auth::shouldReceive('logout')->once()->andReturn(true);

		$this->call('DELETE', $this->prefix.'sessions/1');

		$this->assertSessionHas('logoutMessage');

		$this->assertRedirectedTo($this->prefix.Config::get('leitom.boilerplate::loginAlias'));
	}

}
