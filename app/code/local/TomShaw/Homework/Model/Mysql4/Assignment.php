<?php

class TomShaw_Homework_Model_Mysql4_Assignment extends Mage_Core_Model_Mysql4_Abstract 
{
    public function _construct()
    {
        $this->_init('homework/assignment', 'homework_id');
    }

    public function load(Mage_Core_Model_Abstract $object, $value, $field=null)
    {
        if (!intval($value) && is_string($value)) {
            $field = 'homework_id';
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
}
