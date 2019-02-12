<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Tests\Codeception\Helper;

require_once __DIR__.'/../../../../../../../../vendor/oxid-esales/testing-library/base.php';

use Codeception\TestInterface;

class Acceptance extends \Codeception\Module
{

    /**
     * **HOOK** executed before test
     *
     * @param TestInterface $test
     */
    public function _before(TestInterface $test)
    {
        // Activate modules
        $testConfig = new \OxidEsales\TestingLibrary\TestConfig();
        $modulesToActivate = $testConfig->getModulesToActivate();

        if ($modulesToActivate) {
            $serviceCaller = new \OxidEsales\TestingLibrary\ServiceCaller();
            $serviceCaller->setParameter('modulestoactivate', $modulesToActivate);
            $serviceCaller->callService('ModuleInstaller', 1);
        }

    }

}
