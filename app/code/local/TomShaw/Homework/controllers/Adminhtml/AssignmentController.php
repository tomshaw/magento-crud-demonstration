<?php

class TomShaw_Homework_Adminhtml_AssignmentController extends Mage_Adminhtml_Controller_Action 
{    
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('homework/listing')
            ->_addBreadcrumb($this->__('Homework Assignments'), $this->__('Tom Shaw'))
            ->_title($this->__('Homework Assignments'))->_title($this->__('Tom Shaw'));
        return $this;
    }
    
    public function indexAction()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('homework/adminhtml_assignment_list'))
            ->renderLayout();
    }
    
    public function newAction()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('homework/adminhtml_assignment_new'))
            ->renderLayout();
    }
    
    public function createAction()
    {
    	$data = $this->getRequest()->getPost();
    	
        if (sizeof($data)) {
            try {
            	$model = Mage::getModel('homework/assignment')->setData($data);
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('homework')->__('Homework assignment was successfully created.'));
                $this->getResponse()->setRedirect($this->getUrl('*/*/'));
                return;
            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
        return;
    }
    
    public function editAction() 
    {        
		$id = $this->getRequest()->getParam('homework_id', false);
        
        if ($id) {
            $model = Mage::getModel('homework/assignment')->load((int)$id);
            if(sizeof($model->getData())) {
                Mage::register('rowdata', $model, true);
                $this->_initAction()
                	->_addContent($this->getLayout()->createBlock('homework/adminhtml_assignment_edit'))
                    ->_addLeft($this->getLayout()->createBlock('homework/adminhtml_assignment_edit_tabs'));
            } else {
                $this->_getSession()->addError($this->__('Could not locate homework assignment.'));
            }
        } else {
        	$this->getResponse()->setRedirect($this->getUrl('*/*/'));
        	return;
        }
        $this->renderLayout();
    }
    
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('homework_id', false);
        
        $studentIds = $this->getRequest()->getParam('students');
        
        $grades = $this->getRequest()->getParam('grade');

        if ($id) {
        	
            try {
            	
				$model = Mage::getModel('homework/assignment')->load((int)$id);
            	$model->addData($this->getRequest()->getPost());
                $model->save();
                
				foreach($this->_hasAssignment() as $_index => $value) {
					if(!in_array($value, $studentIds)) {
						Mage::getResourceModel('homework/student')->unassignStudent($id, $value);	
					}
				}
				
                foreach($studentIds as $_index => $value) {
                	if(in_array($value, $this->_hasAssignment())) {
                		continue;
                	}
                    $model = Mage::getModel('homework/student');
                    $model->addData(array('homework_id' => $id, 'customer_id' => $value));
                    $model->save();
                }
                
                array_shift($grades);
				foreach($studentIds as $_index => $value) {
                	if(in_array($value, $this->_hasAssignment())) {
                		if(isset($grades[$_index])) {
                			$studentGrade = $grades[$_index];            			
                			$student = Mage::getModel('homework/student')->load(null, $value, 'customer_id');
                    		$student->setGrade($studentGrade);
                    		$student->save();
                		}
                	}
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('homework')->__('Homework assignment was updated successfully.'));
            	
                if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('homework_id' => $id));
					return;
				}
                
				$this->getResponse()->setRedirect($this->getUrl('*/*/'));
                return;
            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirectReferer();
    }
    
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('homework_id', false);
     
        if ($id) {
	        try {
				Mage::getModel('homework/assignment')->load($id)->delete();
				$model = Mage::getModel('homework/student')->load(null, $id, 'homework_id');
				$studentCount = count($model->getData());
				$model->delete();
	            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('homework')->__('Assignment was successfully deleted'));
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('homework')->__(
                        'Assignment deleted, %d students(s) were successfully removed!', $studentCount
                    )
                );
	            $this->getResponse()->setRedirect($this->getUrl('*/*/'));
	            return;
	        } catch (Exception $e){
	            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	        }
        }
        $this->_redirectReferer();
    }
    
    public function massUpdateAction() 
    {
        $assignmentsIds = $this->getRequest()->getParam('assignment');
        
        $status = $this->getRequest()->getParam('status');
        
        if(!is_array($assignmentsIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach($assignmentsIds as $_index => $value) {
                    $model = Mage::getModel('homework/assignment')->load((int)$value);
                    $model->setStatus($status);
                    $model->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('homework')->__(
                        'Total of %d assignments(s) were successfully updated!', count($assignmentsIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massDeleteAction() 
    {
        $assignmentsIds = $this->getRequest()->getParam('assignment');
        if(!is_array($assignmentsIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select assignment item(s)'));
        } else {
            try {
                foreach($assignmentsIds as $key => $_value) {
                    Mage::getModel('homework/assignment')->load((int)$_value)->delete();
                	Mage::getModel('homework/student')->load(null, (int)$_value, 'homework_id')->delete();
            	}
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($assignmentsIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('homework/adminhtml_assignment_list_grid')->toHtml()
        );
    }
    
    public function gridGradesAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('homework/adminhtml_assignment_edit_tab_grades')->toHtml()
        );
    }
    
    public function gridAssignedAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('homework/adminhtml_assignment_edit_tab_assigned')->toHtml()
        );
    }

    public function exportCsvAction()
    {
        $fileName   = 'assignments.csv';
        $content    = $this->getLayout()->createBlock('homework/adminhtml_assignment_list_export')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'assignments.xml';
        $content    = $this->getLayout()->createBlock('homework/adminhtml_assignment_list_export')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    
    protected function _hasAssignment()
    {
    	$collection = Mage::getResourceModel('homework/student_collection')
    		->addFieldToFilter('homework_id', (int) Mage::app()->getRequest()->getParam('homework_id'));
    	$students = array();
    	foreach($collection as $data) {
    		$students[$data->getCustomerId()] = $data->getCustomerId();
    	}
    	if(sizeof($students)) {
    		return array_keys($students);
    	}
    	return array(0);
    }
}
