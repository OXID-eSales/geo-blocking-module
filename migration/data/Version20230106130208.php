<?php

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106130208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `oegeoblocking_country_to_shop` (
          `OXID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Record id',
          `OXCOUNTRYID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Country id',
          `OXSHOPID` int(11) NOT NULL DEFAULT '1' COMMENT 'Shop id (oxshops)',
          `PICKUP_ADDRESSID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'oxaddress id',
          `PICKUP_ADDRESS_ACTIVE` tinyint NOT NULL DEFAULT 0,
          `INVOICE_ONLY` tinyint NOT NULL DEFAULT 0,
          `OXTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
          PRIMARY KEY (`OXID`),
          UNIQUE KEY `OXCOUNTRYID` (`OXCOUNTRYID`,`OXSHOPID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Shows many-to-many relationship between fields and shops (multishops fields)';");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
