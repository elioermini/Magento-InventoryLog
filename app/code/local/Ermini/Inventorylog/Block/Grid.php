<?php

/**
 * Class Ermini_Inventorylog_Block_Grid is container of the table with product stock logs
 */
class Ermini_Inventorylog_Block_Grid extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * @__construct of Ermini_Inventorylog_Block_Grid
     */
    public function __construct()
    {
        $this->_blockGroup = 'ermini_inventorylog';
        $this->_controller = 'grid';
        $this->_headerText = $this->__('Inventory Log');
        parent::__construct();
        $this->_removeButton('add');
    }
}
