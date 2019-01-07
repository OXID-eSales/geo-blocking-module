<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Application\Model;

use OxidEsales\GeoBlocking\Application\Service\CountryToShopService;

/**
 * @mixin \OxidEsales\Eshop\Application\Model\Address
 */
class Address extends Address_parent
{
    /**
     * @return bool
     */
    public function oeGeoBlockingCanFrontendUserChange()
    {
        $countryToShopService = oxNew(CountryToShopService::class);
        $countryToShop = $countryToShopService->getByAddressId($this->getId());
        if ($countryToShop->getId()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param array $addressInfo
     * @return bool
     */
    public function oeGeoBlockingIsUserChangingAddress($addressInfo)
    {
        $tableName = $this->getCoreTableName();
        foreach ($this->getFieldNames() as $fieldName) {
            $fieldNameWithTable = $tableName . '__' . $fieldName;
            if (isset($addressInfo[$fieldNameWithTable]) && $addressInfo[$fieldNameWithTable] !== $this->{$fieldNameWithTable}->value) {
                return true;
            }
        }

        return false;
    }
}
