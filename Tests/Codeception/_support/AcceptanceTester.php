<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Codeception;

use OxidEsales\Codeception\Page\Home;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Open shop first page.
     */
    public function openShop()
    {
        $I = $this;
        $I->amOnPage(Home::$URL);
        return new Home($I);
    }

    /**
     * @param int $timeout
     */
    public function waitForAjax($timeout = 60)
    {
        $I = $this;
        $I->waitForJS(
            'return !!window.jQuery && window.jQuery.active == 0;',
            $timeout
        );
    }
    /**
     * @param int $timeout
     */
    public function waitForPageLoad($timeout = 60)
    {
        $I = $this;
        $I->waitForJS(
            'return document.readyState == "complete"',
            $timeout
        );
        $this->waitForAjax($timeout);
    }
}
