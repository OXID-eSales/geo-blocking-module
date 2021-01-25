<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Codeception;

use Codeception\TestInterface;
use Codeception\Util\Fixtures;
use OxidEsales\Codeception\Module\Translation\Translator;
use OxidEsales\Codeception\Page\Checkout\UserCheckout;
use OxidEsales\Codeception\Step\Basket;

class FrontendCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->deleteFromDatabase('oxarticles', ['OXID' => '1000']);
        $I->deleteFromDatabase('oxuser', ['OXID' => 'oegeoblockingtestuser']);
        $I->deleteFromDatabase('oxuser', ['OXUSERNAME' => 'test_registration@oxid-esales.local']);
        $I->deleteFromDatabase('oxaddress', ['OXID' => 'pickup_address_id']);
        $I->deleteFromDatabase('oxaddress', ['OXID' => 'user_defined_pickup_address_id']);
        $I->haveInDatabase('oegeoblocking_country_to_shop', Fixtures::get('countryToShopData'));
        $I->updateConfigInDatabase('stickyHeader', false, 'bool');
    }

    public function registerUserWithCountryWhichIsInvoiceOnly(AcceptanceTester $I)
    {
        $I->wantToTest('user registration with "invoice only" country.');

        $startPage = $I->openShop();
        $registrationPage = $startPage->openUserRegistrationPage();

        $registrationPage->enterUserLoginData(Fixtures::get('userLoginData'));
        $I->executeJS('window.scrollTo(0,0);');
        $registrationPage->enterUserData(Fixtures::get('userData'));
        $I->executeJS('window.scrollTo(0,0);');
        $registrationPage->enterAddressData(Fixtures::get('userAddressData'));
        $I->dontSeeInPageSource(Translator::translate('OEGEOBLOCKING_HINT'));
        $I->executeJS('window.scrollTo(0,0);');
        $registrationPage->registerUser();
        $I->see(Translator::translate('MESSAGE_WELCOME_REGISTERED_USER'));
    }

    public function checksIfNotPossibleToUseBillingAddressForShippingInCheckout(AcceptanceTester $I)
    {
        $I->wantToTest('checkout step 2 when not possible to use billing address');
        $basket = new Basket($I);

        $this->addTestProductToDatabase($I);
        $I->haveInDatabase('oxuser', Fixtures::get('user'));

        $startPage = $I->openShop();
        $startPage->loginUser('testing_account@oxid-esales.local', 'useruser');

        /** @var UserCheckout $paymentCheckout */
        $userCheckout = $basket->addProductToBasketAndOpenUserCheckout(1000, 1);
        $I->click('#basketModal button');
        $I->wait(1);

        $userCheckout->openUserBillingAddressForm();
        $I->wait(1);
        $userCheckout->enterUserData(Fixtures::get('userData'));
        $userCheckout->enterAddressData(Fixtures::get('userAddressData'));
        $I->see(Translator::translate('OEGEOBLOCKING_HINT'));

        $I->click($userCheckout->delCountryId);
        $I->see('Austria', $userCheckout->shipAddressForm);
        $I->dontSee('United Kingdom', $userCheckout->shipAddressForm);

        $I->dontSeeCheckboxIsChecked($userCheckout->openShipAddressForm);
        $userCheckout->goToNextStep();
        $I->see(Translator::translate('DD_FORM_VALIDATION_REQUIRED'));
    }

    public function checkIfNotPossibleToEditPickupAddressInCheckout(AcceptanceTester $I)
    {
        $I->wantToTest('checkout step 2 when not possible to edit or delete pickup address in checkout');
        $basket = new Basket($I);

        $this->addTestProductToDatabase($I);
        $I->haveInDatabase('oxuser', Fixtures::get('user'));
        $this->addAddressData($I);

        $startPage = $I->openShop();
        $startPage->loginUser('testing_account@oxid-esales.local', 'useruser');
        /** @var UserCheckout $paymentCheckout */
        $userCheckout = $basket->addProductToBasketAndOpenUserCheckout(1000, 1);
        $I->click('#basketModal button');

        $I->see(Translator::translate('OEGEOBLOCKING_HINT'));

        $I->dontSeeCheckboxIsChecked($userCheckout->openShipAddressForm);
        $I->seeElement(sprintf($userCheckout->openShipAddress, 1));
        $I->dontSeeElement(sprintf($userCheckout->openShipAddress, 2));
        $I->dontSeeElement(sprintf($userCheckout->deleteShipAddress, 2));
        $I->seeElement(sprintf($userCheckout->selectShipAddress, 2));
    }

    public function checksIfNotPossibleToUseBillingAddressForShippingInUserAccount(AcceptanceTester $I)
    {
        $I->wantToTest('user account when not possible to use billing address');
        $I->haveInDatabase('oxuser', Fixtures::get('user'));
        $this->addAddressData($I);

        $startPage = $I->openShop();
        $startPage->loginUser('testing_account@oxid-esales.local', 'useruser');
        $userAccount = $startPage->openAccountPage();
        $userAddress = $userAccount->openUserAddressPage();

        $I->dontSeeCheckboxIsChecked($userAddress->openShipAddressPanel);
        $I->seeElement(sprintf($userAddress->openShipAddressForm, 1));
        $I->dontSeeElement(sprintf($userAddress->openShipAddressForm, 2));
        $I->dontSeeElement(sprintf($userAddress->deleteShipAddress, 2));
        $I->seeElement(sprintf($userAddress->selectShipAddress, 2));

        $userAddress->selectShippingAddress(1);

        $I->waitForElement($userAddress->delCountryId);
        $I->click($userAddress->delCountryId);
        $I->see('Austria', $userAddress->shipAddressForm);
        $I->dontSee('United Kingdom', $userAddress->shipAddressForm);
    }

    private function addTestProductToDatabase(AcceptanceTester $I)
    {
        $data = Fixtures::get('productsData');
        foreach ($data as $table => $productData) {
            $I->haveInDatabase($table, $productData);
        }
    }

    /**
     * @param AcceptanceTester $I
     */
    private function addAddressData(AcceptanceTester $I)
    {
        $I->haveInDatabase('oxaddress', Fixtures::get('pickupAddress'));
        $I->haveInDatabase('oxaddress', Fixtures::get('userAddress'));
    }
}
