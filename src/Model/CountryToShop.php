<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Model;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Model\BaseModel;

/**
 * @property Field oegeoblocking_country_to_shop__oxid
 * @property Field oegeoblocking_country_to_shop__oxcountryid
 * @property Field oegeoblocking_country_to_shop__oxshopid
 * @property Field oegeoblocking_country_to_shop__invoice_only
 * @property Field oegeoblocking_country_to_shop__pickup_addressid
 * @property Field oegeoblocking_country_to_shop__pickup_address_active
 */
class CountryToShop extends BaseModel
{
    /**
     * @var string
     */
    protected $_sClassName = self::class;

    /**
     * @var string
     */
    protected $_sCoreTable = 'oegeoblocking_country_to_shop';

    /**
     * @var array
     */
    protected $_aFieldNames = [
        'oxid' => 0,
        'oxcountryid'    => 0,
        'oxshopid'    => 0,
        'invoice_only' => 0,
        'pickup_addressid' => 0,
        'pickup_address_active' => 0,
    ];
}
