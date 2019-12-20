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

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabledForAllCustomerGroups(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_FOR_ALL_CUSTOMER_GROUPS,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getEnabledCustomerGroups(): array
    {
        $rawEnabledCustomerGroups = $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_CUSTOMER_GROUPS,
            ScopeInterface::SCOPE_STORE
        );

        if (!$rawEnabledCustomerGroups) {
            return [];
        }

        return explode(',', $rawEnabledCustomerGroups);
    }

    public function isEnabledForAdminOnly(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_ONLY_FOR_ADMIN,
            ScopeInterface::SCOPE_STORE
        );
    }
}
