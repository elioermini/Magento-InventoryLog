<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 11/10/15
 * Time: 01:23
 */

/**
 * Class Ermini_Inventorylog_Model_Resource_Inventory_Collection
 */
class Ermini_Inventorylog_Model_Resource_Inventory_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * @_construct of Ermini_Inventorylog_Model_Resource_Inventory_Collection needed for listing collections of Object
     */
    public function _construct()
    {
        $this->_init('inventorylog/inventory');
    }
}