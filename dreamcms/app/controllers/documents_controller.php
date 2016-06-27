<?php
class DocumentsController extends AppController {

	var $name = 'Documents';
	var $components = array('JQValidator.JQValidator','RSS');
	var $helpers = array('Form', 'Html', 'Javascript', 'Time', 'FormatEpochToDate', 'CustomDisplayFunctions','JQValidator.JQValidator');
	
	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'documents','action'=>'view'));
		} else {			
			$this->Document->recursive = 0;		
			$recordCount = $this->Document->find('count');
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('Document'=>array('order' => array('Document.documentDate' => 'DESC'), 'limit' => $recordCount)));
				} else {
					//find total count of records
					$recordCount = $this->Document->find('count',array('conditions' => array('Document.title LIKE' => ''.trim($_GET['sel']).'%')));
					$this->paginate = Set::merge($this->paginate,array('Document'=>array('conditions' => array('Document.title LIKE' => ''.trim($_GET['sel']).'%'), 'limit' => $recordCount)));
				}
			} elseif(isset($_GET['group'])){
				if((int)trim($_GET['group'])>0){
					$recordCount = $this->Document->find('count',array('conditions' => array('Document.category_id =' => (int)trim($_GET['group']))));
					$this->paginate = Set::merge($this->paginate,array('Document'=>array('conditions' => array('Document.category_id =' => (int)trim($_GET['group'])), 'limit' => $recordCount)));
				}
			} elseif(isset($_GET['search'])){
				//find total count of records
				$recordCount = $this->Document->find('count',array('conditions' => array('Document.title LIKE' => '%'.trim($_GET['search']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Document'=>array('conditions' => array('Document.title LIKE' => '%'.trim($_GET['search']).'%'), 'limit' => $recordCount)));
			} else {			
				//$this->paginate = Set::merge($this->paginate,array('Document'=>array('order' => array('Document.documentDate' => 'DESC'), 'limit' => $recordCount)));
				$recordCount = $this->Document->find('count',array('conditions' => array('Document.category_id =' => '')));
				$this->paginate = Set::merge($this->paginate,array('Document'=>array('conditions' => array('Document.category_id =' => ''), 'limit' => $recordCount)));
			}					
		
			$this->set('documents', $this->paginate());		
			$this->loadModel('DocumentsCategory'); //if it's not already loaded
			$options = $this->DocumentsCategory->find('all', array('order' => 'DocumentsCategory.category')); //or whatever conditions you want
			$this->set('options',$options);
			$pageLimit = 20;
			$this->set('pageLimit',$pageLimit);
			$moduleHeading = 'Documents';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Manage');
			$this->set('helpURL','documents');
			//layout options
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function view() {//no need to pass an ID
		if($_SESSION['Auth']['User']['group_id']==4){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay'));	
		} else {
			if(isset($_GET['group']) ){
				if((int)trim($_GET['group'])>0){
					$recordCount = $this->Document->find('count',array('conditions' => array('Document.live = 1', 'Document.category_id =' => (int)trim($_GET['group']))));
					$this->paginate = Set::merge($this->paginate,array('Document'=>array('conditions' => array('Document.live = 1', 'Document.category_id =' => (int)trim($_GET['group'])), 'order' => array('Document.title' => 'ASC'), 'limit' => $recordCount)));
				} else {
					$recordCount = $this->Document->find('count',array('conditions' => array('Document.live = 1')));
					$this->paginate = Set::merge($this->paginate,array('Rate'=>array('conditions' => array('Document.live = 1'), 'order' => array('Document.title' => 'ASC'), 'limit' => $recordCount)));	
				}
			} else {
				$recordCount = $this->Document->find('count',array('conditions' => array('Document.live = 1')));
				$this->paginate = Set::merge($this->paginate,array('Rate'=>array('conditions' => array('Document.live = 1'), 'order' => array('Document.title' => 'ASC'), 'limit' => $recordCount)));
			}
		}
		
		if (isset($_GET['group']))  {			
  		    $this->set('documents', $this->paginate());	
		} else  {
			$this->set('documents', "");			
		}
		
		//for news category drop down with values that has associated news
		$fields = array('DISTINCT DocumentsCategory.category', 'DocumentsCategory.id');
		$conditions = array('Document.live = 1');
		$joins = array(
			array(
				'table' => 'documents', 
				'alias' => 'Document', 
				'type' => 'RIGHT', 
				'conditions' => array('Document.category_id = DocumentsCategory.id')
			)
		);                                                                                                        
		$joinDocumentsArray = array('fields' => $fields, 'conditions' => $conditions, 'joins' => $joins, 'order' => 'DocumentsCategory.category');            
		$this->loadModel('DocumentsCategory'); //if it's not already loaded
		$options = $this->DocumentsCategory->find('all',$joinDocumentsArray); //or whatever conditions you want
		$this->set('options',$options);
		
		$pageLimit = 20;
		$this->set('pageLimit',$pageLimit);
			
		$moduleHeading = 'Documents';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('moduleAction','View');
		$this->set('helpURL','documents');
		//layout options
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
			$this->redirect(array('controller'=>'documents','action'=>'view'));
		} else {			
			if (!$id) {
				$this->flash(__('Invalid documents', true), array('action' => 'index'));
			}
			$this->set('document', $this->Document->read(null, $id));
			$moduleHeading = 'Documents';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('page', 'documents');
			$this->set('moduleAction','Preview');
			$this->set('helpURL','documents');
			//layout options
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'documents','action'=>'view'));
		} else {			
			if (!empty($this->data)) {
				$this->Document->create();
				if ($this->Document->save($this->data)) {
					$this->flash(__('Document saved.', true), array('action' => 'index'));
				} else {
				}
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$this->loadModel('DocumentsCategory'); //if it's not already loaded
			$options = $this->DocumentsCategory->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$moduleHeading = 'Documents';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Add');
			$this->set('helpURL','documents');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Document',
				$this->Document->validate,
				__('Save failed, fix the following errors:', true),
				'DocumentAddForm'
			);
			//layout options
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'documents','action'=>'view'));
		} else {			
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid documents', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->Document->save($this->data)) {
					$this->flash(__('The documents has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Document->read(null, $id);
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$this->loadModel('DocumentsCategory'); //if it's not already loaded
			$options = $this->DocumentsCategory->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$moduleHeading = 'Documents Items';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Edit');
			$this->set('helpURL','documents');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Document',
				$this->Document->validate,
				__('Save failed, fix the following errors:', true),
				'DocumentEditForm'
			);	
			//layout options
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'documents','action'=>'view'));
		} else {			
			if (!$id) {
				$this->flash(sprintf(__('Invalid documents', true)), array('action' => 'index'));
			}
			if ($this->Document->delete($id)) {
				$this->flash(__('Documents deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Documents was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function publish($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'documents','action'=>'view'));
		} else {			
			if (!$id) {
				$this->flash(sprintf(__('Invalid documents', true)), array('action' => 'index'));
			}
			if ($this->Document->saveField('live',1,false)) {
				$this->flash(__('Document published', true), array('action' => 'index'));
			}
			$this->flash(__('Document was not published', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function unpublish($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'documents','action'=>'view'));
		} else {			
			if (!$id) {
				$this->flash(sprintf(__('Invalid document', true)), array('action' => 'index'));
			}
			if ($this->Document->saveField('live',0,false)) {
				$this->flash(__('Document unpublished', true), array('action' => 'index'));
			}
			$this->flash(__('Document was not unpublished', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function deletefile($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($this->Document->saveField('documentFile','')){
			//we have successfully deleted file from DB
			$this->redirect(array('action' => 'edit/'.$id));
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
}
?>