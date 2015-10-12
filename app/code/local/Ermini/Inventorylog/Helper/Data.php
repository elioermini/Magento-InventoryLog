<?php
/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 10/10/15
 * Time: 18:10
 */ 
class Ermini_Inventorylog_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * @return int|null
     */
    public function _getUserId()
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
    public function _getUsername()
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

    public function getDate(){
        return Varien_Date::formatDate(time());
    }

}