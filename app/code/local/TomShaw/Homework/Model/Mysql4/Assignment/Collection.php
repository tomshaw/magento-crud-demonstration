<?php

class TomShaw_Homework_Model_Mysql4_Assignment_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract 
{
    public function _construct() 
    {
        parent::_construct();
        $this->_init('homework/assignment');
    }
 
    public function getSelectCountSql() 
    {
        $this->_renderFilters();
        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $countSelect->reset(Zend_Db_Select::COLUMNS);
        $countSelect->reset(Zend_Db_Select::GROUP);
        $countSelect->reset(Zend_Db_Select::HAVING);
        $countSelect->from('', 'COUNT(*)');
        return $countSelect;
    }  
}