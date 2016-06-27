<?php
class CategoriesController extends AppController {

	var $name = 'Categories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->Category->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('Category'=>array('order' => array('Category.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('Category'=>array('order' => array('Category.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('Category'=>array('conditions' => array('Category.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('Category'=>array('conditions' => array('Category.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}			
			$this->set('categories', $this->paginate());
			$hasNoCategoryItems = $this->Category->find('all', array('conditions'=> 'Category.id NOT IN (SELECT Images.categorie_id from images AS Images)'));
			$this->set('hasNoCategoryItems',$hasNoCategoryItems);
			$this->set('helpURL','gallery');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->Session->setFlash(__('Invalid category', true));
				$this->redirect(array('action' => 'index'));
			}
			$this->set('category', $this->Category->read(null, $id));
			$this->set('helpURL','gallery');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!empty($this->data)) {
				$this->Category->create();
				if ($this->Category->save($this->data)) {
					$this->flash(__('The image category has been saved', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'image categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','gallery');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Category',
				$this->Category->validate,
				__('Save failed, fix the following errors:', true),
				'CategoryAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid category', true));
				$this->redirect(array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->Category->save($this->data)) {
					$this->flash(__('The image category has been saved', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Category->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'image categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','gallery');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Category',
				$this->Category->validate,
				__('Save failed, fix the following errors:', true),
				'CategoryEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid image category', true)), array('action' => 'index'));
				//$this->redirect(array('action'=>'index'));
			}
			if ($this->Category->delete($id)) {
				$this->flash(__('Image category deleted', true), array('action' => 'index'));
				//$this->redirect(array('action'=>'index'));
			}
			$this->flash(__('Image category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
?>