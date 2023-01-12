<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Dao;

use OxidEsales\Eshop\Application\Model\Country;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Application\Service\NotInvoiceOnlyCountryListService;
use OxidEsales\GeoBlocking\Application\Model\CountryToShop;

class NotInvoiceOnlyCountryListServiceTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DatabaseProvider::getDb()->execute("DELETE FROM oxcountry");

        $country1 = new Country();
        $country1->setId('test_country_id');
        $country1->oxcountry__oxactive = new Field(1);
        $country1->save();
        $country2 = new Country();
        $country2->setId('test_country_id2');
        $country2->oxcountry__oxactive = new Field(1);
        $country2->save();

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(Registry::getConfig()->getShopId());
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(0);
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('test_country_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_address_active = new Field(1);
        $countryToShop->save();

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id2');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(Registry::getConfig()->getShopId());
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(1);
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('test_country_id2');
        $countryToShop->oegeoblocking_country_to_shop__pickup_address_active = new Field(1);
        $countryToShop->save();
    }

    public function testGetWithSelectedLanguage()
    {
        $service = new NotInvoiceOnlyCountryListService();

        $countryList = $service->getWithSelectedLanguage(0);
        $this->assertSame(1, count($countryList));
        /** @var Country $country */
        foreach ($countryList as $country) {
            $this->assertSame('test_country_id', $country->getId());
        }
    }
}
