<?php
class VbisSettingsController extends AppController {

	var $name = 'VbisSettings';
	var $components = array('JQValidator.JQValidator','RSS');
	var $helpers = array('Form', 'Html', 'Javascript', 'Time', 'FormatEpochToDate', 'CustomDisplayFunctions','JQValidator.JQValidator');
	
	function index() {		
		$this->loadModel('Users');
		$this->Vbi->recursive = 0;		

		$recordCount = $this->VbisSetting->find('all',array('order'=>'key'));				
		$this->set('settings', $this->paginate());					
			
		$pageLimit = 50;				
		$this->set('pageLimit',$pageLimit);
		
		$moduleHeading = "VBI";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('moduleAction','Manage VBI Settings');
		$this->set('helpURL','Vbi');	
		
		$reporting = true;
		$this->set('reportingVBIStructure', $reporting);
		$this->set('reportingVBISplit', $reporting);
		$this->set('reportingVBIBreakUp', $reporting);
		$this->set('reportingVBIGraph', $reporting);
			
		//layout options
		$this->set('manageVBIStructure', true);
		$this->set('manageVBISplit', true);
		$this->set('manageVBISetting', true);
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
	}

	function add() {			
		if ($_SESSION['Auth']['User']['group_id'] < 4) { //all but banks			
		   if (!empty($this->data)) {								
			  $this->VbisSetting->create();								
			
			  if ($this->VbisSetting->save($this->data)) {	
			     $this->flash(__('VBI Setting saved.', true), array('action' => 'index'));									
			  } else {								
			  }
			}
			
			$this->layout='add-edit';									            
			
			$moduleHeading = 'VBI Setting';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Add');
			$this->set('helpURL','Vbi');	
			
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);	
			
			$this->JQValidator->addValidation
			(
				'Vbi',
				$this->VbisSetting->validate,
				__('Save failed, fix the following errors:', true),
				'VbiAddForm'
			);
		} else {
			//redirect shareholders and banks to home page
			$this->redirect(array('controller'=>'Vbis','action'=>'homedisplay','home'));	
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==4){ //admin and brokers only	
			//redirect banks to home page
			$this->redirect(array('controller'=>'Vbis','action'=>'homedisplay','home'));	
		} else {
			if (!$id && empty($this->data)) {			    
				$this->flash(sprintf(__('Invalid VBI Setting', true)), array('action' => 'index'));			
			}
			if (!empty($this->data)) {
				if ($this->VbisSetting->save($this->data)) {				   			   										
				   $this->flash(__('The VBI Setting has been saved.', true), array('action' => 'index'));					
				}
			}
			if (empty($this->data)) {
				$this->data = $this->VbisSetting->read(null, $id);				
			}
			$this->layout='add-edit';            
			
			$moduleHeading = 'VBI Setting';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Edit');
			$this->set('helpURL','Vbi');

			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);		

			$this->JQValidator->addValidation
			(
				'Vbi',
				$this->VbisSetting->validate,
				__('Save failed, fix the following errors:', true),
				'VbiEditForm'
			);	
		}
	}	
		
	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==1 || $_SESSION['Auth']['User']['group_id']==2) {
			if (!$id) {
				$this->flash(sprintf(__('Invalid VBI Setting', true)), array('action' => 'index'));
			}
			if ($this->VbisSetting->delete($id)) {
				$this->flash(__('VBI Setting deleted', true), array('action' => 'index'));
			}
			$this->flash(__('VBI Setting was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->redirect(array('controller'=>'Vbis','action'=>'index'));	
		}
	}		
}
?>