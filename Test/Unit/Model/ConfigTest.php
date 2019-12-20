<?php

declare(strict_types=1);

namespace CustomGento\Invoice\Test\Unit\Model;

use CustomGento\Invoice\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @var ScopeConfigInterface|MockObject
     */
    private $scopeConfig;

    /**
     * @var Config
     */
    private $config;

    protected function setUp()
    {
        $this->scopeConfig = $this->createMock(ScopeConfigInterface::class);
        $this->config      = new Config($this->scopeConfig);
    }

    public function testIsEnabledForAllCustomerGroupsReturnsTrue(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(Config::XML_PATH_ENABLED_FOR_ALL_CUSTOMER_GROUPS)
            ->willReturn(true);
        $this->assertTrue($this->config->isEnabledForAllCustomerGroups());
    }

    public function testIsEnabledForAllCustomerGroupsReturnsFalse(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(Config::XML_PATH_ENABLED_FOR_ALL_CUSTOMER_GROUPS)
            ->willReturn(false);
        $this->assertFalse($this->config->isEnabledForAllCustomerGroups());
    }

    public function testGetEnabledCustomerGroupsReturnsEmptyArrayForNull(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(Config::XML_PATH_ENABLED_CUSTOMER_GROUPS)
            ->willReturn(null);
        $this->assertEquals([], $this->config->getEnabledCustomerGroups());
    }

    public function testGetEnabledCustomerGroupsReturnsEmptyArrayForEmptyString(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(Config::XML_PATH_ENABLED_CUSTOMER_GROUPS)
            ->willReturn('');
        $this->assertEquals([], $this->config->getEnabledCustomerGroups());
    }

    public function testGetEnabledCustomerGroupsReturnsCustomerGroupId(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(Config::XML_PATH_ENABLED_CUSTOMER_GROUPS)
            ->willReturn('1');
        $this->assertEquals([1], $this->config->getEnabledCustomerGroups());
    }

    public function testGetEnabledCustomerGroupsReturnsCustomerGroupIds(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(Config::XML_PATH_ENABLED_CUSTOMER_GROUPS)
            ->willReturn('1,2,3');
        $this->assertEquals([1, 2, 3], $this->config->getEnabledCustomerGroups());
    }

    public function testIsEnabledForAdminOnlyReturnsTrue(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(Config::XML_PATH_ENABLED_ONLY_FOR_ADMIN)
            ->willReturn(true);
        $this->assertTrue($this->config->isEnabledForAdminOnly());
    }

    public function testIsEnabledForAdminOnlyReturnsFalse(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(Config::XML_PATH_ENABLED_ONLY_FOR_ADMIN)
            ->willReturn(false);
        $this->assertFalse($this->config->isEnabledForAdminOnly());
    }
}
