<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 11/10/15
 * Time: 02:30
 */
class Ermini_Inventorylog_Block_Grid_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        $this->setDefaultSort('movement_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('inventorylog/inventory')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {

        $this->addColumn('movement_id',
            array(
                'header' => Mage::helper('inventorylog')->__('Movement ID'),
                'width' => '50px',
                'index' => 'movement_id'
            )
        );
 /*       $this->addColumn('item_id',
            array(
                'header' => Mage::helper('inventorylog')->__('Product ID'),
                'width' => '40px',
                'index' => 'item_id'
            )
        );*/
        $this->addColumn('sku',
            array(
                'header' => Mage::helper('inventorylog')->__('SKU'),
                'width' => '40px',
                'index' => 'item_id',
                'frame_callback' => array($this, 'callback_sku'),
//                'filter_condition_callback' => array($this, 'filter_sku'),
            )
        );
        $this->addColumn('message',
            array(
                'header' => Mage::helper('inventorylog')->__('Message'),
                'width' => '50px',
                'index' => 'message'
            )
        );
        $this->addColumn('user_id',
            array(
                'header' => Mage::helper('inventorylog')->__('User ID'),
                'width' => '40px',
                'index' => 'user_id'
            )
        );
        $this->addColumn('user',
            array(
                'header' => Mage::helper('inventorylog')->__('User Name'),
                'width' => '50px',
                'index' => 'user'
            )
        );
        $this->addColumn('is_admin',
            array(
                'header' => Mage::helper('inventorylog')->__('User is Admin'),
                'width' => '40px',
                'index' => 'is_admin',
                'type'=>'options',
                'options' => array(
                    '1' => Mage::helper('catalog')->__('Yes'),
                    '0' => Mage::helper('catalog')->__('No'),
                ),
            )
        );
        $this->addColumn('movement',
            array(
                'header' => Mage::helper('inventorylog')->__('Movement'),
                'width' => '40px',
                'index' => 'movement',
                'frame_callback' =>array($this,'callback_movement')
            )
        );
        $this->addColumn('qty',
            array(
                'header' => Mage::helper('inventorylog')->__('Quantity'),
                'width' => '40px',
                'index' => 'qty'
            )
        );
        $this->addColumn('is_in_stock', array(
            'header' => Mage::helper('inventorylog')->__('In Stock'),
            'align' => 'right',
            'index' => 'is_in_stock',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('catalog')->__('Yes'),
                '0' => Mage::helper('catalog')->__('No'),
            ),
            'width' => '80px',
            'filter_index' => 'is_in_stock'
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('inventorylog')->__('Change Date'),
            'align' => 'right',
            'index' => 'created_at',
            'width' => '80px'
        ));

        $this->addExportType('*/*/exportCsv', $this->__('CSV'));

        $this->addExportType('*/*/exportExcel', $this->__('Excel XML'));

        return parent::_prepareColumns();
    }

    //public function getRowUrl(Varien_Object $row)
    //{
    //   return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    //}

    protected function _prepareMassaction()
    {
        $modelPk = Mage::getModel('inventorylog/inventory')->getResource()->getIdFieldName();
        $this->setMassactionIdField($modelPk);
        $this->getMassactionBlock()->setFormFieldName('ids');
        // $this->getMassactionBlock()->setUseSelectAll(false);
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }

    public function callback_sku($id)
    {
        $_product = Mage::getModel('catalog/product')->load($id);
        if($_product->getId()){
        return $_product->getData('sku');
        }
        return Mage::helper('inventorylog')->__("Product not in Catalog");
    }

    public function filter_sku($column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $this->getCollection()->getSelect()->where(
            "sku like ?"
            , "%$value%");

        return $this;

    }

    public function callback_movement($difference)
    {
        if ($difference > 0) {
            return "+" . (int)$difference;
        }
        return (int)$difference;
    }
}
