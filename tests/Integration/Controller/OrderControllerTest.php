<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Controller;

use OxidEsales\Eshop\Application\Controller\UserController;
use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Application\Model\Country;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Controller\OrderController;
use OxidEsales\GeoBlocking\Model\CountryToShop;
use PHPUnit\Framework\TestCase;

class OrderControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = oxNew(User::class);
        $user->setId('user_id');
        $user->assign([
            'oxusername' => 'test',
            'oxpassword' => md5('test'),
        ]);
        $user->save();
        $user->setUser($user);
        Registry::getSession()->setVariable('usr', 'user_id');

        $address = oxNew(Address::class);
        $address->setId('address_id');
        $address->oxaddress__oxuserid = new Field('user_id');
        $address->oxaddress__oxcountryid = new Field('country_id');
        $address->save();

        $address = oxNew(Country::class);
        $address->setId('country_id');
        $address->oxcountry__oxactive = new Field(1);
        $address->save();

        $countryToShop = oxNew(CountryToShop::class);
        $countryToShop->setId('test_model_id');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(Registry::getConfig()->getShopId());
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('country_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_addressid = new Field('address_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_address_active = new Field(1);
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(1);
        $countryToShop->save();
    }

    protected function tearDown(): void
    {
        oxNew(User::class)->setUser(null);

        parent::tearDown();
    }

    public function testWhenAddressIsBeingChangedViaRequest()
    {
        $_POST['deladrid'] = 'address_id';
        $userController = oxNew(UserController::class);
        $userController->setClassKey('order');
        Registry::getConfig()->setActiveView($userController);

        /** @var OrderController $orderController */
        $orderController = oxNew(OrderController::class);
        $this->assertSame('user', $orderController->execute());
    }
}
