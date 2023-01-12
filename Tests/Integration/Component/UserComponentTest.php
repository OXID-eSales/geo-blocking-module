<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Component;

use OxidEsales\Eshop\Application\Component\UserComponent;
use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Application\Model\CountryToShop;

class UserComponentTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(Registry::getConfig()->getShopId());
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('country_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_addressid = new Field('address_id');
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(1);
        $countryToShop->save();

        $address = new Address();
        $address->setId('address_id');
        $address->save();

        $address2 = new Address();
        $address2->setId('address_id2');
        $address2->save();
    }

    protected function tearDown(): void
    {
        unset($_GET['oxaddressid']);
        parent::tearDown();
    }

    public function testChangeUserWithoutRedirectWhenNotAllowedToChangeAddressData()
    {
        /** @var \OxidEsales\GeoBlocking\Application\Component\UserComponent $userComponent */
        $userComponent = oxNew(UserComponent::class);
        $_GET['oxaddressid'] = 'address_id';

        $addressMock = $this->getMockBuilder(Address::class)
            ->setMethods(['oeGeoBlockingIsUserChangingAddress'])
            ->getMock();
        $addressMock->method('oeGeoBlockingIsUserChangingAddress')->willReturn(true);
        Registry::set(Address::class, $addressMock);

        $this->assertFalse($userComponent->changeUserWithoutRedirect());
        $errors = Registry::getSession()->getVariable('Errors');
        $this->assertSame(1, count($errors));
    }

    public function testChangeUserWithoutRedirectWhenAllowedToChangeAddressData()
    {
        /** @var \OxidEsales\GeoBlocking\Application\Component\UserComponent $userComponent */
        $userComponent = oxNew(UserComponent::class);
        $_GET['oxaddressid'] = 'address_id';

        $addressMock = $this->getMockBuilder(Address::class)
            ->setMethods(['oeGeoBlockingIsUserChangingAddress'])
            ->getMock();
        $addressMock->method('oeGeoBlockingIsUserChangingAddress')->willReturn(false);
        Registry::set(Address::class, $addressMock);

        $this->assertNotFalse($userComponent->changeUserWithoutRedirect());
        $errors = Registry::getSession()->getVariable('Errors');
        $this->assertNull($errors);
    }

    public function testDeleteShippingAddressWhenNotAllowed()
    {
        $_GET['oxaddressid'] = 'address_id';
        /** @var \OxidEsales\GeoBlocking\Application\Component\UserComponent $userComponent */
        $userComponent = oxNew(UserComponent::class);
        $userComponent->deleteShippingAddress();

        $errors = Registry::getSession()->getVariable('Errors');
        $this->assertSame(1, count($errors));
    }

    public function testDeleteShippingAddressWhenAllowed()
    {
        $_GET['oxaddressid'] = 'address_id2';
        $this->createActiveUser();

        /** @var \OxidEsales\GeoBlocking\Application\Component\UserComponent $userComponent */
        $userComponent = oxNew(UserComponent::class);
        $userComponent->deleteShippingAddress();

        $errors = Registry::getSession()->getVariable('Errors');
        $this->assertNull($errors);
    }

    private function createActiveUser()
    {
        $user = new User();
        $user->setId('user_id');
        $user->save();
        Registry::getSession()->setVariable('usr', 'user_id');
    }
}
