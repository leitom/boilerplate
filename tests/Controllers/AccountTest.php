<?php

use Mockery as m;
use Way\Tests\Factory;

class AccountTest extends BoilerplateTestCase {

	public function setUp()
	{
		parent::setUp();

		Mail::pretend();

		$this->prefix = Config::get('leitom.boilerplate::prefix');
	}

	public function tearDown()
	{
		m::close();
	}

	public function testCreate()
	{
		$this->call('GET', "$this->prefix/account/create");

		$this->assertResponseOk();
	}
/*
	public function testStore()
	{
		$user = $this->mock('Leitom\Boilerplate\User');
		$user->email = 'boilerplate@boilerplate.com';		
		$user->userProfile = $this->mock('Leitom\Boilerplate\UserProfile');
		$user->userProfile->firstname = 'test';
		$user->userProfile->lastname = 'test';

		$user->shouldReceive('hasValidatorErrors')->once()->andReturn(false);

		$user->shouldReceive('setAttribute')->withAnyArgs()->times(4)->andReturn('foo');

		$user->shouldReceive('getAttribute')->withAnyArgs()->times(4)->andReturn('foo');
		

		$response = m::mock('StdClass');
		$response->email = 'boilerplate@boilerplate.com';
		$response->userProfile->firstname = 'test';
		$response->userProfile->lastname = 'test';
		$response->shouldReceive('hasValidatorErrors')->once()->andReturn(false);
		
		$mock = $this->mock('Leitom\Boilerplate\Repositories\UsersRepositoryInterface');

		$mock->shouldReceive('create')->withAnyArgs()->andReturn($user);

		Account::shouldReceive('sendActivation')->withAnyArgs()->once()->andReturn('foo');

		$this->call('POST', "$this->prefix/account");

		
		$response = m::mock('StdClass');
		$response->shouldReceive('passes')->once()->andReturn(false);
		$response->shouldReceive('messages')->once()->andReturn(array('messages' => array()));
		
        $validation = m::mock('Illuminate\Validation\Validator');
        $validation->shouldReceive('make')
        		   ->once()
                   ->andReturn($response);
	}*/

}