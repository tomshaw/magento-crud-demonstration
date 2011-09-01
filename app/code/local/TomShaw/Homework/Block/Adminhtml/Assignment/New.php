<?php

class TomShaw_Homework_Block_Adminhtml_Assignment_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'homework';
        $this->_mode = 'new';
        $this->_controller = 'adminhtml_assignment';
		$this->_updateButton('save', 'label', Mage::helper('homework')->__('Save Assignment'));
    }

    public function getHeaderText()
    {
        return Mage::helper('homework')->__('Create Homework Assignment');
    }
    
	protected function _prepareLayout()
    {
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        return parent::_prepareLayout();
    }
}