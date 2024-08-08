<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Model;

use OxidEsales\Eshop\Application\Model\Country;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\GeoBlocking\Model\CountryToShop;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(1);
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('country_id');
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(1);
        $countryToShop->save();

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id2');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(1);
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('country_id2');
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(0);
        $countryToShop->save();

        $address = new Country();
        $address->setId('country_id');
        $address->save();

        $address2 = new Country();
        $address2->setId('country_id2');
        $address2->save();
    }

    public function testWhenCountryInvoiceOnly()
    {
        /** @var \OxidEsales\GeoBlocking\Model\Country $country */
        $country = oxNew(Country::class);
        $country->load('country_id');
        $this->assertTrue($country->oeGeoBlockingIsInvoiceOnly());
    }

    public function testWhenCountryIsNotInvoiceOnly()
    {
        /** @var \OxidEsales\GeoBlocking\Model\Country $country */
        $country = oxNew(Country::class);
        $country->load('country_id2');
        $this->assertFalse($country->oeGeoBlockingIsInvoiceOnly());
    }
}
