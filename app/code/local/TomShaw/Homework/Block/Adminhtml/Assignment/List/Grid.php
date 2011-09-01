<?php

class TomShaw_Homework_Block_Adminhtml_Assignment_List_Grid extends Mage_Adminhtml_Block_Widget_Grid 
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('assignmentsGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('homework_id');
        $this->setSaveParametersInSession(true);
    }
    
    protected function _prepareCollection() 
    {
    	$collection = Mage::getModel('homework/assignment')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() 
    { 
        $this->addColumn('homework_id', array(
			'header'	=> Mage::helper('homework')->__('ID'),
			'width' 	=> '50px',
			'type'  	=> 'number',
			'index' 	=> 'homework_id',
        ));
        
        $this->addColumn('title', array(
            'header'        => Mage::helper('homework')->__('Assignment Title'),
            'align'         => 'left',
            'width'         => '300px',
            'index'         => 'title',
        ));
        
        $this->addColumn('status', array(
            'header'        => Mage::helper('homework')->__('Status'),
            'align'         => 'left',
        	'width'         => '50px',
            'index'         => 'status',
            'type'          => 'options',
            'options'       => Mage::getSingleton('homework/assignment')->getStatusesOptions(),
            'escape'        => false,
        ));
        
        $this->addColumn('priority', array(
            'header'        => Mage::helper('homework')->__('Priority'),
            'align'         => 'left',
        	'width'         => '50px',
            'index'         => 'priority',
            'type'          => 'options',
            'options'       => Mage::getSingleton('homework/assignment')->getPrioritiesOptions(),
            'escape'        => false,
        ));
        
        $this->addColumn('created_at', array(
            'header'    	=> Mage::helper('homework')->__('Created'),
            'align'         => 'left',
        	'width'         => '75px',
            'index'    	 	=> 'created_at',
        	'type'			=> 'datetime'
        ));
        
        $this->addColumn('updated_at', array(
            'header'    	=> Mage::helper('homework')->__('Updated'),
            'align'         => 'left',
        	'width'         => '75px',
            'index'    	 	=> 'updated_at',
        	'type'			=> 'datetime'
        ));
        
        $this->addColumn('due_at', array(
            'header'    	=> Mage::helper('homework')->__('Due'),
            'align'         => 'left',
        	'width'         => '75px',
            'index'    	 	=> 'due_at',
        	'type'			=> 'date'
        ));

		$this->addColumn('action',
            array(
                'header'    => Mage::helper('homework')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'	=> 'getHomeworkId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('homework')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit'
                         ),
                         'field'   => 'homework_id'
                    ),
                    array(
                        'caption' => Mage::helper('homework')->__('Delete'),
                        'url'     => array(
                            'base'=>'*/*/delete'
                         ),
                         'field'   => 'homework_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false
        ));
        
        $this->addExportType('*/*/exportCsv', Mage::helper('tag')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('tag')->__('XML'));
 
        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('homework_id');
        $this->getMassactionBlock()->setFormFieldName('assignment');
        
        //$this->setMassactionIdFieldOnlyIndexValue(true);
        //$this->getMassactionBlock()->setUseSelectAll(false);

        $statuses = Mage::getSingleton('homework/assignment')->getStatusesOptions();
        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('catalog')->__('Change status'),
             'url'  => $this->getUrl('*/*/massUpdate', array('_current'=>true)),
             'additional' => array(
				'visibility' => array(
					'name' => 'status',
					'type' => 'select',
					'class' => 'required-entry',
					'label' => Mage::helper('catalog')->__('Status'),
					'values' => $statuses
        		)
             )
        ));
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('homework')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('homework')->__('Are you sure?')
        ));
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=> true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('homework_id'=>$row->getHomeworkId()));
    }
}
