<?php

declare(strict_types=1);

namespace CustomGento\Invoice\Test\Integration;

use Magento\Framework\ObjectManagerInterface;
use Magento\OfflinePayments\Model\Purchaseorder;
use Magento\Quote\Model\Quote;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class PurchaseorderTest extends TestCase
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var Purchaseorder
     */
    private $paymentMethod;

    /**
     * @var Quote
     */
    private $quote;

    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->paymentMethod = $this->objectManager->get(Purchaseorder::class);
        $this->quote         = $this->objectManager->create(Quote::class);
        $this->quote->load('test01', 'reserved_order_id');
    }

    /**
     * @magentoDataFixture   Magento/Sales/_files/quote_with_customer.php
     */
    public function testIsNotAvailableByDefault(): void
    {
        $this->assertFalse($this->paymentMethod->isAvailable($this->quote));
    }

    /**
     * @magentoConfigFixture current_store payment/purchaseorder/active 1
     * @magentoDataFixture   Magento/Sales/_files/quote_with_customer.php
     */
    public function testIsAvailableIfConfigured(): void
    {
        $this->assertTrue($this->paymentMethod->isAvailable($this->quote));
    }

    /**
     * @magentoConfigFixture current_store payment/purchaseorder/active 1
     * @magentoConfigFixture current_store payment/purchaseorder/enabled_for_all_customer_groups 0
     * @magentoDataFixture   Magento/Sales/_files/quote_with_customer.php
     */
    public function testIsDisabledIfNotEnabledForAllCustomerGroups(): void
    {
        $this->assertFalse($this->paymentMethod->isAvailable($this->quote));
    }

    /**
     * @magentoConfigFixture current_store payment/purchaseorder/active 1
     * @magentoConfigFixture current_store payment/purchaseorder/enabled_for_all_customer_groups 0
     * @magentoConfigFixture current_store payment/purchaseorder/enabled_customer_groups 1
     * @magentoDataFixture   Magento/Sales/_files/quote_with_customer.php
     */
    public function testIsEnabledIfNotEnabledForAllCustomerGroupsButForCurrent(): void
    {
        $this->assertTrue($this->paymentMethod->isAvailable($this->quote));
    }

    /**
     * @magentoConfigFixture current_store payment/purchaseorder/active 1
     * @magentoConfigFixture current_store payment/purchaseorder/enabled_only_for_admin 1
     * @magentoAppArea       frontend
     * @magentoDataFixture   Magento/Sales/_files/quote_with_customer.php
     */
    public function testIsNotAvailableInFrontendIfEnabledOnlyForAdmin(): void
    {
        $this->assertFalse($this->paymentMethod->isAvailable($this->quote));
    }

    /**
     * @magentoConfigFixture current_store payment/purchaseorder/active 1
     * @magentoConfigFixture current_store payment/purchaseorder/enabled_only_for_admin 1
     * @magentoAppArea       adminhtml
     * @magentoDataFixture   Magento/Sales/_files/quote_with_customer.php
     */
    public function testIsAvailableInAdminIfDisabledInFrontend(): void
    {
        $this->assertTrue($this->paymentMethod->isAvailable($this->quote));
    }
}
