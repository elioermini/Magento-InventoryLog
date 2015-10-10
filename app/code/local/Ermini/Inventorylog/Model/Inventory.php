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
        $originalQty = (int)$item->getOrigData('qty');
        $newQty = (int)$item->getData('qty');
        $this->setItemId($item->getId())
            ->setUser($this->_getUsername())
            ->setUserId($this->_getUserId())
            ->setIsAdmin((int)Mage::getSingleton('admin/session')->isLoggedIn())
            ->setMovement($newQty - $originalQty)
            ->setQty($newQty)
            ->setIsInStock((int)$item->getIsInStock())
            ->setMessage($message)
            ->save();
    }

    /**
     * @return int|null
     */
    protected function _getUserId()
    {
        $userId = null;
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $userId = Mage::getSingleton('customer/session')->getCustomerId();
        } elseif (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        }

        return $userId;
    }

    /**
     * @return string
     */
    protected function _getUsername()
    {
        $username = '-';
        if (Mage::getSingleton('api/session')->isLoggedIn()) {
            $username = Mage::getSingleton('api/session')->getUser()->getUsername();
        } elseif (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $username = Mage::getSingleton('customer/session')->getCustomer()->getName();
        } elseif (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $username = Mage::getSingleton('admin/session')->getUser()->getUsername();
        }

        return $username;
    }
}