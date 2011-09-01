<?php

class TomShaw_Homework_Block_Adminhtml_Assignment_Edit_Tab_Assigned extends Mage_Adminhtml_Block_Widget_Grid 
{     
		
    public function __construct()
    {
        parent::__construct();
        $this->setId('assignedGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
        $this->setSaveParametersInSession(true);
        $this->setDefaultFilter(array('assigned_student'=>1));
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('group_id')
            ->addFieldToFilter('is_student', true)
            ->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
            ->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
            ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
            ->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
            ->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
		$this->addColumn('assigned_student', array(
			'header_css_class'	=> 'a-center', 
			'header'			=> Mage::helper('adminhtml')->__('Assigned'), 
			'type' 				=> 'checkbox', 
			//'html_name' 		=> 'customer_id',
			'field_name'        => 'students[]', 
			'values' 			=> $this->_getSelectedCustomers(), 
			'align' 			=> 'center', 
			'index' 			=> 'entity_id', 
			'filter_index' 		=> 'entity_id' 
		));
		
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

        $this->addColumn('Telephone', array(
            'header'    => Mage::helper('customer')->__('Telephone'),
            'width'     => '100',
            'index'     => 'billing_telephone'
        ));

        $this->addColumn('billing_postcode', array(
            'header'    => Mage::helper('customer')->__('ZIP'),
            'width'     => '90',
            'index'     => 'billing_postcode',
        ));

        $this->addColumn('billing_country_id', array(
            'header'    => Mage::helper('customer')->__('Country'),
            'width'     => '100',
            'type'      => 'country',
            'index'     => 'billing_country_id',
        ));

        $this->addColumn('billing_region', array(
            'header'    => Mage::helper('customer')->__('State/Province'),
            'width'     => '100',
            'index'     => 'billing_region',
        ));

        $this->addColumn('customer_since', array(
            'header'    => Mage::helper('customer')->__('Customer Since'),
            'type'      => 'datetime',
            'align'     => 'center',
            'index'     => 'created_at',
            'gmtoffset' => true
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
    
	protected function _addColumnFilterToCollection($column) 
	{
		if ($column->getId() == 'assigned_student') {
			$customerIds = $this->_getSelectedCustomers();
			if (empty($customerIds)) {
				$customerIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()
					->addFieldToFilter('entity_id', array('in' => $customerIds))
					->joinField('student', 'homework/student', 'customer_id', 'customer_id=entity_id', array('homework_id' => (int) Mage::app()->getRequest()->getParam('homework_id')), 'inner');
			} else {
				if ($customerIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin' => $customerIds));
				}
			}
		} else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}
	
	protected function _getSelectedCustomers() 
	{
    	$collection = Mage::getResourceModel('homework/student_collection')
    		->addFieldToFilter('homework_id', (int) Mage::app()->getRequest()->getParam('homework_id'));
    	$students = array();
    	foreach($collection as $data) {
    		$students[] = $data->getCustomerId();
    	}
    	return $students;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/gridAssigned', array('_current'=> true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/customer/edit/', array('id'=>$row->getId()));
    }
}
