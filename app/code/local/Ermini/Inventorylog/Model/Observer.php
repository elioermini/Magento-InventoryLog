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
 * @method Mage_Catalog_Model_Product getStockStatusChangedAutomaticallyFlag()
 * @method Mage_Catalog_Model_Product getOriginalInventoryQty()
 * @method
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
        /**
         * @var $product Mage_Catalog_Model_Product
         */
        $product = $observer->getEvent()->getItem();
        if (!$product->getStockStatusChangedAutomaticallyFlag() || $product->getOriginalInventoryQty() != $product->getQty()) {
            if (!$message = $product->getSaveMovementMessage()) {
                if (Mage::getSingleton('api/session')->getSessionId()) {
                    $message = 'Stock saved from Magento API';
                } else {
                    $message = 'Stock saved manually';
                }
            }
            $this->_getInventoryModel()->insertStockLog($product, $message);
        }

    }


    /**
     * @return Ermini_Inventorylog_Model_Inventory
     */
    private function _getInventoryModel()
    {

        return Mage::getModel('inventorylog/inventory');
    }

    /**
     * Reduces stock from Order through Observer
     * @param Varien_Event_Observer $observer
     */
    public function reduceQuoteInventory(Varien_Event_Observer $observer)
    {

        $quote = $observer->getEvent()->getQuote();
        $message = 'Checkout';
        $helper = Mage::helper('inventorylog');

        /**
         * @var $quote Mage_Sales_Model_Quote
         * loops through the items being purchased
         *
         * @var $item Mage_Sales_Model_Quote_Item
         */
        foreach ($quote->getAllItems() as $item) {


            $id = $item->getProductId();
            /**
             * @var $currentQty int is the stock of product before order
             */

            $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($id);
            /**
             * @var $qty int is the stock of product before order
             */
            $qty = $stockItem->getQty();
            /**
             * @var $stock bool|int tells if the product is in stock or not
             */
            $stock = $stockItem->getIsInStock();
            /**
             * @var $purchasedQty int is the quantity being purchased for this product
             */
            $purchasedQty = (int)$item->getTotalQty();
            /**
             * @var $movement int is the change between the previous quantity and the quantity being purchased
             *      will be the negation of the absolute number
             */
            $movement = ($purchasedQty * -1);

            $model = $this->_getInventoryModel();

            $model->setMovement($movement);
            $model->setItemId($id);
            $model->setUser($helper->_getUsername());
            $model->setUserId($helper->_getUserId());
            $model->setIsAdmin((int)Mage::getSingleton('admin/session')->isLoggedIn());
            $model->setQty($qty);
            $model->setIsInStock($stock);
            $model->setMessage($message);
            $model->setCreatedAt(Mage::helper('inventorylog')->getDate());
            $model->save();

        }
    }
}