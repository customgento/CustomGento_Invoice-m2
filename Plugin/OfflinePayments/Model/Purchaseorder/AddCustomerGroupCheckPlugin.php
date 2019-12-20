<?php

declare(strict_types=1);

namespace CustomGento\Invoice\Plugin\OfflinePayments\Model\Purchaseorder;

use CustomGento\Invoice\Model\Config;
use Magento\OfflinePayments\Model\Purchaseorder;
use Magento\Quote\Api\Data\CartInterface;

class AddCustomerGroupCheckPlugin
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function afterIsAvailable(Purchaseorder $subject, bool $result, CartInterface $quote = null): bool
    {
        // if some other rule forbids this payment method, we forbid it as well
        if (!$result) {
            return $result;
        }

        if ($this->config->isEnabledForAllCustomerGroups()) {
            return true;
        }

        $customerGroup = null;
        if ($quote instanceof CartInterface) {
            $customerGroup = $quote->getCustomer()->getGroupId();
        }

        return in_array($customerGroup, $this->config->getEnabledCustomerGroups(), false);
    }
}
