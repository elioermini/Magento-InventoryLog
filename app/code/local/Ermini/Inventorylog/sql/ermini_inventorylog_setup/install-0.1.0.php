<?php
/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 18:10
 *
 * @var $installer Mage_Core_Model_Resource_Setup *
 *
 * Create Inventory log Entity Table
 *
 *
 */
$installer = $this;

$installer->startSetup();
$installer->endSetup();
// Check if the table already exists
if ($installer->getConnection()->isTableExists('inventorylog/inventory') != true) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('inventorylog/inventory'))
        ->addColumn('movement_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
            ),
            'Movement Id'
        )
        ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ),
            'Product Id'
        )
        ->addColumn('user', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array(),
            'User Name'
        )
        ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ),
            'User Id'
        )
        ->addColumn('is_admin', Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ),
            'User is Admin'
        )
        ->addColumn('movement', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ),
            'Movement Difference'
        )
        ->addColumn('qty', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ),
            'New Quantity'
        )
        ->addColumn('is_in_stock', Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
            array(
                'unsigned' => true,
                'nullable' => false,
                'default' => '0',
            ),
            'Is Product in Stock'
        )
        ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
            array(),
            'Note about the Movement'
        )
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null,
            array(),
            'Created At')
        ->addIndex($installer->getIdxName('inventorylog/inventory', array('movement_id')),
            array('movement_id'))
        ->addIndex($installer->getIdxName('inventorylog/inventory', array('item_id')),
            array('item_id'));
        /*@todo fix error foreign key connstraint */
//        ->addForeignKey(
//            $installer->getFkName(
//                'inventorylog/inventory',
//                'item_id',
//                'catalog/product',
//                'entity_id'
//            ),
//            'item_id', $installer->getTable('catalog/product'), 'entity_id',
//            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();