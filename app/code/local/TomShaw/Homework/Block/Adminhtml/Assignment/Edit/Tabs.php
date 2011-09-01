<?php

class TomShaw_Homework_Block_Adminhtml_Assignment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs 
{
    public function __construct() 
    {
        parent::__construct();
        $this->setId('assignment_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Assignment Information'));
    }

    protected function _beforeToHtml() 
    {
        $this->addTab('homework_details', array(
            'label' => $this->__('Homework Details'),
            'title' => $this->__('Homework Details'),
            'content' => $this->getLayout()->createBlock('homework/adminhtml_assignment_edit_tab_information')->toHtml()
        ));

        $this->addTab('system_students', array(
            'label' => $this->__('Current Students'),
            'title' => $this->__('Current Students'),
            'content' => $this->getLayout()->createBlock('homework/adminhtml_assignment_edit_tab_assigned')->toHtml()
        ));
        
        $this->addTab('student_grades', array(
            'label' => $this->__('Grades'),
            'title' => $this->__('Grades'),
            'content' => $this->getLayout()->createBlock('homework/adminhtml_assignment_edit_tab_grades')->toHtml()
        ));

        return parent::_beforeToHtml();
    }
}
