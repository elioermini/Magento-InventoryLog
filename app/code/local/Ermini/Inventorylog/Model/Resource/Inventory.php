<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 20:01
 */

/**
 * Class Ermini_Inventorylog_Model_Resource_Inventory
 */
class Ermini_Inventorylog_Model_Resource_Inventory extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * @_construct of Ermini_Inventorylog_Model_Resource_Inventory
     */
    protected function _construct()
    {
        $this->_init('inventorylog/inventory', 'movement_id');
    }

}