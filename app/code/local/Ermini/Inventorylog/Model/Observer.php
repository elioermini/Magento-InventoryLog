<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 18:55
 */

/**
 * Class Ermini_Inventorylog_Model_Observer will catch events fired by Magento
 *
 *
 */
class Ermini_Inventorylog_Model_Observer
{

    /**
     * Logs changes when manually done with Api or Admin user
     * @param Varien_Event_Observer $observer
     */
    public function saveInventoryAfter(Varien_Event_Observer $observer)
    {
        $product = $observer->getEvent()->getItem();
        if (!$product->getStockStatusChangedAutomaticallyFlag() || $product->getOriginalInventoryQty() != $product->getQty()) {
            if (!$message = $product->getSaveMovementMessage()) {
                if (Mage::getSingleton('api/session')->getSessionId()) {
                    $message = 'Stock saved from Magento API';
                } else {
                    $message = 'Stock saved manually';
                }
            }
            Mage::getModel('inventorylog/inventory')->insertStockLog($product, $message);
        }

    }

    /**
     * Reduces stock from Order through Observer
     * @param Varien_Event_Observer $observer
     */
    public function reduceQuoteInventory(Varien_Event_Observer $observer)
    {

        $quote = $observer->getEvent()->getQuote();
        foreach ($quote->getAllItems() as $item) {

            $message = 'Checkout';

            $params = array();
            $params['item_id'] = $item->getProductId();
            $params['user'] = 'Customer';
            $params['user_id'] = '';
            $params['qty'] = $item->getProduct()->getStockItem()->getQty();
            $params['movement'] = ($item->getTotalQty() * -1);
            $params['is_in_stock'] = '';
            $params['created_at'] = Mage::helper('inventorylog')->getDate();
            Mage::getModel('inventorylog/inventory')->setItemId($item->getProductId())
                ->setUser('Customer')
                ->setUserId('')
                ->setIsAdmin('No')
                ->setMovement($params['movement'])
                ->setQty($params['qty'])
                ->setIsInStock('')
                ->setMessage($message)
                ->setCreatedAt($params['created_at'])
                ->save();
        }

    }
}