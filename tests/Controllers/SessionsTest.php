<?php

class SessionsTest extends TestCase {

	public function setUp()
	{
		parent::setUp();
	}

	public function testCreate()
	{
		$this->call('GET', 'app/login');

		$this->assertResponseOk();
	}

	public function testStore()
	{
		Auth::shouldReceive('attempt')->once()->andReturn(true);

		$this->call('POST', 'app/sessions', array('username' => 'leirvik.tommy@gmail.com', 'password' => 'leitom123'));

		$this->assertRedirectedTo('app/dashboard');
	}

	public function testStoreFails()
	{
		Auth::shouldReceive('attempt')->once()->andReturn(false);
		$this->call('POST', 'app/sessions');

		$this->assertSessionHas('loginError');

		$this->assertRedirectedTo('app/login');
	}

	public function testDestroy()
	{
		Auth::shouldReceive('logout')->once()->andReturn(true);

		$this->call('DELETE', 'app/sessions/1');

		$this->assertSessionHas('logoutMessage');

		$this->assertRedirectedTo('app/login');
	}

}
