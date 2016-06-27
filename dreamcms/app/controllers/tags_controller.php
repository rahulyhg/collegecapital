<?php
class TagsController extends AppController {

	var $name = 'Tags';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->Tag->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('Tag'=>array('order' => array('Tag.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('Tag'=>array('order' => array('Tag.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('Tag'=>array('conditions' => array('Tag.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('Tag'=>array('conditions' => array('Tag.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}			
			$this->set('tags', $this->paginate());
			$this->set('helpURL','gallery');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid image tag', true), array('action' => 'index'));
				//$this->Session->setFlash(__('Invalid tag', true));
				$this->redirect(array('action' => 'index'));
			}
			$this->set('tag', $this->Tag->read(null, $id));
			$this->set('helpURL','gallery');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!empty($this->data)) {
				$this->Tag->create();
				if ($this->Tag->save($this->data)) {
					$this->flash(__('The image tag has been saved', true), array('action' => 'index'));
					//$this->Session->setFlash(__('The tag has been saved', true));
					//$this->redirect(array('action' => 'index'));
				} else {
				}
			}
			$images = $this->Tag->Image->find('list');
			$this->set(compact('images'));
			$this->set('helpURL','gallery');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Tag',
				$this->Tag->validate,
				__('Save failed, fix the following errors:', true),
				'TagAddForm'
			);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->flash(__('Invalid image tag', true), array('action' => 'index'));
				//$this->Session->setFlash(__('Invalid tag', true));
				//$this->redirect(array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->Tag->save($this->data)) {
					$this->flash(__('The image tag has been saved', true), array('action' => 'index'));
					//$this->Session->setFlash(__('The tag has been saved', true));
					//$this->redirect(array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Tag->read(null, $id);
			}
			$images = $this->Tag->Image->find('list');
			$this->set(compact('images'));
			$this->set('helpURL','gallery');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Tag',
				$this->Tag->validate,
				__('Save failed, fix the following errors:', true),
				'TagEditForm'
			);
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid image tag', true), array('action' => 'index'));
				//$this->Session->setFlash(__('Invalid id for tag', true));
				//$this->redirect(array('action'=>'index'));
			}
			if ($this->Tag->delete($id)) {
				$this->flash(__('The image tag has been deleted', true), array('action' => 'index'));
				//$this->Session->setFlash(__('Tag deleted', true));
				//$this->redirect(array('action'=>'index'));
			}
			$this->flash(__('The image tag was not deleted', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Tag was not deleted', true));
			$this->redirect(array('action' => 'index'));
		}
	}
}
?>