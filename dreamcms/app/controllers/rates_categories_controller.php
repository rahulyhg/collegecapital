<?php
class RatesCategoriesController extends AppController {

	var $name = 'RatesCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->RatesCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('RatesCategory'=>array('order' => array('RatesCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('RatesCategory'=>array('order' => array('RatesCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('RatesCategory'=>array('conditions' => array('RatesCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('RatesCategory'=>array('conditions' => array('RatesCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('ratesCategories', $this->paginate());
			$hasNoRateItems = $this->RatesCategory->find('all', array('conditions'=> 'RatesCategory.id NOT IN (SELECT Rates.category_id from rates AS Rates)'));
			$this->set('hasNoRateItems',$hasNoRateItems);
			$this->set('page','rates');
			$this->set('helpURL','rates');
			//layout options		
			$this->set('moduleHeading','Rate Categories');
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
				$this->flash(__('Invalid rates category', true), array('action' => 'index'));
			}
			$this->set('ratesCategory', $this->RatesCategory->read(null, $id));
			$this->set('page','rates');
			$this->set('helpURL','rates');
			//layout options		
			$this->set('moduleHeading','Rate Categories');
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
				$this->RatesCategory->create();
				if ($this->RatesCategory->save($this->data)) {
					$this->flash(__('The rates category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$moduleHeading = 'Rate Categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Add');
			$this->set('page','rates');
			$this->set('helpURL','rates');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'RatesCategory',
				$this->RatesCategory->validate,
				__('Save failed, fix the following errors:', true),
				'RatesCategoryAddForm'
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
				$this->flash(sprintf(__('Invalid rates category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->RatesCategory->save($this->data)) {
					$this->flash(__('The rates category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->RatesCategory->read(null, $id);
			}		
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$moduleHeading = 'Rate Categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Edit');
			$this->set('page','rates');
			$this->set('helpURL','rates');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'RatesCategory',
				$this->RatesCategory->validate,
				__('Save failed, fix the following errors:', true),
				'RatesCategoryEditForm'
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
				$this->flash(sprintf(__('Invalid rates category', true)), array('action' => 'index'));
			}
			if ($this->RatesCategory->delete($id)) {
				$this->flash(__('Rates category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Rates category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
