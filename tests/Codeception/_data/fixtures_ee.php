<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

$data = require_once 'fixtures.php';

$data['productsData']['oxarticles']['OXMAPID'] = 101;
$data['productsData']['oxarticles']['OXORDERINFO'] = '';
$data['productsData']['oxarticles2shop']['OXSHOPID'] = 1;
$data['productsData']['oxarticles2shop']['OXMAPOBJECTID'] = 101;

return $data;
