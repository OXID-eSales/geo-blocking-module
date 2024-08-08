<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

class_alias(
    \OxidEsales\Eshop\Application\Controller\Admin\CountryMain::class,
    \OxidEsales\GeoBlocking\Controller\Admin\CountryMain_parent::class
);

class_alias(
    \OxidEsales\Eshop\Application\Controller\OrderController::class,
    \OxidEsales\GeoBlocking\Controller\OrderController_parent::class
);

class_alias(
    \OxidEsales\Eshop\Application\Model\Country::class,
    \OxidEsales\GeoBlocking\Model\Country_parent::class
);

class_alias(
    \OxidEsales\Eshop\Application\Model\UserAddressList::class,
    \OxidEsales\GeoBlocking\Model\UserAddressList_parent::class
);

class_alias(
    \OxidEsales\Eshop\Application\Model\Address::class,
    \OxidEsales\GeoBlocking\Model\Address_parent::class
);

class_alias(
    \OxidEsales\Eshop\Application\Component\UserComponent::class,
    \OxidEsales\GeoBlocking\Component\UserComponent_parent::class
);

class_alias(
    \OxidEsales\Eshop\Core\InputValidator::class,
    \OxidEsales\GeoBlocking\Core\InputValidator_parent::class
);
