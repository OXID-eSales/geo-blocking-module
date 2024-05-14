<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Integration\Core;

use OxidEsales\Eshop\Application\Controller\UserController;
use OxidEsales\Eshop\Application\Model\Country;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\InputValidator;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\GeoBlocking\Model\CountryToShop;
use PHPUnit\Framework\TestCase;

class InputValidatorTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $user = new User();
        $user->setId('user_id');
        $user->save();
        $this->user = $user;

        $countryToShop = new CountryToShop();
        $countryToShop->setId('test_model_id');
        $countryToShop->oegeoblocking_country_to_shop__oxshopid = new Field(Registry::getConfig()->getShopId());
        $countryToShop->oegeoblocking_country_to_shop__oxcountryid = new Field('country_id');
        $countryToShop->oegeoblocking_country_to_shop__pickup_addressid = new Field('address_id');
        $countryToShop->oegeoblocking_country_to_shop__invoice_only = new Field(1);
        $countryToShop->save();

        $address = new Country();
        $address->setId('country_id');
        $address->oxcountry__oxactive = new Field(1);
        $address->save();

        $countryToShop2 = new CountryToShop();
        $countryToShop2->setId('test_model_id2');
        $countryToShop2->oegeoblocking_country_to_shop__oxshopid = new Field(Registry::getConfig()->getShopId());
        $countryToShop2->oegeoblocking_country_to_shop__oxcountryid = new Field('country_id2');
        $countryToShop2->oegeoblocking_country_to_shop__pickup_addressid = new Field('address_id');
        $countryToShop2->oegeoblocking_country_to_shop__invoice_only = new Field(0);
        $countryToShop2->save();

        $address2 = new Country();
        $address2->setId('country_id2');
        $address2->oxcountry__oxactive = new Field(1);
        $address2->save();
    }

    public static function checkoutCountriesProvider()
    {
        return [
            [['oxuser__oxcountryid' => 'country_id'], ['oxaddress__oxcountryid' => 'country_id']],
            [['oxuser__oxcountryid' => ''], ['oxaddress__oxcountryid' => 'country_id']],
            [['oxuser__oxcountryid' => 'country_id'], ['oxaddress__oxcountryid' => '']],
        ];
    }

    /**
     * @dataProvider checkoutCountriesProvider
     * @param array $invoiceAddressParameters
     * @param array $deliveryAddressParameters
     */
    public function testCheckInvoiceOnlyCountries($invoiceAddressParameters, $deliveryAddressParameters)
    {
        $validator = $this->createInputValidator();

        $validator->checkCountries($this->user, $invoiceAddressParameters, $deliveryAddressParameters);

        $errors = $validator->getFieldValidationErrors();
        $this->assertSame(1, count($errors));
        $this->assertSame(
            Registry::getLang()->translateString('OEGEOBLOCKING_ERROR_MESSAGE_INPUT_COUNTRY_NOT_ALLOWED'),
            $errors[''][0]->getMessage()
        );
    }

    public function testCheckCountriesWhenNoInvoiceOnlyCountryProvided()
    {
        $validator = $this->createInputValidator();

        $invoiceAddressParameters['oxuser__oxcountryid'] = 'country_id2';

        $validator->checkCountries($this->user, $invoiceAddressParameters, []);

        $errors = $validator->getFieldValidationErrors();
        $this->assertSame(0, count($errors));
    }

    /**
     * @return \OxidEsales\GeoBlocking\Core\InputValidator
     */
    private function createInputValidator()
    {
        $userController = oxNew(UserController::class);
        $userController->setClassKey('user');
        Registry::getConfig()->setActiveView($userController);
        /** @var \OxidEsales\GeoBlocking\Core\InputValidator $validator */
        $validator = oxNew(InputValidator::class);
        return $validator;
    }
}
