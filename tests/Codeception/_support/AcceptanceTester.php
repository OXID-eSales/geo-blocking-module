<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Codeception;

use OxidEsales\Codeception\Page\Home;
use OxidEsales\Facts\Facts;

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
        $homePage = new Home($I);
        $I->amOnPage($homePage->URL);
        return $homePage;
    }

    public function setModuleActive(bool $active = true): void
    {
        $command = $active ? 'activate' : 'deactivate';

        exec((new Facts())->getShopRootPath() . '/bin/oe-console oe:module:' . $command . ' oegeoblocking');
    }

    public function waitForPageLoad()
    {
        if (getenv('THEME_ID') !== 'apex') {
            parent::waitForPageLoad();
        }
    }
}
