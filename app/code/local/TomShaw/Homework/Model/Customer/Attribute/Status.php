<?php

class TomShaw_Homework_Model_Customer_Attribute_Status extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{	
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
                array(
                    'label' => Mage::helper('homework')->__('Is Student'),
                    'value' =>  1
                ),
                array(
                    'label' => Mage::helper('homework')->__('Is Not Student'),
                    'value' =>  0
                ),
            );
        }
        return $this->_options;
    }
}