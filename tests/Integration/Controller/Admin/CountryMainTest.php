<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Controller\Admin;


use OxidEsales\Eshop\Application\Controller\Admin\CountryMain;
use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Application\Model\Country;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Model\CountryToShop;
use PHPUnit\Framework\TestCase;

class CountryMainTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $address = new Address();
        $address->setId('address_id');
        $address->oxaddress__oxuserid = new Field('any');
        $address->oxaddress__oxcountryid = new Field('country_id');
        $address->oxaddress__oxfname = new Field('name');
        $address->save();

        $address = new Country();
        $address->setId('country_id');
        $address->oxcountry__oxactive = new Field(1);
        $address->save();

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(Registry::getConfig()->getShopId());
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('country_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_addressid = new Field('address_id');
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(1);
        $countryToShop->save();
    }

    public function testSaveWhenEditsExistingAddress()
    {
        $_POST['editval_gb'] = [
            'oxaddress_oxid' => 'address_id',
            'oxaddress__oxfname' => 'updated name',
        ];

        /** @var \OxidEsales\GeoBlocking\Controller\Admin\CountryMain $controller */
        $controller = oxNew(CountryMain::class);
        $controller->save();

        $address = new Address();
        $address->load('address_id');

        $this->assertSame('updated name', $address->oxaddress__oxfname->value);
    }

    public function testSaveWhenEditsExistingCountryToShopData()
    {
        $_POST['editval_gb'] = [
            'oxaddress_oxid' => 'address_id',
            'oxaddress__oxfname' => 'updated name',
            'country_to_shop__invoice_only' => 0,
        ];

        /** @var \OxidEsales\GeoBlocking\Controller\Admin\CountryMain $controller */
        $controller = oxNew(CountryMain::class);
        $controller->save();

        $countryToShop = new CountryToShop();
        $countryToShop->load('test_model_id');

        $this->assertSame('0', $countryToShop->oegeoblocking_country_to_shop__pickup_address_active->value);
    }
}
