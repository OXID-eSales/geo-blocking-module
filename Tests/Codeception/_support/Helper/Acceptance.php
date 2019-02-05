<?php
namespace OxidEsales\GeoBlocking\Tests\Codeception\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I


require_once '/var/www/oxideshop/vendor/oxid-esales/testing-library/base.php';

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
