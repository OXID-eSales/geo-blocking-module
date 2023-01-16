<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Model;

use OxidEsales\Eshop\Application\Model\Country;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Model\UserAddressList;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Model\Address;
use OxidEsales\GeoBlocking\Model\CountryToShop;
use PHPUnit\Framework\TestCase;

class UserAddressListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = new User();
        $user->setId('user_id');
        $user->save();

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(Registry::getConfig()->getShopId());
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('country_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_addressid = new Field('address_id');
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(0);
        $countryToShop->oegeoblocking_country_to_shop__pickup_address_active = new Field(1);
        $countryToShop->save();

        $country = new Country();
        $country->setId('country_id');
        $country->save();

        $address = new Address();
        $address->setId('address_id');
        $address->oxaddress__oxuserid = new Field('any');
        $address->oxaddress__oxcountryid = new Field('country_id');
        $address->save();

        $address2 = new Address();
        $address2->setId('address_id2');
        $address2->oxaddress__oxuserid = new Field('user_id');
        $address2->oxaddress__oxcountryid = new Field('country_id');
        $address2->save();

        $address3 = new Address();
        $address3->setId('address_id3');
        $address3->oxaddress__oxuserid = new Field('any_user');
        $address3->oxaddress__oxcountryid = new Field('country_id');
        $address3->save();
    }

    public function testListLoadingWithExtraPickupAddress()
    {
        Registry::getConfig()->setAdminMode(false);

        /** @var \OxidEsales\GeoBlocking\Model\UserAddressList $userAddressList */
        $userAddressList = oxNew(UserAddressList::class);
        $userAddressList->load('user_id');

        $this->assertSame(2, count($userAddressList));
        $this->assertSame('address_id2', $userAddressList->current()->getId());
        $userAddressList->next();
        $this->assertSame('address_id', $userAddressList->current()->getId());
    }
}
