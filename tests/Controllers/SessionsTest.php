<?php

class SessionsTest extends TestCase {

	protected $loginUrl = '';

	public function setUp()
	{
		parent::setUp();

		$this->loginUrl = 'app/login';
	}

	public function testCreate()
	{
		$this->call('GET', 'app/login');

		$this->assertResponseOk();
	}

	public function testStore()
	{
		Auth::shouldReceive('attempt')->once()->andReturn(true);

		$this->call('POST', Config::get('leitom.boilerplate::prefix').'/sessions', array('username' => 'leirvik.tommy@gmail.com', 'password' => 'testing123'));

		$this->assertRedirectedTo(Config::get('leitom.boilerplate::prefix').'/dashboard');
	}

	public function testStoreFails()
	{
		Auth::shouldReceive('attempt')->once()->andReturn(false);
		$this->call('POST', Config::get('leitom.boilerplate::prefix').'/sessions');

		$this->assertSessionHas('loginError');

		$this->assertRedirectedTo($this->loginUrl);
	}

	public function testDestroy()
	{
		Auth::shouldReceive('logout')->once()->andReturn(true);

		$this->call('DELETE', Config::get('leitom.boilerplate::prefix').'/sessions/1');

		$this->assertSessionHas('logoutMessage');

		$this->assertRedirectedTo($this->loginUrl);
	}

}
