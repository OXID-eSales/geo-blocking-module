<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GeoBlocking\Service;

use OxidEsales\EshopCommunity\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GeoBlocking\Model\CountryToShop;

/**
 * Class responsible for providing access to "country to shop".
 */
class CountryToShopService
{
    /**
     * @var CountryToShop
     */
    private $countryToShop;

    /**
     * Initializes necessary objects.
     */
    public function __construct()
    {
        $this->countryToShop = oxNew(CountryToShop::class);
    }

    /**
     * @param string $countryId
     * @return CountryToShop
     */
    public function getByCountryId($countryId)
    {
        $parameters = [
            $this->countryToShop->getViewName() . '.OXCOUNTRYID' => $countryId,
            $this->countryToShop->getViewName() . '.OXSHOPID' => Registry::getConfig()->getShopId(),
        ];
        $record = $this->getById($parameters);

        $isLoaded = false;
        if (is_array($record) && count($record)) {
            $this->countryToShop->assign($record);
            $isLoaded = true;
        }

        if (!$isLoaded) {
            $this->countryToShop->assign(
                [
                    'oxcountryid' => $countryId,
                    'oxshopid' => Registry::getConfig()->getShopId()
                ]
            );
        }

        return $this->countryToShop;
    }

    /**
     * @param string $addressId
     * @return CountryToShop
     */
    public function getByAddressId($addressId)
    {
        $parameters = [
            $this->countryToShop->getViewName() . '.PICKUP_ADDRESSID' => $addressId,
            $this->countryToShop->getViewName() . '.OXSHOPID' => Registry::getConfig()->getShopId(),
        ];

        $record = $this->getById($parameters);
        if (is_array($record) && count($record)) {
            $this->countryToShop->assign($record);
        }

        return $this->countryToShop;
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getById(array $parameters)
    {
        $selectQuery = $this->countryToShop->buildSelectString($parameters);

        $connection = ContainerFactory::getInstance()
            ->getContainer()
            ->get(QueryBuilderFactoryInterface::class)
            ->create()
            ->getConnection();

        return $connection
            ->executeQuery($selectQuery)
            ->fetchAssociative();
    }
}
