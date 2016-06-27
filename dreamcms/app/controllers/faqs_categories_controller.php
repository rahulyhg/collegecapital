<?php
class FaqsCategoriesController extends AppController {

	var $name = 'FaqsCategories';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->FaqsCategory->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('FaqsCategory'=>array('order' => array('FaqsCategory.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('FaqsCategory'=>array('order' => array('FaqsCategory.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('FaqsCategory'=>array('conditions' => array('FaqsCategory.category LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('FaqsCategory'=>array('conditions' => array('FaqsCategory.category LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('faqsCategories', $this->paginate());
			$hasNoFaqsItems = $this->FaqsCategory->find('all', array('conditions'=> 'FaqsCategory.id NOT IN (SELECT Faqs.category_id from faqs AS Faqs)'));
			$this->set('hasNoFaqsItems',$hasNoFaqsItems);
			$this->set('helpURL','faqs');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','FAQs Categories');
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
				$this->flash(__('Invalid faqs category', true), array('action' => 'index'));
			}
			$this->set('faqsCategory', $this->FaqsCategory->read(null, $id));
			$this->set('helpURL','faqs');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','FAQs Categories');
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
				$this->FaqsCategory->create();
				if ($this->FaqsCategory->save($this->data)) {
					$this->flash(__('Faqscategory saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$moduleHeading = 'faq categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','faqs');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'FaqsCategory',
				$this->FaqsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'FaqsCategoryAddForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','FAQs Categories');
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
				$this->flash(sprintf(__('Invalid faqs category', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->FaqsCategory->save($this->data)) {
					$this->flash(__('The faqs category has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->FaqsCategory->read(null, $id);
			}		
			$this->layout='add-edit';			
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$moduleHeading = 'faq categories';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','faqs');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'FaqsCategory',
				$this->FaqsCategory->validate,
				__('Save failed, fix the following errors:', true),
				'FaqsCategoryEditForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','FAQs Categories');
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
				$this->flash(sprintf(__('Invalid faqs category', true)), array('action' => 'index'));
			}			
			if ($this->FaqsCategory->delete($id)) {
				$this->flash(__('Faqs category deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Faqs category was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
