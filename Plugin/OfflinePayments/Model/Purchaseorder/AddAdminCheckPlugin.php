<?php

declare(strict_types=1);

namespace CustomGento\Invoice\Plugin\OfflinePayments\Model\Purchaseorder;

use CustomGento\Invoice\Model\Config;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\OfflinePayments\Model\Purchaseorder;

class AddAdminCheckPlugin
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var State
     */
    private $state;

    public function __construct(Config $config, State $state)
    {
        $this->config = $config;
        $this->state  = $state;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterIsAvailable(Purchaseorder $subject, bool $result): bool
    {
        // if some other rule forbids this payment method, we forbid it as well
        if (!$result) {
            return $result;
        }

        if (!$this->config->isEnabledForAdminOnly()) {
            return true;
        }

        $currentArea = $this->state->getAreaCode();

        return $currentArea === Area::AREA_ADMINHTML;
    }
}
