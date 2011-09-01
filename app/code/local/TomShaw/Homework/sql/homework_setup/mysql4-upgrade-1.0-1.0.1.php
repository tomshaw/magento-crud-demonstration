<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute('customer', 'is_student', array(
	'type'              => 'int',
	'backend'           => '',
	'frontend'          => '',
	'label'             => 'Company Student',
	'input'             => 'select',
	'class'             => '',
	'source'            => 'homework/customer_attribute_status',
	'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	'visible'           => true,
	'required'          => false,
	'user_defined'      => false,
	'default'           => '',
	'searchable'        => false,
	'filterable'        => false,
	'comparable'        => false,
	'visible_on_front'  => false,
    'unique'            => false
));

$attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'is_student');
$attribute->addData(array('sort_order'=>300));
$attribute->setData('used_in_forms', array('adminhtml_customer'));
$attribute->save();

$installer->endSetup();