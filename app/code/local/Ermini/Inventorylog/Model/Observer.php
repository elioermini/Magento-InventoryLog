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

    public function checkoutAllSubmitAfter(Varien_Event_Observer $observer)
    {
        if ($observer->getEvent()->hasOrders()) {
            $orders = $observer->getEvent()->getOrders();
        } else {
            $orders = array($observer->getEvent()->getOrder());
        }
        $stockItems = array();
        foreach ($orders as $order) {
            if ($order) {
                foreach ($order->getAllItems() as $orderItem) {
                    /** @var Mage_Sales_Model_Order_Item $orderItem */
                    if ($orderItem->getQtyOrdered() && $orderItem->getProductType() == 'simple') {
                        $stockItem = Mage::getModel('cataloginventory/stock_item')
                            ->loadByProduct($orderItem->getProductId());
                        if (!isset($stockItems[$stockItem->getId()])) {
                            $stockItems[$stockItem->getId()] = array(
                                'item' => $stockItem,
                                'orders' => array($order->getIncrementId()),
                            );
                        } else {
                            $stockItems[$stockItem->getId()]['orders'][] = $order->getIncrementId();
                        }
                    }
                }
            }
        }

        if (!empty($stockItems)) {
            foreach ($stockItems as $data) {
                Mage::getModel('inventorylog/inventory')->insertStockLog($data['item'], sprintf(
                    'Product ordered (order%s: %s)',
                    count($data['orders']) > 1 ? 's' : '',
                    implode(', ', $data['orders'])
                ));
            }
        }
    }
}