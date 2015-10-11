<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 11/10/15
 * Time: 01:23
 */
class Ermini_Inventorylog_Model_Resource_Inventory_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * loop in the object Ermini_invontorylog
     */
    public function _construct()
    {
        $this->_init('inventorylog/inventory');
    }
}