<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Application\Service;

use OxidEsales\Eshop\Application\Model\CountryList;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\TableViewNameGenerator;

/**
 * Class responsible for providing access to country list.
 */
class NotInvoiceOnlyCountryListService
{
    /**
     * @var CountryList
     */
    private $countryList;

    /**
     * Initializes necessary objects.
     */
    public function __construct()
    {
        $this->countryList = oxNew(CountryList::class);
    }

    /**
     * @param int $languageId
     *
     * @return CountryList
     */
    public function getWithSelectedLanguage($languageId)
    {
        $shopId = Registry::getConfig()->getShopId();
        $countryViewName = Registry::get(TableViewNameGenerator::class)->getViewName('oxcountry', $languageId);
        $countryToShopViewName = Registry::get(TableViewNameGenerator::class)->getViewName('oegeoblocking_country_to_shop', $languageId);

        $select = "SELECT c.oxid, c.oxtitle, c.oxisoalpha2 
                        FROM {$countryViewName} c 
                        LEFT JOIN {$countryToShopViewName} gbc2s 
                                on gbc2s.oxcountryid = c.oxid
                                AND gbc2s.oxshopid = {$shopId}  
                        WHERE c.oxactive = '1' 
                        AND (gbc2s.invoice_only = 0 or gbc2s.invoice_only is null)
                        ORDER BY oxorder, oxtitle ";

        $this->countryList->selectString($select);

        return $this->countryList;
    }
}
