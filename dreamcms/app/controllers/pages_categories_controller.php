<?php
class PagesCategoriesController extends AppController {

	var $name = 'PagesCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->PagesCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('PagesCategory'=>array('order' => array('PagesCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('PagesCategory'=>array('order' => array('PagesCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('PagesCategory'=>array('conditions' => array('PagesCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('PagesCategory'=>array('conditions' => array('PagesCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('pagesCategories', $this->paginate());
			$hasNoPagesItems = $this->PagesCategory->find('all', array('conditions'=> 'PagesCategory.id NOT IN (SELECT Pages.category_id from pages AS Pages)'));
			$this->set('hasNoPagesItems',$hasNoPagesItems);
			$this->set('helpURL','pages');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Pages Categories');
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
				$this->flash(__('Invalid pages category', true), array('action' => 'index'));
			}
			$this->set('pagesCategory', $this->PagesCategory->read(null, $id));
			$this->set('helpURL','pages');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Pages Categories');
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
				$this->PagesCategory->create();
				if ($this->PagesCategory->save($this->data)) {
					$this->flash(__('Pagescategory saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'page categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','pages');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PagesCategory',
				$this->PagesCategory->validate,
				__('Save failed, fix the following errors:', true),
				'PagesCategoryAddForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Pages Categories');
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
				$this->flash(sprintf(__('Invalid pages category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->PagesCategory->save($this->data)) {
					$this->flash(__('The pages category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->PagesCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'page categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','pages');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'PagesCategory',
				$this->PagesCategory->validate,
				__('Save failed, fix the following errors:', true),
				'PagesCategoryEditForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Pages Categories');
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
				$this->flash(sprintf(__('Invalid pages category', true)), array('action' => 'index'));
			}
			if ($this->PagesCategory->delete($id)) {
				$this->flash(__('Pages category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Pages category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
