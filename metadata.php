<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\GeoBlocking\Component\UserComponent;
use OxidEsales\GeoBlocking\Controller\Admin\CountryMain;
use OxidEsales\GeoBlocking\Controller\OrderController;
use OxidEsales\GeoBlocking\Core\Events;
use OxidEsales\GeoBlocking\Core\InputValidator;
use OxidEsales\GeoBlocking\Model\Address;
use OxidEsales\GeoBlocking\Model\Country;
use OxidEsales\GeoBlocking\Model\UserAddressList;

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information.
 */
$aModule = [
    'id' => 'oegeoblocking',
    'title' => 'OXID geo-blocking module',
    'description' => [
        'de' => 'Dieses Modul ermöglicht es, den OXID eShop konform zu der EU Geoblocking-Verordnung einzurichten.',
        'en' => 'The module enables OXID eShop to be compliant with the EU geo-blocking regulations.',
    ],
    'thumbnail' => '/out/pictures/logo.png',
    'version' => '2.0.0',
    'author' => 'OXID eSales AG',
    'url' => 'https://www.oxid-esales.com',
    'email' => 'info@oxid-esales.com',
    'extend' => [
        \OxidEsales\Eshop\Application\Controller\Admin\CountryMain::class => CountryMain::class,
        \OxidEsales\Eshop\Application\Controller\OrderController::class => OrderController::class,
        \OxidEsales\Eshop\Application\Model\Country::class => Country::class,
        \OxidEsales\Eshop\Application\Model\UserAddressList::class => UserAddressList::class,
        \OxidEsales\Eshop\Application\Model\Address::class => Address::class,
        \OxidEsales\Eshop\Application\Component\UserComponent::class => UserComponent::class,
        \OxidEsales\Eshop\Core\InputValidator::class => InputValidator::class,
    ],
    'events' => [
        'onActivate' => '\OxidEsales\GeoBlocking\Core\Events::onActivate',
    ],
    'blocks' => [
        // Admin
        [
            'template' => 'country_main.tpl',
            'block' => 'admin_country_main_form',
            'file' => 'views/smarty/blocks/admin_country_main_form.tpl'
        ],
        // Frontend
        [
            'template' => 'form/user_checkout_change.tpl',
            'block' => 'user_checkout_billing_feedback',
            'file' => 'views/smarty/blocks/form/user_checkout_billing_feedback.tpl'
        ],
        [
            'template' => 'form/fieldset/user_billing.tpl',
            'block' => 'form_user_billing_country',
            'file' => 'views/smarty/blocks/form/form_user_billing_country.tpl'
        ],
        [
            'template' => 'form/fieldset/user_shipping.tpl',
            'block' => 'form_user_shipping_country',
            'file' => 'views/smarty/blocks/form/form_user_shipping_country.tpl'
        ],
        [
            'template' => 'form/fieldset/user_shipping.tpl',
            'block' => 'form_user_shipping_address_select',
            'file' => 'views/smarty/blocks/form/form_user_shipping_address_select.tpl'
        ],
    ],
];
