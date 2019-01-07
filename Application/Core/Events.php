<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Application\Core;

use OxidEsales\Eshop\Core\DatabaseProvider;

/**
 * Module events class.
 */
class Events
{
    /**
     * Execute action on activate event.
     */
    public static function onActivate()
    {
        $query = "CREATE TABLE IF NOT EXISTS `oegeoblocking_country_to_shop` (
                  `OXID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Record id',
                  `OXCOUNTRYID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Country id',
                  `OXSHOPID` int(11) NOT NULL DEFAULT '1' COMMENT 'Shop id (oxshops)',
                  `PICKUP_ADDRESSID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'oxaddress id',
                  `PICKUP_ADDRESS_ACTIVE` tinyint NOT NULL DEFAULT 0,
                  `INVOICE_ONLY` tinyint NOT NULL DEFAULT 0,
                  `OXTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
                  PRIMARY KEY (`OXID`),
                  UNIQUE KEY `OXCOUNTRYID` (`OXCOUNTRYID`,`OXSHOPID`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Shows many-to-many relationship between fields and shops (multishops fields)';";

        DatabaseProvider::getDb()->execute($query);
    }
}
