<?php
class NewsCategoriesController extends AppController {

	var $name = 'NewsCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->NewsCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('NewsCategory'=>array('order' => array('NewsCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('NewsCategory'=>array('order' => array('NewsCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('NewsCategory'=>array('conditions' => array('NewsCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('NewsCategory'=>array('conditions' => array('NewsCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('newsCategories', $this->paginate());
			$hasNoNewsItems = $this->NewsCategory->find('all', array('conditions'=> 'NewsCategory.id NOT IN (SELECT News.category_id from news AS News)'));
			$this->set('hasNoNewsItems',$hasNoNewsItems);
			$this->set('helpURL','news');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','News Categories');
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
				$this->flash(__('Invalid news category', true), array('action' => 'index'));
			}
			$this->set('newsCategory', $this->NewsCategory->read(null, $id));
			$this->set('helpURL','news');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','News Categories');
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
				$this->NewsCategory->create();
				if ($this->NewsCategory->save($this->data)) {
					$this->flash(__('Newscategory saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'news categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','news');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'NewsCategory',
				$this->NewsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'NewsCategoryAddForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','News Categories');
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
				$this->flash(sprintf(__('Invalid news category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->NewsCategory->save($this->data)) {
					$this->flash(__('The news category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->NewsCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'news categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','news');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'NewsCategory',
				$this->NewsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'NewsCategoryEditForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','News Categories');
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
				$this->flash(sprintf(__('Invalid news category', true)), array('action' => 'index'));
			}
			if ($this->NewsCategory->delete($id)) {
				$this->flash(__('News category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('News category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
