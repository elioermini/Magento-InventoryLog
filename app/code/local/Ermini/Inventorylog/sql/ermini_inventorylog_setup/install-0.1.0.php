<?php
/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 18:10
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tableLog = $installer->getTable('ermini_inventorylog');
$tableProduct = $installer->getTable('cataloginventory/stock_item');
$tableUser = $installer->getTable('admin/user');

$installer->run("DROP TABLE IF EXISTS {$tableLog};
CREATE TABLE {$tableLog} (
`movement_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`item_id` INT( 10 ) UNSIGNED NOT NULL ,
`user` varchar(40) NOT NULL DEFAULT '',
`user_id` mediumint(9) unsigned DEFAULT NULL,
`is_admin` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
`movement` DECIMAL( 12, 4 ) NOT NULL default '0',
`qty` DECIMAL( 12, 4 ) NOT NULL default '0',
`is_in_stock` TINYINT( 1 ) UNSIGNED NOT NULL default '0',
`message` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`created_at` DATETIME NOT NULL ,
INDEX ( `item_id` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");

$installer->getConnection()->addConstraint('FK_STOCK_MOVEMENT_PRODUCT', $tableLog, 'item_id', $tableProduct, 'item_id');
$installer->getConnection()->addConstraint('FK_STOCK_MOVEMENT_USER', $tableLog, 'user_id', $tableUser, 'user_id',
    'SET NULL');

$installer->endSetup();