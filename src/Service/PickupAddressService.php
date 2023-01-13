<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Service;

use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

/**
 * Class responsible for preparing Address model object.
 */
class PickupAddressService
{
    /**
     * @var Address
     */
    private $address;

    /**
     * Initializes necessary objects.
     */
    public function __construct()
    {
        $this->address = oxNew(Address::class);
    }

    /**
     * @param string $countryId
     * @return Address
     */
    public function getByCountryId($countryId)
    {
        $shopId = Registry::getConfig()->getShopid();
        $selectQuery = "select pickup_addressid from oegeoblocking_country_to_shop
                      where oegeoblocking_country_to_shop.oxcountryid = '{$countryId}'
                      and oegeoblocking_country_to_shop.oxshopid = '{$shopId}'";

        $oxId = DatabaseProvider::getDb()->getOne($selectQuery);
        $this->address->load($oxId);

        return $this->address;
    }

    /**
     * @param string $addressId
     * @return Address
     */
    public function getByAddressId($addressId)
    {
        $shopId = Registry::getConfig()->getShopid();
        $selectQuery = "select pickup_addressid from oegeoblocking_country_to_shop
                      where oegeoblocking_country_to_shop.pickup_addressid = '{$addressId}'
                      and oegeoblocking_country_to_shop.oxshopid = '{$shopId}'";

        $oxId = DatabaseProvider::getDb()->getOne($selectQuery);
        $this->address->load($oxId);

        return $this->address;
    }
}
