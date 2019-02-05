<?php namespace OxidEsales\GeoBlocking\Tests\Codeception;

use OxidEsales\Codeception\Module\Translation\Translator;
use OxidEsales\GeoBlocking\Tests\Codeception\AcceptanceTester;

class UserRegistrationCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function registerUser(AcceptanceTester $I)
    {
        $I->wantToTest('user registration');

        // prepare user data
        $userId = '1';
        $userLoginData = $this->getUserLoginData($userId);
        $userData = $this->getUserData($userId);
        $addressData = $this->getUserAddressData($userId);

        $startPage = $I->openShop();
        $registrationPage = $startPage->openUserRegistrationPage();

        $registrationPage->enterUserLoginData($userLoginData)
            ->enterUserData($userData)
            ->enterAddressData($addressData)
            ->registerUser();

        $I->see(Translator::translate('MESSAGE_WELCOME_REGISTERED_USER'));

    }

    private function getUserLoginData($userId, $userPassword = 'user1user1')
    {
        $userLoginData = [
            "userLoginNameField" => "example".$userId."@oxid-esales.dev",
            "userPasswordField" => $userPassword,
        ];
        return $userLoginData;
    }

    private function getUserData($userId)
    {
        $userData = [
            "userUstIDField" => "",
            "userMobFonField" => "111-111111-$userId",  //still needed?
            "userPrivateFonField" => "11111111$userId",
            "userBirthDateDayField" => rand(10, 28),
            "userBirthDateMonthField" => rand(10, 12),
            "userBirthDateYearField" => rand(1960, 2000),
        ];
        return $userData;
    }

    private function getUserAddressData($userId, $userCountry = 'Germany')
    {
        $addressData = [
            "UserSalutation" => 'Mrs',
            "UserFirstName" => "user$userId name_šÄßüл",
            "UserLastName" => "user$userId last name_šÄßüл",
            "CompanyName" => "user$userId company_šÄßüл",
            "Street" => "user$userId street_šÄßüл",
            "StreetNr" => "$userId-$userId",
            "ZIP" => "1234$userId",
            "City" => "user$userId city_šÄßüл",
            "AdditionalInfo" => "user$userId additional info_šÄßüл",
            "FonNr" => "111-111-$userId",
            "FaxNr" => "111-111-111-$userId",
            "CountryId" => $userCountry,
        ];
        if ( $userCountry == 'Germany' ) {
            $addressData["StateId"] = "Berlin";
        }
        return $addressData;
    }
}
