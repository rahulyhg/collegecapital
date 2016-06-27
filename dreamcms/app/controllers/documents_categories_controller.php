<?php
class DocumentsCategoriesController extends AppController {

	var $name = 'DocumentsCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->DocumentsCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('DocumentsCategory'=>array('order' => array('DocumentsCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('DocumentsCategory'=>array('order' => array('DocumentsCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('DocumentsCategory'=>array('conditions' => array('DocumentsCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('DocumentsCategory'=>array('conditions' => array('DocumentsCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('documentsCategories', $this->paginate());
			$hasNoDocumentItems = $this->DocumentsCategory->find('all', array('conditions'=> 'DocumentsCategory.id NOT IN (SELECT Documents.category_id from documents AS Documents)'));
			$this->set('hasNoDocumentItems',$hasNoDocumentItems);
			$this->set('page','documents');
			$this->set('helpURL','documents');
			//layout options		
			$this->set('moduleHeading','Document Categories');
			$this->set('moduleAction','Manage');
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid documents category', true), array('action' => 'index'));
			}
			$this->set('documentsCategory', $this->DocumentsCategory->read(null, $id));
			$this->set('page','documents');
			$this->set('helpURL','documents');
			//layout options		
			$this->set('moduleHeading','Document Categories');
			$this->set('moduleAction','Preview');
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
			if (!empty($this->data)) {
				$this->DocumentsCategory->create();
				if ($this->DocumentsCategory->save($this->data)) {
					$this->flash(__('The documents category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$moduleHeading = 'Document Categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Add');
			$this->set('page','documents');
			$this->set('helpURL','documents');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'DocumentsCategory',
				$this->DocumentsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'DocumentsCategoryAddForm'
			);
			//layout options		
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
			if (!$id && empty($this->data)) {
				$this->flash(sprintf(__('Invalid documents category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->DocumentsCategory->save($this->data)) {
					$this->flash(__('The documents category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->DocumentsCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$moduleHeading = 'Document Categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Edit');
			$this->set('page','documents');
			$this->set('helpURL','documents');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'DocumentsCategory',
				$this->DocumentsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'DocumentsCategoryEditForm'
			);
			//layout options		
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
				$this->flash(sprintf(__('Invalid documents category', true)), array('action' => 'index'));
			}
			if ($this->DocumentsCategory->delete($id)) {
				$this->flash(__('Documents category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Documents category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
