<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\Facts\Facts;
use Symfony\Component\Filesystem\Path;

require_once Path::join((new \OxidEsales\Facts\Facts())->getShopRootPath(), 'source', 'bootstrap.php');

$helper = new \OxidEsales\Codeception\Module\FixturesHelper();
$fixturesPath = dirname(__FILE__) . '/../Support/Data/fixtures.php';
if ((new Facts())->isEnterprise()) {
    $fixturesPath = dirname(__FILE__) . '/../Support/Data/fixtures_ee.php';
}
$helper->loadRuntimeFixtures($fixturesPath);
