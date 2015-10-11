<?php
/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 11/10/15
 * Time: 02:30
 */
class Ermini_Inventorylog_Block_Grid extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup      = 'ermini_inventorylog';
        $this->_controller      = 'grid';
        $this->_headerText      = $this->__('Inventory Log');
        parent::__construct();
        $this->_removeButton('add');
            }

   // public function getCreateUrl()
   // {
    //    return $this->getUrl('*/*/new');
   // }

}

