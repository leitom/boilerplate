<?php

class AssetHelperTest extends BoilerplateTestCase {

	public function setUp()
	{
		parent::setUp();

		$this->assetHelper = $this->app['BoilerplateAsset'];
	}

	public function testStyle()
	{
		$return = $this->assetHelper->style('login.css');

		$this->assertEmpty( ! $return);
	}

	public function testScript()
	{
		$return = $this->assetHelper->script('lib/jquery-1.10.2/jquery.min.js');

		$this->assertEmpty( ! $return);
	}

	public function testImage()
	{
		$return = $this->assetHelper->image('login.png');

		$this->assertEmpty( ! $return);
	}

}