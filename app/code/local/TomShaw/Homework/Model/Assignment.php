<?php

class TomShaw_Homework_Model_Assignment extends Mage_Core_Model_Abstract 
{   
	/**
	 * Status options.
	 */
    const STATUS_PENDING            	= 1;
    const STATUS_COMPLETED            	= 2;
    
	/**
	 * Priority options.
	 */
    const PRIORITY_HIGH            		= 3;
    const PRIORITY_MEDIUM           	= 2;
    const PRIORITY_LOW            		= 1;
    
    /**
     * Grades
     * @var array
     */
    protected $_grades = array('A','B','C','D','F');
    
    public function _construct()
    {
        $this->_init('homework/assignment');
    }
    
    public function load($id, $value = null, $field = null)
    {
        if (is_null($id) && $value && is_string($field)) {
            $this->_getResource()->load($this, $value, $field);
            return $this;
        }
        return parent::load($id, $field);
    }
    
    public function getStatusesOptions()
    {
        return array(
            self::STATUS_PENDING		=> Mage::helper('homework')->__('Pending'),
            self::STATUS_COMPLETED		=> Mage::helper('homework')->__('Completed'),
        );
    }
    
    public function getPrioritiesOptions()
    {
        return array(
            self::PRIORITY_HIGH			=> Mage::helper('homework')->__('High'),
            self::PRIORITY_MEDIUM		=> Mage::helper('homework')->__('Medium'),
            self::PRIORITY_LOW			=> Mage::helper('homework')->__('Low'),
        );
    }
    
    public function getGrades()
    {
    	return $this->_grades;
    }
}
