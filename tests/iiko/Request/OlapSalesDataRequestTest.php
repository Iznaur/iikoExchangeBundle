<?php

namespace App\Tests\iiko\Request;

use App\Tests\ReflectionHelper;
use iikoExchangeBundle\Library\base\Config\ConfigManager;
use iikoExchangeBundle\Library\iiko\Request\AbstractOlapSalesDataRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class OlapSalesDataRequestTest extends TestCase
{
	/** @var AbstractOlapSalesDataRequest */
	protected $instance;

	protected function setUp(): void
	{
		parent::setUp(); // TODO: Change the autogenerated stub

		$configManager = $this->createMock(ConfigManager::class);
		$eventDispatcher = $this->createMock(EventDispatcher::class);

		$this->instance = (new AbstractOlapSalesDataRequest())->setConfigManager($configManager)->withDomain('PHPUNIT');

	}

	public function testGetRequest()
	{

	}

	public function testWithDomain()
	{
		$this->instance->setAccount(2);
		$this->assertEquals(2, ReflectionHelper::getProtectedProperty($this->instance, 'account'));
		$this->assertEquals("PHPUNIT", ReflectionHelper::getProtectedProperty($this->instance, 'configDomain'));

		$new = $this->instance->withDomain("TEST_UNIT");
		$this->assertEquals("TEST_UNIT", ReflectionHelper::getProtectedProperty($new, 'configDomain'));
		$this->assertNull(ReflectionHelper::getProtectedProperty($new, 'account'));

	}

	public function testSetAccount()
	{

	}

	public function testSetConfigManager()
	{

	}

	public function testRegisterConfigStack()
	{

	}
}
