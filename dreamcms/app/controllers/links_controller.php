<?php
class LinksController extends AppController {

	var $name = 'Links';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript','Ajax', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'links','action'=>'view'));	
		} else {
			$this->Link->recursive = 0;
			$sortable = false; //disable sorting by default
			$recordCount = $this->Link->find('count');
			if(isset($_GET['sort_list']) && trim($_GET['sort_list']=='true')) {//sorting enabled
				$sortable = true;
				$this->paginate = Set::merge($this->paginate,array('Link'=>array('order' => array('Link.position' => 'ASC'),'limit'=>$recordCount)));
			} elseif(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('Link'=>array('order' => array('Link.position' => 'ASC'),'limit'=>$recordCount)));
				} else {
					//find total count of records
					$recordCount = $this->Link->find('count',array('conditions' => array('Link.name LIKE' => ''.trim($_GET['sel']).'%')));
					$this->paginate = Set::merge($this->paginate,array('Link'=>array('conditions' => array('Link.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>$recordCount)));
				}
			} elseif(isset($_GET['group'])){
				if((int)trim($_GET['group'])>0){
					$recordCount = $this->Link->find('count',array('conditions' => array('Link.category_id =' => (int)trim($_GET['group']))));
					$this->paginate = Set::merge($this->paginate,array('Link'=>array('conditions' => array('Link.category_id =' => (int)trim($_GET['group'])),'limit'=>$recordCount)));
				}
			} elseif(isset($_GET['search'])){
				//find total count of records
				$recordCount = $this->Link->find('count',array('conditions' => array('Link.name LIKE' => '%'.trim($_GET['search']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Link'=>array('conditions' => array('Link.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>$recordCount)));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Link'=>array('order' => array('Link.position' => 'ASC'),'limit'=>$recordCount)));
			}
			$this->set('links', $this->paginate());
			$this->set('instructionText','You can drag and drop the items below to set the order.');
			$this->set('orderStatus', 'Links Ordering Succesfully Saved!');
			$this->set('sortable',$sortable);
			$pageLimit = 50;
			$this->set('pageLimit',$pageLimit);
			$this->loadModel('LinksCategory'); //if it's not already loaded
			$options = $this->LinksCategory->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$this->set('helpURL','links');
			//layout options
			$moduleHeading = 'Links';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Manage');
			$this->set('page','links');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==4){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay'));	
		} else {
			if (!$id) {
				//echo 'News items to go here';
				if(isset($_GET['group']) && (int)trim($_GET['group'])>0){
					$this->set('link', $this->Link->find('all',array('conditions' => array('Link.live = 1', 'Link.category_id =' => (int)trim($_GET['group'])))));
				} else {
					$this->set('link', $this->Link->find('all',array('conditions' => array('Link.live = 1'))));
				}
				
				$this->set('linkList', true);
				$pageLimit = 4; //no. of News items to display
				$this->set('pageLimit',$pageLimit);	
				
				//for links category drop down with values that has associated links
				$fields = array('DISTINCT LinksCategory.category', 'LinksCategory.id');
				$conditions = array('Links.live = 1');
				$joins = array(
					array(
						'table' => 'links', 
						'alias' => 'Links', 
						'type' => 'RIGHT', 
						'conditions' => array('Links.category_id = LinksCategory.id')
					)
				);                                                                                                        
				$joinLinkArray = array('fields' => $fields, 'conditions' => $conditions, 'joins' => $joins);            
				$this->loadModel('LinksCategory'); //if it's not already loaded
				$options = $this->LinksCategory->find('all', $joinLinkArray);
				$this->set('options', $options);		
			} else {
				$this->set('link', $this->Link->read(null, $id));
				$this->set('linkList', false);
			}
		}
		$moduleHeading = 'Links';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('moduleAction','View');
		$this->set('helpURL','links');
				
		//layout options
		$this->set('page','links');
		$this->set('overview', true);
		if($_SESSION['Auth']['User']['group_id']==1){
			$this->set('manage', true);
		}
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
	}
	
	function preview($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'links','action'=>'view'));	
		} else {
			if (!$id) {
				$this->flash(__('Invalid Link', true), array('action' => 'index'));	
			} 
			$this->set('link', $this->Link->read(null, $id));
			$moduleHeading = 'Links';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Preview');
			$this->set('helpURL','link');
					
			//layout options
			$this->set('page','link');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'links','action'=>'view'));	
		} else {
			if (!empty($this->data)) {
				$this->Link->create();			
				if ($this->Link->save($this->data)) {
					$this->flash(__('Link saved.', true), array('action' => 'index'));
				} else {
				}
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.url').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$this->loadModel('LinksCategory'); //if it's not already loaded
			$options = $this->LinksCategory->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$moduleHeading = 'Links';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Add');
			$this->set('maxPosition',$this->Link->find('count'));
			$this->set('helpURL','links');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Link',
				$this->Link->validate,
				__('Save failed, fix the following errors:', true),
				'LinkAddForm'
			);
			//layout options
			$this->set('page','links');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'links','action'=>'view'));	
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid Link', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->Link->save($this->data)) {				
					//$this->loadModel('Upload'); //if it's not already loaded
					//$this->Upload->save($this->data['Link']['photo']);
					$this->flash(__('The Link has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Link->read(null, $id);
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.url').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$this->loadModel('LinksCategory'); //if it's not already loaded
			$options = $this->LinksCategory->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$moduleHeading = 'Links';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Edit');
			$this->set('helpURL','links');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Link',
				$this->Link->validate,
				__('Save failed, fix the following errors:', true),
				'LinkEditForm'
			);
			//layout options
			$this->set('page','links');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'links','action'=>'view'));	
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid Link', true)), array('action' => 'index'));
			}
			if ($this->Link->delete($id)) {
				$this->flash(__('Link deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Link was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function publish($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'links','action'=>'view'));	
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid Link Member', true)), array('action' => 'index'));
			}
			if ($this->Link->saveField('live',1,false)) {
				$this->flash(__('Link Member published', true), array('action' => 'index'));
			}
			$this->flash(__('Link Member was not published', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function unpublish($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'links','action'=>'view'));	
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid Link Member', true)), array('action' => 'index'));
			}
			if ($this->Link->saveField('live',0,false)) {
				$this->flash(__('Link Member unpublished', true), array('action' => 'index'));
			}
			$this->flash(__('Link Member was not unpublished', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['links'] as $order => $id){
			$data['Link']['position'] = $order;
			$this->Link->id = $id;
			if($this->Link->saveField('position',$order)) {
				//we have success!
			} else {
				//deal with possible errors!
			}
		}
		$this->autoRender=false;
	}
	
	function deletefile($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($this->Link->saveField('logo','')){
			//we have successfully deleted file from DB
			$this->redirect(array('action' => 'edit/'.$id));
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
}
