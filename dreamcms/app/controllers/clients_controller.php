<?php
class ClientsController extends AppController {

	var $name = 'Clients';
	var $components = array('JQValidator.JQValidator','Email');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator');   
		
	function beforeFilter() {        
		parent::beforeFilter();        
		$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'display', 'home');    
	}
	
	//set the page limit. note: this is the total maximum records that you want to pull out of the DB
	public $paginate = array(
		'limit' => 10000,
		'order' => array(            
			'Client.id' => 'asc'        
		)    
	);
	
	function findTotalRecords(){
		return $this->Client->find('count'); 
	}
	
	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->set('title_for_layout', 'Active Contacts'); 
			$recordCount = $this->Client->find('count');
			$this->Client->recursive = 0;
			
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('Client'=>array('order' => array('Client.id' => 'ASC'),'limit'=>$recordCount)));
				} else {
					//find total count of records
					$recordCount = $this->Client->find('count',array('conditions' => array('Client.name LIKE' => ''.trim($_GET['sel']).'%')));
					$this->paginate = Set::merge($this->paginate,array('Client'=>array('conditions' => array('Client.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>$recordCount)));
				}
			} elseif(isset($_GET['group'])){
				if((int)trim($_GET['group'])>0){
					$recordCount = $this->Client->find('count',array('conditions' => array('Client.category_id =' => (int)trim($_GET['group']))));
					$this->paginate = Set::merge($this->paginate,array('Client'=>array('conditions' => array('Client.category_id =' => (int)trim($_GET['group'])),'order' => array('Client.companyName' => 'ASC'), 'limit'=>$recordCount)));
				}
			} elseif(isset($_GET['search'])){
				//find total count of records
				$recordCount = $this->Client->find('count',array('conditions' => array('Client.name LIKE' => '%'.trim($_GET['search']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Client'=>array('conditions' => array('Client.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>$recordCount)));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Client'=>array('order' => array('Client.companyName' => 'ASC'),'limit'=>$recordCount)));
			}
			$this->set('clients', $this->paginate());
			$pageLimit = 20;
			$this->set('pageLimit',$pageLimit);
			
			$this->loadModel('ClientsCategory'); //if it's not already loaded
			$options = $this->ClientsCategory->find('all', array('order' => 'ClientsCategory.category ASC')); //or whatever conditions you want
			$this->set('options',$options);
			$moduleHeading = 'Contacts';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Manage');
			$this->set('helpURL','contacts');
					
			//layout options
			$this->set('page','contacts');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function view($id = null) {		
		if($_SESSION['Auth']['User']['group_id']==4){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$orderBy = "Client.name";
				if (isset($_GET['order'])) {
				   $orderBy = "Client." . $_GET['order'];
				}
				
				if(isset($_GET['group']) && (int)trim($_GET['group'])>0){
					$this->set('client', $this->Client->find('all',array('conditions' => array('Client.category_id =' => (int)trim($_GET['group']), 'Client.status_id' => 1),'order' => $orderBy)));
				} elseif(isset($_GET['search'])){
					//find total count of records
					$recordCount = $this->Client->find('count',array('conditions' => array('Client.name LIKE' => '%'.trim($_GET['search']).'%')));
					//$this->paginate = Set::merge($this->paginate,array('Client'=>array('conditions' => array('Client.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>$recordCount)));
					$this->set('client', $this->Client->find('all', array('conditions' => array('OR' => array('Client.name LIKE' => '%'.trim($_GET['search']).'%', 'Client.surname LIKE' => '%'.trim($_GET['search']).'%', 'Client.companyName LIKE' => '%'.trim($_GET['search']).'%')),'limit'=>$recordCount)));
				} else {
					$this->set('client', $this->Client->find('all',array('order' => $orderBy, 'conditions' => array('Client.status_id' => 1))));
				}
				
				$this->set('clientList', true);
				$pageLimit = 50; //no. of News items to display
				$this->set('pageLimit',$pageLimit);	
				
				//for links category drop down with values that has associated links
				$fields = array('DISTINCT ClientsCategory.category', 'Client.id');
				$conditions = ' ';
				$joins = array(
					array(
						'table' => 'clients', 
						'alias' => 'Client', 
						'type' => 'RIGHT', 
						'conditions' => array('Client.category_id = ClientsCategory.id')
					)
				);                                                                                                        
				$joinContactArray = array('fields' => $fields, 'conditions' => $conditions, 'joins' => $joins);            
				$this->loadModel('ClientsCategory'); //if it's not already loaded
				$options = $this->ClientsCategory->find('all', $joinContactArray);
				$this->set('options', $options);		
			} else {
				$clientDetails = $this->Client->read(null, $id);
				$this->set('client', $clientDetails);
				$this->loadModel('Tblstate'); //if it's not already loaded
				$streetState = $this->Tblstate->find('first', array('fields' => array('State'), 'conditions' => array('Tblstate.id' => $clientDetails['Client']['street_state_id']))); //or whatever conditions you want
				$this->set('streetState', $streetState);
				$postalState = $this->Tblstate->find('first', array('fields' => array('State'), 'conditions' => array('Tblstate.id' => $clientDetails['Client']['postal_state_id']))); //or whatever conditions you want
				$this->set('postalState', $postalState);
				
				$this->set('clientList', false);
			}
			$moduleHeading = 'Contacts';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','View');
			$this->set('helpURL','contacts');
					
			//layout options
			$this->set('page','contacts');
			$this->set('overview', true);
			if($_SESSION['Auth']['User']['group_id']==1){			
				$this->set('manage', true);	
			}
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}
	
	function preview($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid contact', true), array('action' => 'index'));	
			} 
			$this->set('client', $this->Client->read(null, $id));
			$contactDetails = $this->Client->read(null, $id);
			$this->loadModel('Tblstate'); //if it's not already loaded
			$streetState = $this->Tblstate->find('first', array('fields' => array('State'), 'conditions' => array('Tblstate.id' => $contactDetails['Client']['street_state_id']))); //or whatever conditions you want
			$this->set('streetState', $streetState);
			$postalState = $this->Tblstate->find('first', array('fields' => array('State'), 'conditions' => array('Tblstate.id' => $contactDetails['Client']['postal_state_id']))); //or whatever conditions you want
			$this->set('postalState', $postalState);
			
			$moduleHeading = 'Contact';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Preview');
			$this->set('helpURL','contacts');
					
			//layout options
			$this->set('page','contacts');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function add() {		
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->set('title_for_layout', 'Add New Contacts');
			if (!empty($this->data)) {
				$this->Client->create();
				if ($this->Client->save($this->data)) {
					$this->flash(__('Contact saved.', true), array('action' => 'index'));
				} else {
				}
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.url').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$this->loadModel('ClientsCategory'); //if it's not already loaded
			$options = $this->ClientsCategory->find('all', array('order' => 'ClientsCategory.category ASC'));
			$this->set('options',$options);
			$this->loadModel('UserStatuses'); //if it's not already loaded
			$us_options = $this->UserStatuses->find('all'); //or whatever conditions you want
			$this->set('us_options',$us_options);
			$this->loadModel('Tblstate'); //if it's not already loaded
			$stateOptions = $this->Tblstate->find('all'); //or whatever conditions you want
			$this->set('stateOptions',$stateOptions);
			$moduleHeading = 'Client';			
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Add');
			$this->set('helpURL','contacts');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Client',
				$this->Client->validate,
				__('Save failed, fix the following errors:', true),
				'ClientAddForm'
			);
					
			//layout options
			$this->set('page','contacts');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->set('title_for_layout', 'Edit Contacts');
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid contact', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->Client->save($this->data)) {
					$this->flash(__('The contact has been saved.', true), array('action' => 'index'));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Client->read(null, $id);
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.url').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$this->loadModel('ClientsCategory'); //if it's not already loaded
			$options = $this->ClientsCategory->find('all', array('order' => array('category ASC'))); //or whatever conditions you want
			$this->set('options',$options);
			$this->loadModel('UserStatuses'); //if it's not already loaded
			$us_options = $this->UserStatuses->find('all'); //or whatever conditions you want
			$this->set('us_options',$us_options);
			$this->loadModel('Tblstate'); //if it's not already loaded
			$stateOptions = $this->Tblstate->find('all'); //or whatever conditions you want
			$this->set('stateOptions',$stateOptions);
			$moduleHeading = 'Contact';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Edit');
			$this->set('helpURL','contacts');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Client',
				$this->Client->validate,
				__('Save failed, fix the following errors:', true),
				'ClientEditForm'
			);
			
			//layout options
			$this->set('page','contacts');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid contact', true)), array('action' => 'index'));
			}
			if ($this->Client->delete($id)) {
				$this->flash(__('Contact deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Contact was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function deletefile($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($this->Client->saveField('logo','')){
			//we have successfully deleted file from DB
			$this->redirect(array('action' => 'edit/'.$id));
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
	
	function publish($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid contact', true)), array('action' => 'index'));
			}
			if ($this->Client->saveField('status_id',1,false)) {
				$this->flash(__('Contact now active', true), array('action' => 'index'));
			}
			$this->flash(__('There were some issues. Please try again.', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function unpublish($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid contact', true)), array('action' => 'index'));
			}
			if ($this->Client->saveField('status_id',0,false)) {
				$this->flash(__('Contact now inactive', true), array('action' => 'index'));
			}
			$this->flash(__('There were some issues. Please try again.', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
