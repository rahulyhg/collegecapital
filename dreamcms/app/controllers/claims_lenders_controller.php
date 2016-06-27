<?php
class ClaimsLendersController extends AppController {

	var $name = 'ClaimsLenders';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->ClaimsLender->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('ClaimsLender'=>array('order' => array('ClaimsLender.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('ClaimsLender'=>array('order' => array('ClaimsLender.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('ClaimsLender'=>array('conditions' => array('ClaimsLender.lender LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('ClaimsLender'=>array('conditions' => array('ClaimsLender.lender LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('claimsLenders', $this->paginate());
			$hasNoClaimLenders = $this->ClaimsLender->find('all', array('conditions'=> 'ClaimsLender.id NOT IN (SELECT Claims.lender_id from claims AS Claims)'));
			$this->set('hasNoClaimLenders',$hasNoClaimLenders);
			$this->set('helpURL','claims');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Lenders');
		$this->set('moduleAction','Manage');
		$this->set('manage', true);
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid transaction lender', true), array('action' => 'index'));
			}
			$this->set('ClaimsLender', $this->ClaimsLender->read(null, $id));
			$this->set('helpURL','claims');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Lenders');
		$this->set('moduleAction','Preview');
		$this->set('manage', true);
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!empty($this->data)) {				
				$this->ClaimsLender->create();
				if ($this->ClaimsLender->save($this->data)) {
					$this->flash(__('Transaction lender saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'transaction lenders';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','claims');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClaimsLender',
				$this->ClaimsLender->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimsLenderAddForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Lenders');
		$this->set('moduleAction','Add');
		$this->set('manage', true);
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid transaction lender', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				//******************************************************			
		        // CHANGE REQUEST: Nyree 10/6/14 
		        //******************************************************
				$this->data['ClaimsLender']['changeUser'] = $_SESSION['Auth']['User']['id'];
				$this->data['ClaimsLender']['changeDate'] = date("Y-m-d H:i:s");				
  	  	        //******************************************************				
				if ($this->ClaimsLender->save($this->data)) {				   					
					$this->flash(__('The transaction lender has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->ClaimsLender->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'transaction lenders';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','claims');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClaimsLender',
				$this->ClaimsLender->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimsLenderEditForm'
			);
		}		
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Lenders');
		$this->set('moduleAction','Edit');
		$this->set('manage', true);
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
		
		//******************************************************			
		// CHANGE REQUEST: Nyree 10/6/14 
		//******************************************************
		if ($this->data['ClaimsLender']['changeUser'] != "")  {
		   $this->loadModel('Users');
		   $changeUserName = $this->Users->find('all',array('conditions' => array('Users.id' => $this->data['ClaimsLender']['changeUser'])));
		   $this->set('changeUserName',$changeUserName);
		}
	    //******************************************************
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid transaction lender', true)), array('action' => 'index'));
			}
			if ($this->ClaimsLender->delete($id)) {
				$this->flash(__('Transaction lender deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Transaction lender was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
