<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 23:03
 */
class Ermini_Inventorylog_IndexController extends Mage_Core_Controller_Front_Action
{

    /**
     *test class to test Ermini_Inventorylog Model
     */
    public function testModelAction()
    {

        $params = $this->getRequest()->getParams();
        $id = (int)$params['id'];
        $inventorylog = Mage::getModel('inventorylog/inventory');
        echo "Loading " . $id;
        $inventorylog->load($id);
        $data = $inventorylog->getData();
        echo get_class($inventorylog);
        var_dump($data);
    }

    public function testStockAction()
    {
        $params = $this->getRequest()->getParams();
        $id = (int)$params['id'];
        $stock = Mage::getModel('cataloginventory/stock_item')->load($id)->getIsInStock();
        var_dump($stock);
    }
}