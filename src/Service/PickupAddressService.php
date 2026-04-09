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
        $db = DatabaseProvider::getDb();
        $selectQuery = "SELECT pickup_addressid FROM oegeoblocking_country_to_shop
                      WHERE oxcountryid = ? AND oxshopid = ?";

        $oxId = $db->getOne($selectQuery, [$countryId, $shopId]);
        if ($oxId) {
            $this->address->load($oxId);
        }

        return $this->address;
    }

    /**
     * @param string $addressId
     * @return Address
     */
    public function getByAddressId($addressId)
    {
        $shopId = Registry::getConfig()->getShopid();
        $db = DatabaseProvider::getDb();
        $selectQuery = "SELECT pickup_addressid FROM oegeoblocking_country_to_shop
                      WHERE pickup_addressid = ? AND oxshopid = ?";

        $oxId = $db->getOne($selectQuery, [$addressId, $shopId]);
        if ($oxId) {
            $this->address->load($oxId);
        }

        return $this->address;
    }
}
