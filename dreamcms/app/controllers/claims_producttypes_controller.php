<?php
class ClaimsProducttypesController extends AppController {

	var $name = 'ClaimsProducttypes';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->ClaimsProducttype->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('ClaimsProducttype'=>array('order' => array('ClaimsProducttype.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('ClaimsProducttype'=>array('order' => array('ClaimsProducttype.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('ClaimsProducttype'=>array('conditions' => array('ClaimsProducttype.productType LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('ClaimsProducttype'=>array('conditions' => array('ClaimsProducttype.productType LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('claimsProducttypes', $this->paginate());
			$hasNoClaimProducttypes = $this->ClaimsProducttype->find('all', array('conditions'=> 'ClaimsProducttype.id NOT IN (SELECT Claims.producttype_id from claims AS Claims)'));
			$this->set('hasNoClaimProducttypes',$hasNoClaimProducttypes);
			$this->set('helpURL','claims');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Product Types');
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
				$this->flash(__('Invalid transaction product type', true), array('action' => 'index'));
			}
			$this->set('ClaimsProducttype', $this->ClaimsProducttype->read(null, $id));
			$this->set('helpURL','claims');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Product Types');
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
				$this->ClaimsProducttype->create();
				if ($this->ClaimsProducttype->save($this->data)) {
					$this->flash(__('Transaction product type saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'transaction products type';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','claims');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClaimsProducttype',
				$this->ClaimsProducttype->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimsProducttypeAddForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Product Types');
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
				$this->flash(sprintf(__('Invalid transaction product type', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->ClaimsProducttype->save($this->data)) {
					$this->flash(__('The transaction product type has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->ClaimsProducttype->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'transaction products type';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','claims');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClaimsProducttype',
				$this->ClaimsProducttype->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimsProducttypeEditForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Product Types');
		$this->set('moduleAction','Edit');
		$this->set('manage', true);
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid transaction product type', true)), array('action' => 'index'));
			}
			if ($this->ClaimsProducttype->delete($id)) {
				$this->flash(__('Transaction product type deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Transaction product type was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
