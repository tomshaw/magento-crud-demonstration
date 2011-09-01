<?php

class TomShaw_Homework_Block_Adminhtml_Assignment_List extends Mage_Adminhtml_Block_Widget_Grid_Container 
{
    public function __construct() 
    {
        $this->_controller = 'adminhtml_assignment_list';
        $this->_blockGroup = 'homework';
        $this->_headerText = $this->__('Homework Assignment Listings');
        parent::__construct();
    } 
}
