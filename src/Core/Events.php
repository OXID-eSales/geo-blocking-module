<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Core;

use Exception;
use OxidEsales\DoctrineMigrationWrapper\MigrationsBuilder;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Module events class.
 */
class Events
{
    /**
     * Execute action on activate event
     *
     * @throws Exception
     */
    public static function onActivate(): void
    {
        // execute module migrations
        self::executeModuleMigrations();
    }

    /**
     * Execute action on deactivate event
     *
     * @throws Exception
     */
    public static function onDeactivate(): void
    {
        //nothing to be done here for this module right now
    }

    /**
     * Execute necessary module migrations on activate event
     */
    private static function executeModuleMigrations(): void
    {
        $migrations = (new MigrationsBuilder())->build();

        $output = new BufferedOutput();
        $migrations->setOutput($output);
        $neeedsUpdate = $migrations->execute('migrations:up-to-date', 'oegeoblocking');

        if ($neeedsUpdate) {
            $migrations->execute('migrations:migrate', 'oegeoblocking');
        }
    }
}
