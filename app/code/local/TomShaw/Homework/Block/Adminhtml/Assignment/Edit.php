<?php

class TomShaw_Homework_Block_Adminhtml_Assignment_Edit extends Mage_Adminhtml_Block_Widget_Form_Container 
{
    public function __construct() 
    {
        $this->_controller = 'adminhtml_assignment';
        $this->_objectId = 'id';
        $this->_blockGroup = 'homework';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('homework')->__('Update Assignment')); 
        $this->_updateButton('delete', 'label', Mage::helper('homework')->__('Delete Assignment')); 

		$this->_addButton('saveandcontinue', array(
			'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
			'onclick'   => 'saveAndContinueEdit()',
			'class'     => 'save',
			), -100
		);
			
		$this->_formScripts[] = "function saveAndContinueEdit() { editForm.submit($('edit_form').action+'back/edit/'); } " . (int) Mage::app()->getRequest()->getParam('homework_id');
    }

    public function getHeaderText() 
    {
        return $this->__('Homework Assignment: ' . Mage::registry('rowdata')->getTitle());
    }
    
	protected function _prepareLayout()
    {
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        return parent::_prepareLayout();
    }
}
