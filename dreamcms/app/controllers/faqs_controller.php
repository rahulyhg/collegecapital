<?php
class FaqsController extends AppController {

	var $name = 'Faqs';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript','Ajax', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		$this->Faq->recursive = 0;
		$sortable = false; //disable sorting by default
		$recordCount = $this->Faq->find('count');
		if(isset($_GET['sort_list']) && trim($_GET['sort_list']=='true')) {//sorting enabled
			$sortable = true;
			$this->paginate = Set::merge($this->paginate,array('Faq'=>array('order' => array('Faq.position' => 'ASC'),'limit'=>$recordCount)));
		} elseif(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Faq'=>array('order' => array('Faq.position' => 'ASC'),'limit'=>$recordCount)));
			} else {
				//find total count of records
				$recordCount = $this->Faq->find('count',array('conditions' => array('Faq.title LIKE' => ''.trim($_GET['sel']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Faq'=>array('conditions' => array('Faq.title LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>$recordCount)));
			}
		} elseif(isset($_GET['group'])){
			if((int)trim($_GET['group'])>0){
				$recordCount = $this->Faq->find('count',array('conditions' => array('Faq.category_id =' => (int)trim($_GET['group']))));
				$this->paginate = Set::merge($this->paginate,array('Faq'=>array('conditions' => array('Faq.category_id =' => (int)trim($_GET['group'])),'limit'=>$recordCount)));
			}
		} elseif(isset($_GET['search'])){
			//find total count of records
			$recordCount = $this->Faq->find('count',array('conditions' => array('Faq.title LIKE' => '%'.trim($_GET['search']).'%')));
			$this->paginate = Set::merge($this->paginate,array('Faq'=>array('conditions' => array('Faq.title LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>$recordCount)));
		} else {
			$this->paginate = Set::merge($this->paginate,array('Faq'=>array('order' => array('Faq.position' => 'ASC'),'limit'=>$recordCount)));
		}
		$this->set('faqs', $this->paginate()); 
		$this->set('instructionText','You can drag and drop the items below to set the order.');
		$this->set('orderStatus', 'FAQ Ordering Succesfully Saved!');
		$this->set('sortable',$sortable);
		$pageLimit = 10;
		$this->set('pageLimit',$pageLimit);
		$this->loadModel('FaqsCategory'); //if it's not already loaded
		$options = $this->FaqsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->set('helpURL','faqs');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid faq', true), array('action' => 'index'));
		}
		$this->set('faq', $this->Faq->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "faq's";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','faqs');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Faq->create();
			if ($this->Faq->save($this->data)) {
				$this->flash(__('Faq saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('FaqsCategory'); //if it's not already loaded
		$options = $this->FaqsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$moduleHeading = 'faqs';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition',$this->Faq->find('count'));
		$this->set('helpURL','faqs');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Faq',
			$this->Faq->validate,
			__('Save failed, fix the following errors:', true),
			'FaqAddForm'
		);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid faq', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Faq->save($this->data)) {
				$this->flash(__('The faq has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Faq->read(null, $id);
		}
		$this->layout='add-edit';
		$ckeditorClass = '';
		$this->set('ckeditorClass', $ckeditorClass);
		$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
		$this->set('ckfinderPath', $ckfinderPath);
		$this->loadModel('FaqsCategory'); //if it's not already loaded
		$options = $this->FaqsCategory->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$moduleHeading = 'faqs';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','faqs');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Faq',
			$this->Faq->validate,
			__('Save failed, fix the following errors:', true),
			'FaqEditForm'
		);
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid faq', true)), array('action' => 'index'));
		}
		if ($this->Faq->delete($id)) {
			$this->flash(__('Faq deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Faq was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid faq', true)), array('action' => 'index'));
		}
		if ($this->Faq->saveField('live',1,false)) {
			$this->flash(__('Faq published', true), array('action' => 'index'));
		}
		$this->flash(__('Faq was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid faq', true)), array('action' => 'index'));
		}
		if ($this->Faq->saveField('live',0,false)) {
			$this->flash(__('Faq unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Faq was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['faqs'] as $order => $id){
			$data['Faq']['position'] = $order;
			$this->Faq->id = $id;
			if($this->Faq->saveField('position',$order)) {
				//we have success!
			} else {
				//deal with possible errors!
			}
		}
		$this->autoRender=false;
	}
}
