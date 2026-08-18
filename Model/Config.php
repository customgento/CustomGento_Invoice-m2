<?php

declare(strict_types=1);

namespace CustomGento\Invoice\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public const XML_PATH_ENABLED_FOR_ALL_CUSTOMER_GROUPS = 'payment/purchaseorder/enabled_for_all_customer_groups';
    public const XML_PATH_ENABLED_CUSTOMER_GROUPS = 'payment/purchaseorder/enabled_customer_groups';
    public const XML_PATH_ENABLED_ONLY_FOR_ADMIN = 'payment/purchaseorder/enabled_only_for_admin';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check whether the payment method is enabled for all customer groups.
     *
     * @return bool
     */
    public function isEnabledForAllCustomerGroups(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_FOR_ALL_CUSTOMER_GROUPS,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get the IDs of the customer groups the payment method is enabled for.
     *
     * @return string[]
     */
    public function getEnabledCustomerGroups(): array
    {
        $rawEnabledCustomerGroups = $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_CUSTOMER_GROUPS,
            ScopeInterface::SCOPE_STORE
        );

        if (!$rawEnabledCustomerGroups || !is_string($rawEnabledCustomerGroups)) {
            return [];
        }

        return explode(',', $rawEnabledCustomerGroups);
    }

    /**
     * Check whether the payment method is restricted to the admin area.
     *
     * @return bool
     */
    public function isEnabledForAdminOnly(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_ONLY_FOR_ADMIN,
            ScopeInterface::SCOPE_STORE
        );
    }
}
