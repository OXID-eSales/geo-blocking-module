<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Model;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\TableViewNameGenerator;

/**
 * @mixin \OxidEsales\Eshop\Application\Model\UserAddressList
 */
class UserAddressList extends UserAddressList_parent
{
    /**
     * @param string $userId user id
     * @return void
     *
     * @see \OxidEsales\Eshop\Application\Model\UserAddressList::load()
     */
    public function load($userId)
    {
        if (Registry::getConfig()->isAdmin()) {
            parent::load($userId);
        } else {
            $this->loadAddressesForFrontendOnly($userId);
        }
    }

    /**
     * Loads user addresses together with predefined addresses by administrator.
     *
     * @param string $userId
     * @return void
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    private function loadAddressesForFrontendOnly($userId)
    {
        $shopId = Registry::getConfig()->getShopId();
        $viewName = Registry::get(TableViewNameGenerator::class)->getViewName('oxcountry');
        $baseObject = $this->getBaseObject();
        $selectFields = $baseObject->getSelectFields();

        $query = "
            SELECT {$selectFields}, `oxcountry`.`oxtitle` AS oxcountry, 
            if(isnull(gbc2s.oxid), 0, 1) AS is_pickup, gbc2s.oxcountryid AS pickup_countryid 
            FROM oxaddress
            LEFT JOIN {$viewName} AS oxcountry 
                ON oxaddress.oxcountryid = oxcountry.oxid
            
            -- get only already saved deliveryaddresses with allowed deliverycountrys and remove all others
            LEFT JOIN oegeoblocking_country_to_shop gbInvOnly 
                ON gbInvOnly.oxshopid = " . $shopId . " 
                AND gbInvOnly.oxcountryid = oxaddress.oxcountryid    
            LEFT JOIN oegeoblocking_country_to_shop gbc2s 
                ON gbc2s.oxshopid = " . $shopId . " 
                AND gbc2s.pickup_addressid = oxaddress.oxid 
                AND gbc2s.pickup_address_active = 1 
            WHERE (
                (
                    oxaddress.oxuserid = " . DatabaseProvider::getDb()->quote($userId) . " 
                    AND (gbInvOnly.oxid IS NULL OR gbInvOnly.invoice_only = 0)
                )  -- get user addresses that are not invoice only
                OR gbc2s.oxid IS NOT NULL
            )  -- additionally all pickup addresses
            ORDER BY is_pickup asc";

        $this->selectString($query);
    }
}
