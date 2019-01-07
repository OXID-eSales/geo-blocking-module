<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Application\Controller;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Application\Core\InputValidator;

/**
 * @mixin \OxidEsales\Eshop\Application\Controller\OrderController
 */
class OrderController extends OrderController_parent
{
    /**
     * @see \OxidEsales\Eshop\Application\Controller\OrderController::execute()
     *
     * @return string
     */
    public function execute()
    {
        $user = $this->getUser();
        $billingAddressParameters['oxuser__oxcountryid'] = $user->oxuser__oxcountryid->value;
        $shippingAddress = $this->getDelAddress();
        if (is_object($shippingAddress)) {
            $shippingAddressParameters['oxaddress__oxcountryid'] = $shippingAddress->oxaddress__oxcountryid->value;
        } else {
            $shippingAddressParameters['oxaddress__oxcountryid'] = $user->oxuser__oxcountryid->value;
        }

        /** @var InputValidator $inputValidator */
        $inputValidator = Registry::getInputValidator();
        $inputValidator->checkCountries($user, $billingAddressParameters, $shippingAddressParameters);
        if ($error = Registry::getInputValidator()->getFirstValidationError()) {
            Registry::getUtilsView()->addErrorToDisplay($error);
            return 'user';
        }

        return parent::execute();
    }
}
