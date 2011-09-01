<?php
/**
 * Creates tab in catalog product and places employee attribute in it.
 * 
 */

//$installer = $this;
//
//$installer->startSetup();
//
//$installer->addAttribute('catalog_product', 'employee', array(
//	'type'              => 'int',
//	'backend'           => '',
//	'group'          	=> 'Additional',
//	'frontend'          => '',
//	'label'             => 'Employee Status',
//	'input'             => 'select',
//	'class'             => '',
//	'source'            => 'boilerplate/customer_attribute_status',
//	'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
//	'visible'           => true,
//	'required'          => false,
//	'user_defined'      => false,
//	'default'           => '',
//	'searchable'        => false,
//	'filterable'        => false,
//	'comparable'        => false,
//	'visible_on_front'  => false,
//    'unique'            => false
//));
//
//$attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'employee');
//$attribute->addData(array('sort_order'=>50));
//$attribute->setData('used_in_forms', array('adminhtml_customer'));
//$attribute->save();
//
//$entityTypeId = $installer->getEntityTypeId('catalog_product');
//$attributeId  = $installer->getAttributeId('catalog_product', 'employee');
//
//$attributeSets = $installer->_conn->fetchAll('select * from '.$this->getTable('eav/attribute_set').' where entity_type_id=?', $entityTypeId);
//foreach ($attributeSets as $attributeSet) {
//    $setId = $attributeSet['attribute_set_id'];
//    $installer->addAttributeGroup($entityTypeId, $setId, 'Additional');
//    $groupId = $installer->getAttributeGroupId($entityTypeId, $setId, 'Additional');
//    $installer->addAttributeToGroup($entityTypeId, $setId, $groupId, $attributeId);
//}
//
//$installer->endSetup();