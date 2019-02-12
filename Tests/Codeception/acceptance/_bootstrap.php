<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\Facts\Facts;

$helper = new \OxidEsales\Codeception\Module\FixturesHelper();
$fixturesPath = dirname(__FILE__).'/../_data/fixtures.php';
if ((new Facts())->isEnterprise()) {
    $fixturesPath = dirname(__FILE__).'/../_data/fixtures_ee.php';
}
$helper->loadRuntimeFixtures($fixturesPath);
