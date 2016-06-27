<?php
class SettingsController extends AppController {

	var $name = 'Settings';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator');
	
	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->Setting->recursive = 0;
			$this->set('settings', $this->paginate());
			$this->set('helpURL','gallery');
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid image setting', true), array('action' => 'index'));
				$this->redirect(array('action' => 'index'));
			}
			$this->set('setting', $this->Setting->read(null, $id));
			$this->set('helpURL','gallery');
		}
	}

	function add() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!empty($this->data)) {
				$this->Setting->create();
				if ($this->Setting->save($this->data)) {
					$this->flash(__('Teams image setting has been saved.', true), array('action' => 'index'));
					//$this->Session->setFlash(__('The setting has been saved', true));
					//$this->redirect(array('action' => 'index'));
				} else {
					//$this->flash(__('The setting could not be saved. Please, try again.', true), array('action' => 'index'));
					//$this->Session->setFlash(__('The setting could not be saved. Please, try again.', true));
				}				
				$this->set('helpURL','gallery');
			}
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid setting', true));
				$this->redirect(array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->Setting->save($this->data)) {
					/*Cache::delete('settings');
					$this->Session->setFlash(__('The setting has been saved', true));
					$this->redirect(array('action' => 'index'));*/					
					$this->flash(__('The Settings has been saved.', true), array('action' => 'index'));
				} else {
					//$this->Session->setFlash(__('The setting could not be saved. Please, try again.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Setting->read(null, $id);
			}			
			$this->set('helpURL','gallery');
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(__('Invalid id for setting', true), array('action' => 'index'));
				//$this->Session->setFlash(__('Invalid id for setting', true));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->Setting->delete($id)) {
				$this->flash(__('Image setting deleted', true), array('action' => 'index'));
				//$this->Session->setFlash(__('Setting deleted', true));
				$this->redirect(array('action'=>'index'));
			}
			$this->flash(__('Image setting was not deleted', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Setting was not deleted', true));
			$this->redirect(array('action' => 'index'));
		}
	}
}
?>