<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 20:11
 */

/**
 * Inventory model
 *
 * Class Ermini_Inventorylog_Model_Inventory is in charge of logging the stock movements of product
 *
 * @method getData()
 *
 */
class Ermini_Inventorylog_Model_Inventory extends Mage_Core_Model_Abstract
{

    /**
     * @_construct Ermini_Inventorylog_Model_Inventory
     */
    protected function _construct()
    {
        $this->_init('inventorylog/inventory');
    }

    /**
     * Inserts stock log in table of Ermini_Inventorylog_Model_Inventory
     *
     * @param $item Mage_Catalog_Model_Product - the product that changed stock
     * @param $message
     *
     */
    public function insertStockLog($item, $message)
    {
        $helper = Mage::helper('inventorylog');
        $id=$item->getId();
        $originalQty = (int)$item->getOrigData('qty');
        $newQty = (int)$item->getData('qty');
        $difference = $newQty - $originalQty;
        $stock=Mage::getModel('cataloginventory/stock_item')->loadByProduct($id)->getIsInStock();

        $this->setItemId($id)
            ->setUser($helper->_getUsername())
            ->setUserId($helper->_getUserId())
            ->setIsAdmin((int)Mage::getSingleton('admin/session')->isLoggedIn())
            ->setMovement($difference)
            ->setQty($newQty)
            ->setIsInStock($stock)
            ->setMessage($message)
            ->setCreatedAt($helper->getDate())
            ->save();
    }

}