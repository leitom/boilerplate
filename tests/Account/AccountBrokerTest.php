<?php

use Mockery as m;
use Leitom\Boilerplate\Account\AccountBroker;

class AccountBrokerTest extends PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function testIfUserIsNotFoundFalseIsReturned()
	{
		$mocks = $this->getMocks();
		$broker = $this->getMock('Leitom\Boilerplate\Account\AccountBroker', array('getUser'), array_values($mocks));
		$broker->expects($this->once())->method('getUser')->will($this->returnValue(null));

		$this->assertFalse($broker->sendActivation(array('credentials')));
	}

	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testGetUserThrowsExceptionIfUserDoesntImplementRemindable()
	{
		$broker = $this->getBroker($mocks = $this->getMocks());
		$mocks['users']->shouldReceive('retrieveByCredentials')->once()->with(array('foo'))->andReturn('bar');

		$broker->getUser(array('foo'));
	}

	public function testUserIsRetrievedByCredentials()
	{
		$broker = $this->getBroker($mocks = $this->getMocks());
		$mocks['users']->shouldReceive('retrieveByCredentials')->once()->with(array('foo'))->andReturn($user = m::mock('Illuminate\Auth\Reminders\RemindableInterface'));

		$this->assertEquals($user, $broker->getUser(array('foo')));
	}

	public function testCreateAndSendActivation()
	{
		$broker = $this->getBroker($mocks = $this->getMocks());

		$mocks['users']->shouldReceive('retrieveByCredentials')->once()->with(array('foo'))->andReturn($user = m::mock('Illuminate\Auth\Reminders\RemindableInterface'));

		$mocks['accountActivation']->shouldReceive('create')->once()->with($user)->andReturn('token');

		$callback = function($m, $user) {};

		$mocks['mailer']->shouldReceive('send')->once()->with('view', array('token' => 'token', 'path' => 'path', 'user' => $user), m::type('Closure'))->andReturnUsing(function($m, $user, $callback)
		{
			return $callback;
		});

		$this->assertTrue($broker->sendActivation(array('foo'), 'path', $callback));
	}

	protected function getBroker($mocks)
	{
		return new AccountBroker($mocks['accountActivation'], $mocks['users'], $mocks['mailer'], $mocks['view']);
	}

	protected function getMocks()
	{
		$mocks = array(
			'accountActivation' => m::mock('Leitom\Boilerplate\Account\AccountActivationRepositoryInterface'),
			'users'     => m::mock('Illuminate\Auth\UserProviderInterface'),
			'mailer'    => m::mock('Illuminate\Mail\Mailer'),
			'view'      => 'leitom.boilerplate::account.emails.activation',
		);

		return $mocks;
	}

}
