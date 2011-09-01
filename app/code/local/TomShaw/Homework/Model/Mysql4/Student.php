<?php

class TomShaw_Homework_Model_Mysql4_Student extends Mage_Core_Model_Mysql4_Abstract 
{
    public function _construct()
    {
        $this->_init('homework/student', 'student_id');
    }
    
    public function load(Mage_Core_Model_Abstract $object, $value, $field = null)
    {
        if (!intval($value) && is_string($value)) {
            $field = 'student_id';
        }
        return parent::load($object, $value, $field);
    }
    
    protected function _beforeSave(Mage_Core_Model_Abstract $model)
    {
        if (!$model->getId() ) {
            $model->setCreatedAt(now());
        }
        $model->setUpdatedAt(now());
        return $this;
    }
    
    public function unassignStudent($homeworkId, $studentId)
    {	
        $condition = $this->_getWriteAdapter()->quoteInto('homework_id = ?', $homeworkId);
        $condition .= ' AND ' . $this->_getWriteAdapter()->quoteInto('customer_id = ?', $studentId);
        $this->_getWriteAdapter()->delete($this->getMainTable(), $condition);
        return $this;
    }
}
