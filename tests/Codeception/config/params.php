<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\DoctrineMigrationWrapper;

use OxidEsales\Facts\Config\ConfigFile;
use OxidEsales\Facts\Facts;
use OxidEsales\Codeception\Module\Database\DatabaseDefaultsFileGenerator;
use Webmozart\PathUtil\Path;

$facts = new Facts();

$seleniumServerPort = getenv('SELENIUM_SERVER_PORT');
$seleniumServerPort = ($seleniumServerPort) ?: '4444';
$php = (getenv('PHPBIN')) ?: 'php';

return [
    'SHOP_URL' => $facts->getShopUrl(),
    'SHOP_SOURCE_PATH' => $facts->getSourcePath(),
    'VENDOR_PATH' => $facts->getVendorPath(),
    'DB_NAME' => $facts->getDatabaseName(),
    'DB_USERNAME' => $facts->getDatabaseUserName(),
    'DB_PASSWORD' => $facts->getDatabasePassword(),
    'DB_HOST' => $facts->getDatabaseHost(),
    'DB_PORT' => $facts->getDatabasePort(),
    'DUMP_PATH'            => getTestDataDumpFilePath(),
    'MODULE_DUMP_PATH'     => getModuleTestDataDumpFilePath(),
    'MYSQL_CONFIG_PATH'    => getMysqlConfigPath(),
    'SELENIUM_SERVER_PORT' => $seleniumServerPort,
    'SELENIUM_SERVER_HOST' => getenv('SELENIUM_SERVER_HOST') ?: 'selenium',
    'BROWSER_NAME'         => getenv('BROWSER_NAME') ?: 'chrome',
    'THEME_ID' => getenv('THEME_ID') ?: 'twig',
    'PHP_BIN' => $php,
];

function getTestDataDumpFilePath()
{
    return getShopTestPath() . '/Codeception/_data/dump.sql';
}

function getShopTestPath()
{
    $facts = new Facts();

    if ($facts->isEnterprise()) {
        $shopTestPath = $facts->getEnterpriseEditionRootPath() . '/Tests';
    } else {
        $shopTestPath = getShopSuitePath($facts);
    }

    return $shopTestPath;
}

function getShopSuitePath($facts)
{
    $testSuitePath = getenv('TEST_SUITE');

    if (!$testSuitePath) {
        $testSuitePath = $facts->getShopRootPath() . '/tests';
    }

    return $testSuitePath;
}

function getModuleTestDataDumpFilePath()
{
    return __DIR__ . '/../_data/dump.sql';
}

function getMysqlConfigPath()
{
    $facts = new Facts();
    $configFilePath = Path::join($facts->getSourcePath(), 'config.inc.php');
    $configFile = new ConfigFile($configFilePath);
    $generator = new DatabaseDefaultsFileGenerator($configFile);

    return $generator->generate();
}
