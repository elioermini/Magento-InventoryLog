<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 18:55
 */
class Ermini_Inventorylog_Model_Observer
{

    /**
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
}