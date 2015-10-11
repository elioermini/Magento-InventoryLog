<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 20:11
 */
class Ermini_Inventorylog_Model_Inventory extends Mage_Core_Model_Abstract
{

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('inventorylog/inventory');
    }

    /**
     * @param Mage_CatalogInventory_Model_Stock_Item $item
     * @param $message
     */
    public function insertStockLog(Mage_CatalogInventory_Model_Stock_Item $item, $message)
    {
        $date=$this->getDate();
        $helper=Mage::helper('inventorylog');
        $originalQty = (int)$item->getOrigData('qty');
        $newQty = (int)$item->getData('qty');
        $difference=$newQty - $originalQty;

        $this->setItemId($item->getProductId())
            ->setUser($helper->_getUsername())
            ->setUserId($helper->_getUserId())
            ->setIsAdmin((int)Mage::getSingleton('admin/session')->isLoggedIn())
            ->setMovement($difference)
            ->setQty($newQty)
            ->setIsInStock((int)$item->getIsInStock())
            ->setMessage($message)
            ->setCreatedAt($date)
            ->save();
    }

    public function getDate(){
        return Varien_Date::formatDate(time());
    }

}