<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 20:01
 */
class Ermini_Inventorylog_Model_Resource_Inventory extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('inventorylog/inventory', 'movement_id');
    }

}