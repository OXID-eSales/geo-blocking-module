<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Dao;

use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Core\Field;
use OxidEsales\GeoBlocking\Application\Service\PickupAddressService;
use OxidEsales\GeoBlocking\Application\Model\CountryToShop;

class PickupAddressServiceTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $address = new Address();
        $address->setId('test_pick_up_address_id');
        $address->save();

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

        $address = new Address();
        $address->load('test_pick_up_address_id');
        $address->delete();

        $countryToShop = new CountryToShop();
        $countryToShop->load('test_model_id');
        $countryToShop->delete();
    }
    
    public function testGetByCountryId()
    {
        $service = new PickupAddressService();
        $address = $service->getByCountryId('test_country_id');

        $this->assertSame('test_pick_up_address_id', $address->getId());
    }
}
