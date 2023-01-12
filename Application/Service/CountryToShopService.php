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
        $record = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC)->select($selectQuery);

        $isLoaded = false;
        if ($record && $record->count() > 0) {
            $this->countryToShop->assign($record->fields);
            $isLoaded = true;
        }
//        $isLoaded = $this->countryToShop->assignRecord($selectQuery);

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
        $record = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC)->select($selectQuery);
        if ($record && $record->count() > 0) {
            $this->countryToShop->assign($record->fields);
        }
//        $this->countryToShop->assignRecord($selectQuery);

        return $this->countryToShop;
    }
}
