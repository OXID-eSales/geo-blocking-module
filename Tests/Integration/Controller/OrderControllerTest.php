<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Controller;

use OxidEsales\Eshop\Application\Controller\UserController;
use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Application\Model\Country;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Application\Controller\OrderController;
use OxidEsales\GeoBlocking\Application\Model\CountryToShop;

class OrderControllerTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $address = new Address();
        $address->setId('address_id');
        $address->oxaddress__oxuserid = new Field('any');
        $address->oxaddress__oxcountryid = new Field('country_id');
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
