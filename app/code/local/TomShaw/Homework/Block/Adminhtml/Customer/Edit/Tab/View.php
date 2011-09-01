<?php

class TomShaw_Homework_Block_Adminhtml_Customer_Edit_Tab_View
 extends Mage_Adminhtml_Block_Template
 implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('homework_information');
    }

    /**
     * ######################## TAB settings #################################
     */
    public function getTabLabel()
    {
        return Mage::helper('catalog')->__('Homework Information');
    }

    public function getTabTitle()
    {
        return Mage::helper('catalog')->__('Homework Information');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}

