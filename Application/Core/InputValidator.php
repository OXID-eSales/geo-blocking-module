<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Application\Core;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Application\Service\CountryToShopService;

/**
 * @mixin \OxidEsales\Eshop\Core\InputValidator
 */
class InputValidator extends InputValidator_parent
{
    /**
     * Override does not allow to select invoice only shipping address.
     *
     * @param User  $user                      Active user.
     * @param array $invoiceAddressParameters  Billing address info.
     * @param array $deliveryAddressParameters Delivery address info.
     *
     * @see \OxidEsales\Eshop\Core\InputValidator::checkCountries()
     */
    public function checkCountries($user, $invoiceAddressParameters, $deliveryAddressParameters)
    {
        parent::checkCountries($user, $invoiceAddressParameters, $deliveryAddressParameters);

        if (Registry::getConfig()->getActiveView()->getClassKey() === 'user'
            || Registry::getConfig()->getActiveView()->getClassKey() === 'account_user'
            || Registry::getConfig()->getActiveView()->getClassKey() === 'order'
        ) {
            $billingCountryId = isset($invoiceAddressParameters['oxuser__oxcountryid']) ? $invoiceAddressParameters['oxuser__oxcountryid'] : null;
            $deliveryCountryId = isset($deliveryAddressParameters['oxaddress__oxcountryid']) ? $deliveryAddressParameters['oxaddress__oxcountryid'] : null;

            if ($billingCountryId || $deliveryCountryId) {
                $deliveryCountryId = $deliveryCountryId ? $deliveryCountryId : $billingCountryId;
                $countryToShopService = oxNew(CountryToShopService::class);
                $countryToShop = $countryToShopService->getByCountryId($deliveryCountryId);

                if ($countryToShop->getId() && $countryToShop->oegeoblocking_country_to_shop__invoice_only->value === '1') {
                    $exception = oxNew(
                        UserException::class,
                        Registry::getLang()->translateString('OEGEOBLOCKING_ERROR_MESSAGE_INPUT_COUNTRY_NOT_ALLOWED')
                    );
                    $this->addValidationError('', $exception);
                }
            }
        }
    }
}
