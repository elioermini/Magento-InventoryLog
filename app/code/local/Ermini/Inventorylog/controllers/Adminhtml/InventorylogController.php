<?php

/**
 * Created by PhpStorm.
 * User: Elio
 * Date: 11/10/15
 * Time: 01:31
 */
class Ermini_Inventorylog_Adminhtml_InventorylogController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('ermini_inventorylog/grid'));
        $this->renderLayout();
    }

    /**
     * Export to Csv
     */
    public function exportCsvAction()
    {
        $fileName = 'inventorylog_export.csv';
        $content = $this->getLayout()->createBlock('ermini_inventorylog/grid_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Export to Excel
     */
    public function exportExcelAction()
    {
        $fileName = 'inventorylog_export.xml';
        $content = $this->getLayout()->createBlock('ermini_inventorylog/grid_grid')->getExcel();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Deletes entries 1 or more
     */
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('ids');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select inventorylog(s).'));
        } else {
            try {
                foreach ($ids as $id) {
                    $model = Mage::getSingleton('inventorylog/inventory')->load($id);
                    $model->delete();
                }

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been deleted.', count($ids))
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    Mage::helper('inventorylog')->__('An error occurred while mass deleting items. Please review log and try again.')
                );
                Mage::logException($e);
                return;
            }
        }
        $this->_redirect('*/*/index');
    }

}