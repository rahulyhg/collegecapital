<?php
class GroupsController extends AppController {

	var $name = 'Groups';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->Group->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('Group'=>array('order' => array('Group.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('Group'=>array('order' => array('Group.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('Group'=>array('conditions' => array('Group.group LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('Group'=>array('conditions' => array('Group.group LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('groups', $this->paginate());
			$hasNoUsersItems = $this->Group->find('all', array('conditions'=> 'Group.id NOT IN (SELECT Users.group_id from users AS Users)'));
			$this->set('hasNoUsersItems',$hasNoUsersItems);
			$this->set('helpURL','users');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Network Groups');
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
			$this->flash(__('Invalid group', true), array('action' => 'index'));
			}
			$this->set('group', $this->Group->read(null, $id));
			$this->set('helpURL','users');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Network Groups');
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
				$this->Group->create();
				if ($this->Group->save($this->data)) {
					$this->flash(__('Group saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'user groups';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','users');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Group',
				$this->Group->validate,
				__('Save failed, fix the following errors:', true),
				'GroupAddForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Network Groups');
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
				$this->flash(sprintf(__('Invalid group', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->Group->save($this->data)) {
					$this->flash(__('The group has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Group->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'user groups';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','users');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Group',
				$this->Group->validate,
				__('Save failed, fix the following errors:', true),
				'GroupEditForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Network Groups');
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
				$this->flash(sprintf(__('Invalid group', true)), array('action' => 'index'));
			}
			if ($this->Group->delete($id)) {
				$this->flash(__('Group deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Group was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
