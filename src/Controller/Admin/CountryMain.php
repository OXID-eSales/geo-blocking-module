<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Controller\Admin;

use OxidEsales\Eshop\Application\Model\Country;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\EshopCommunity\Core\Registry;
use OxidEsales\GeoBlocking\Service\CountryToShopService;
use OxidEsales\GeoBlocking\Service\NotInvoiceOnlyCountryListService;
use OxidEsales\GeoBlocking\Service\PickupAddressService;

/**
 * Controller class which responsible for rendering and saving country data.
 * @mixin \OxidEsales\Eshop\Application\Controller\Admin\CountryMain
 */
class CountryMain extends CountryMain_parent
{
    /**
     * @see \OxidEsales\Eshop\Application\Controller\Admin\CountryMain::render()
     * @return string
     */
    public function render()
    {
        $templateName = parent::render();

        if (isset($this->_aViewData['edit'])) {
            /** @var Country $country */
            $country = $this->_aViewData['edit'];
            $this->_aViewData['invoiceCountry'] = oxNew(CountryToShopService::class)->getByCountryId($country->getId());
            $this->_aViewData['pickupAddress'] = oxNew(PickupAddressService::class)->getByCountryId($country->getId());

            $countryListService = oxNew(NotInvoiceOnlyCountryListService::class);
            $this->_aViewData["countryList"] =
                $countryListService->getWithSelectedLanguage(Registry::getLang()->getObjectTplLanguage());
        }

        return $templateName;
    }

    /**
     * @see \OxidEsales\Eshop\Application\Controller\Admin\CountryMain::save()
     *
     * @return void
     * @throws \Exception
     */
    public function save()
    {
        parent::save();

        $requestParameters = Registry::getRequest()->getRequestEscapedParameter('editval_gb');

        $address = oxNew(PickupAddressService::class)->getByAddressId((string)$requestParameters['oxaddress_oxid']);
        $address->assign($requestParameters);
        $address->save();

        $countryToShop = oxNew(CountryToShopService::class)->getByCountryId((string)$this->getEditObjectId());
        $countryToShop->assign($requestParameters);
        $countryToShop->oegeoblocking_country_to_shop__pickup_addressid = new Field($address->getId());
        $countryToShop->save();
    }
}
