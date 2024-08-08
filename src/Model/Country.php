<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Model;

use OxidEsales\GeoBlocking\Service\CountryToShopService;

/**
 * @mixin \OxidEsales\Eshop\Application\Model\Country
 */
class Country extends Country_parent
{
    /**
     * @return bool
     */
    public function oeGeoBlockingIsInvoiceOnly()
    {
        $countryToShopService = oxNew(CountryToShopService::class);
        $invoiceCountryToShop = $countryToShopService->getByCountryId($this->getId());
        return (bool) $invoiceCountryToShop->getFieldData('invoice_only');
    }
}
