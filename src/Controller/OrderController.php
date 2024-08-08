<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Controller;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Core\InputValidator;

/**
 * @mixin \OxidEsales\Eshop\Application\Controller\OrderController
 */
class OrderController extends OrderController_parent
{
    /**
     * @see \OxidEsales\Eshop\Application\Controller\OrderController::execute()
     *
     * @return string|null
     */
    public function execute()
    {
        $user = $this->getUser();
        $billingAddrParams['oxuser__oxcountryid'] = $user->getFieldData('oxcountryid');
        $shippingAddress = $this->getDelAddress();
        if (is_object($shippingAddress)) {
            $shippingAddrParams['oxaddress__oxcountryid'] = $shippingAddress->getFieldData('oxcountryid');
        } else {
            $shippingAddrParams['oxaddress__oxcountryid'] = $user->getFieldData('oxcountryid');
        }

        /** @var InputValidator $inputValidator */
        $inputValidator = Registry::getInputValidator();
        $inputValidator->checkCountries($user, $billingAddrParams, $shippingAddrParams);
        if ($error = Registry::getInputValidator()->getFirstValidationError()) {
            Registry::getUtilsView()->addErrorToDisplay($error);
            return 'user';
        }

        return parent::execute();
    }
}
