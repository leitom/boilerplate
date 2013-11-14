<?php

use Mockery as m;
use Way\Tests\Factory;
use Config;

class AccountTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

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

}