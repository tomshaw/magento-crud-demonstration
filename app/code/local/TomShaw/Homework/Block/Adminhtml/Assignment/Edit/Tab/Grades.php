<?php

class TomShaw_Homework_Block_Adminhtml_Assignment_Edit_Tab_Grades extends Mage_Adminhtml_Block_Widget_Grid 
{     
		
    public function __construct()
    {
        parent::__construct();
        $this->setId('gradesGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('group_id')
            ->addFieldToFilter('is_student', true)
            //->addFieldToFilter('entity_id', array('in' => $this->_hasAssignment()))
            ->joinField('grade', 'homework/student', 'grade', 'customer_id=entity_id', array('homework_id' => (int) Mage::app()->getRequest()->getParam('homework_id')), 'inner');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('customer')->__('ID'),
            'width'     => '50px',
            'index'     => 'entity_id',
            'type'  	=> 'number',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('customer')->__('Name'),
            'index'     => 'name'
        ));
        $this->addColumn('email', array(
            'header'    => Mage::helper('customer')->__('Email'),
            'width'     => '150',
            'index'     => 'email'
        ));

        $groups = Mage::getResourceModel('customer/group_collection')
            ->addFieldToFilter('customer_group_id', array('gt'=> 0))
            ->load()
            ->toOptionHash();

        $this->addColumn('group', array(
            'header'    =>  Mage::helper('customer')->__('Group'),
            'width'     =>  '100',
            'index'     =>  'group_id',
            'type'      =>  'options',
            'options'   =>  $groups,
        ));

        $this->addColumn('grade[]', array(
            'header'    => Mage::helper('customer')->__('Grade'),
            'width'     => '100',
        	'type'		=> 'input',
            'index'     => 'grade'
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('website_id', array(
                'header'    => Mage::helper('customer')->__('Website'),
                'align'     => 'center',
                'width'     => '80px',
                'type'      => 'options',
                'options'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(true),
                'index'     => 'website_id',
            ));
        }

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/gridGrades', array('_current'=> true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/customer/edit/', array('id'=>$row->getId()));
    }
}
