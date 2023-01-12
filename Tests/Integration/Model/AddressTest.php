<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Model;

use OxidEsales\Eshop\Core\Field;
use OxidEsales\GeoBlocking\Application\Model\Address;
use OxidEsales\GeoBlocking\Application\Model\CountryToShop;

class AddressTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(1);
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('test_country_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_addressid = new Field('address_id');
        $countryToShop->save();

        $address = new Address();
        $address->setId('address_id');
        $address->oxaddress__oxlname = new Field('user name');
        $address->save();

        $address2 = new Address();
        $address2->setId('address_id2');
        $address2->save();
    }

    public function testWhenUserCantChangeAddress()
    {
        /** @var Address $address */
        $address = oxNew(\OxidEsales\Eshop\Application\Model\Address::class);
        $address->load('address_id');
        $this->assertFalse($address->oeGeoBlockingCanFrontendUserChange());
    }

    public function testWhenUserCanChangeAddress()
    {
        /** @var Address $address */
        $address = oxNew(\OxidEsales\Eshop\Application\Model\Address::class);
        $address->load('address_id2');
        $this->assertTrue($address->oeGeoBlockingCanFrontendUserChange());
    }

    public function testIsUserChangingAddressWhenAddressBeingChanged()
    {
        /** @var Address $address */
        $address = oxNew(\OxidEsales\Eshop\Application\Model\Address::class);
        $address->load('address_id');
        $data = [
            'oxaddress__oxlname' => 'name to change'
        ];
        $this->assertTrue($address->oeGeoBlockingIsUserChangingAddress($data));
    }

    public function testIsUserChangingAddressWhenNotBeingChanged()
    {
        /** @var Address $address */
        $address = oxNew(\OxidEsales\Eshop\Application\Model\Address::class);
        $address->load('address_id');
        $data = [
            'oxaddress__oxlname' => 'user name'
        ];
        $this->assertFalse($address->oeGeoBlockingIsUserChangingAddress($data));
    }
}
