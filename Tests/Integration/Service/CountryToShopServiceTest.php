<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Dao;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Core\Field;
use OxidEsales\GeoBlocking\Application\Model\CountryToShop;

class CountryToShopServiceTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(Registry::getConfig()->getShopId());
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(1);
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('test_country_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_addressid = new Field('test_pick_up_address_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_address_active = new Field(1);
        $countryToShop->save();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $countryToShop = new CountryToShop();
        $countryToShop->load('test_model_id');
        $countryToShop->delete();
    }
    
    public function testGetByCountryId()
    {
        $service = new \OxidEsales\GeoBlocking\Application\Service\CountryToShopService();
        $invoiceCountry = $service->getByCountryId('test_country_id');

        $this->assertSame('test_pick_up_address_id', $invoiceCountry->oegeoblocking_country_to_shop__pickup_addressid->value);
    }

    public function testGetByCountryIdWhenNonExistingIdProvided()
    {
        $service = new \OxidEsales\GeoBlocking\Application\Service\CountryToShopService();
        $invoiceCountry = $service->getByCountryId('non_existing');

        $this->assertSame('non_existing', $invoiceCountry->oegeoblocking_country_to_shop__oxcountryid->value);
    }

    public function testGetByAddressId()
    {
        $service = new \OxidEsales\GeoBlocking\Application\Service\CountryToShopService();
        $invoiceCountry = $service->getByAddressId('test_pick_up_address_id');

        $this->assertSame('test_model_id', $invoiceCountry->getId());
    }

    public function testGetByAddressIdWhenNonExistingIdProvided()
    {
        $service = new \OxidEsales\GeoBlocking\Application\Service\CountryToShopService();
        $invoiceCountry = $service->getByAddressId('not_existing');

        $this->assertSame(null, $invoiceCountry->getId());
    }
}
