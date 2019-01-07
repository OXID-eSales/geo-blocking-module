<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Application\Service;

use OxidEsales\EshopCommunity\Core\Registry;
use OxidEsales\GeoBlocking\Application\Model\CountryToShop;

/**
 * Class responsible for providing access to "country to shop".
 */
class CountryToShopService
{
    /**
     * @var CountryToShop
     */
    private $countryToShop;

    /**
     * Initializes necessary objects.
     */
    public function __construct()
    {
        $this->countryToShop = oxNew(CountryToShop::class);
    }

    /**
     * @param string $countryId
     * @return CountryToShop
     */
    public function getByCountryId($countryId)
    {
        $parameters = [
            $this->countryToShop->getViewName() . '.OXCOUNTRYID' => $countryId,
            $this->countryToShop->getViewName() . '.OXSHOPID' => Registry::getConfig()->getShopId(),
        ];
        $selectQuery = $this->countryToShop->buildSelectString($parameters);
        $isLoaded = $this->countryToShop->assignRecord($selectQuery);

        if (!$isLoaded) {
            $this->countryToShop->assign(
                [
                    'oxcountryid' => $countryId,
                    'oxshopid' => Registry::getConfig()->getShopId()
                ]
            );
        }

        return $this->countryToShop;
    }

    /**
     * @param string $addressId
     * @return CountryToShop
     */
    public function getByAddressId($addressId)
    {
        $parameters = [
            $this->countryToShop->getViewName() . '.PICKUP_ADDRESSID' => $addressId,
            $this->countryToShop->getViewName() . '.OXSHOPID' => Registry::getConfig()->getShopId(),
        ];
        $selectQuery = $this->countryToShop->buildSelectString($parameters);
        $this->countryToShop->assignRecord($selectQuery);

        return $this->countryToShop;
    }
}
