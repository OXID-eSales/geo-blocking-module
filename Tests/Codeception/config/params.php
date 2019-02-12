<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\DoctrineMigrationWrapper;

$facts = new \OxidEsales\Facts\Facts();

$seleniumServerPort = getenv('SELENIUM_SERVER_PORT');
$seleniumServerPort = ($seleniumServerPort) ? $seleniumServerPort : '4444';
$php = (getenv('PHPBIN')) ? getenv('PHPBIN') : 'php';

return [
    'SHOP_URL' => $facts->getShopUrl(),
    'SHOP_SOURCE_PATH' => $facts->getSourcePath(),
    'VENDOR_PATH' => $facts->getVendorPath(),
    'DB_NAME' => $facts->getDatabaseName(),
    'DB_USERNAME' => $facts->getDatabaseUserName(),
    'DB_PASSWORD' => $facts->getDatabasePassword(),
    'DB_HOST' => $facts->getDatabaseHost(),
    'DB_PORT' => $facts->getDatabasePort(),
    'DUMP_PATH' => __DIR__. '/../_data/dump.sql',
    'SELENIUM_SERVER_PORT' => $seleniumServerPort,
    'PHP_BIN' => $php,
];
