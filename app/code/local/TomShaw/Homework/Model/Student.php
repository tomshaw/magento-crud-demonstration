<?php

class TomShaw_Homework_Model_Student extends Mage_Core_Model_Abstract 
{
    public function _construct() 
    {
        $this->_init('homework/student');
    }
    
    public function load($id, $value = null, $field = null)
    {
        if (is_null($id) && $value && is_string($field)) {
            $this->_getResource()->load($this, $value, $field);
            return $this;
        }
        return parent::load($id, $field);
    }
}
