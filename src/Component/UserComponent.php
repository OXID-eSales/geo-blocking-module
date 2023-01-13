<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Component;

use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Service\CountryToShopService;

/**
 * @mixin \OxidEsales\Eshop\Application\Component\UserComponent
 */
class UserComponent extends UserComponent_parent
{
    /**
     * Override does not allow to change predefined shipping address.
     *
     * @see \OxidEsales\Eshop\Application\Component\UserComponent::changeUserWithoutRedirect()
     *
     * @return bool
     */
    public function changeUserWithoutRedirect()
    {
        $deliveryAddressInfo = Registry::getRequest()->getRequestEscapedParameter('deladr', []);
        $countryToShop = $this->oeGeoBlockingCreateCountryToShopByAddressId(
            Registry::getRequest()->getRequestEscapedParameter('oxaddressid', '')
        );
        /** @var \OxidEsales\GeoBlocking\Model\Address $address */
        $address = Registry::get(Address::class);
        if ($address->load((string)$countryToShop->oegeoblocking_country_to_shop__pickup_addressid->value)) {
            if ($address->oeGeoBlockingIsUserChangingAddress($deliveryAddressInfo)) {
                Registry::getUtilsView()->addErrorToDisplay(
                    'OEGEOBLOCKING_PICKUP_ADDRESS_CHANGE_NOT_ALLOWED',
                    false,
                    true
                );
                return false;
            }
        }

        return parent::changeUserWithoutRedirect();
    }

    /**
     * Override does not allow to delete predefined shipping address.
     *
     * @see \OxidEsales\Eshop\Application\Component\UserComponent::deleteShippingAddress()
     */
    public function deleteShippingAddress()
    {
        $countryToShop = $this->oeGeoBlockingCreateCountryToShopByAddressId(Registry::getRequest()->getRequestEscapedParameter('oxaddressid', ''));
        if ($countryToShop->getId()) {
            Registry::getUtilsView()->addErrorToDisplay('OEGEOBLOCKING_PICKUP_ADDRESS_CHANGE_NOT_ALLOWED', false, true);
        } else {
            parent::deleteShippingAddress();
        }
    }

    /**
     * Factory method for object creation.
     *
     * @param string $addressId
     *
     * @return \OxidEsales\GeoBlocking\Model\CountryToShop
     */
    private function oeGeoBlockingCreateCountryToShopByAddressId($addressId)
    {
        $countryToShopService = oxNew(CountryToShopService::class);
        $countryToShop = $countryToShopService->getByAddressId($addressId);
        return $countryToShop;
    }
}
