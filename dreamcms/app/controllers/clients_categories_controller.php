<?php
class ClientsCategoriesController extends AppController {

	var $name = 'ClientsCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->ClientsCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('ClientsCategory'=>array('order' => array('ClientsCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('ClientsCategory'=>array('order' => array('ClientsCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('ClientsCategory'=>array('conditions' => array('ClientsCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('ClientsCategory'=>array('conditions' => array('ClientsCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('clientsCategories', $this->paginate());
			$hasNoClientItems = $this->ClientsCategory->find('all', array('conditions'=> 'ClientsCategory.id NOT IN (SELECT Clients.category_id from clients AS Clients)'));
			$this->set('hasNoClientItems',$hasNoClientItems);
			$this->set('helpURL','contacts');
		}
		//layout options
		$this->set('page', 'contacts');
		$this->set('moduleHeading','Contact Categories');
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
				$this->flash(__('Invalid contacts category', true), array('action' => 'index'));
			}
			$this->set('ClientsCategory', $this->ClientsCategory->read(null, $id));
			$this->set('helpURL','contacts');
		}
		//layout options
		$this->set('page', 'contacts');
		$this->set('moduleHeading','Contact Categories');
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
				$this->ClientsCategory->create();
				if ($this->ClientsCategory->save($this->data)) {
					$this->flash(__('Contacts Category saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'contact categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','contacts');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClientsCategory',
				$this->ClientsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'ClientsCategoryAddForm'
			);
		}
		//layout options
		$this->set('page', 'contacts');
		$this->set('moduleHeading','Contact Categories');
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
				$this->flash(sprintf(__('Invalid contacts category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->ClientsCategory->save($this->data)) {
					$this->flash(__('The contacts category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->ClientsCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'contact categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','contacts');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClientsCategory',
				$this->ClientsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'ClientsCategoryEditForm'
			);
		}
		//layout options
		$this->set('page', 'contacts');
		$this->set('moduleHeading','Contact Categories');
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
				$this->flash(sprintf(__('Invalid contacts category', true)), array('action' => 'index'));
			}
			if ($this->ClientsCategory->delete($id)) {
				$this->flash(__('Contacts category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Contacts category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
