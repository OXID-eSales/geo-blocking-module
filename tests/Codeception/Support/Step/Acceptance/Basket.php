<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Codeception\Support\Step\Acceptance;

use OxidEsales\Codeception\Page\Checkout\UserCheckout;
use OxidEsales\Codeception\Page\Checkout\Basket as BasketPage;
use OxidEsales\Codeception\Module\Translation\Translator;
use OxidEsales\GeoBlocking\Tests\Codeception\Support\AcceptanceTester;

class Basket extends AcceptanceTester
{
    /**
     * @param $productId
     * @param $amount
     * @param $controller
     *
     * @return mixed
     */
    public function addProductToBasketAndOpen($productId, $amount, $controller)
    {
        $I = $this;
        //add Product to basket
        $params['cl'] = $controller;
        $params['fnc'] = 'tobasket';
        $params['aid'] = $productId;
        $params['am'] = $amount;
        $params['anid'] = $productId;
        $I->amOnPage(BasketPage::route($params));
        if ($controller === 'user') {
            $userCheckoutPage = new UserCheckout($I);
            $breadCrumbName = Translator::translate("ADDRESS");
            $userCheckoutPage->seeOnBreadCrumb($breadCrumbName);
            return $userCheckoutPage;
        } else {
            $basketPage = new BasketPage($I);
            $breadCrumbName = Translator::translate("CART");
            $basketPage->seeOnBreadCrumb($breadCrumbName);
            return $basketPage;
        }
    }
}
