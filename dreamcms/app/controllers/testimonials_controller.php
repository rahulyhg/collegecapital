<?php
class TestimonialsController extends AppController {

	var $name = 'Testimonials';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript','Ajax', 'CustomDisplayFunctions','JQValidator.JQValidator');

	function index() {
		$this->Testimonial->recursive = 0;
		$sortable = false; //disable sorting by default
		$recordCount = $this->Testimonial->find('count');
		if(isset($_GET['sort_list']) && trim($_GET['sort_list']=='true')) {//sorting enabled
			$sortable = true;
			$this->paginate = Set::merge($this->paginate,array('Testimonial'=>array('order' => array('Testimonial.position' => 'ASC'),'limit'=>$recordCount)));
		} elseif(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Testimonial'=>array('order' => array('Testimonial.position' => 'ASC'),'limit'=>$recordCount)));
			} else {
				//find total count of records
				$recordCount = $this->Testimonial->find('count',array('conditions' => array('Testimonial.description LIKE' => ''.trim($_GET['sel']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Testimonial'=>array('conditions' => array('Testimonial.description LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>$recordCount)));
			}
		} elseif(isset($_GET['search'])){
			//find total count of records
			$recordCount = $this->Testimonial->find('count',array('conditions' => array('Testimonial.description LIKE' => '%'.trim($_GET['search']).'%')));
			$this->paginate = Set::merge($this->paginate,array('Testimonial'=>array('conditions' => array('Testimonial.description LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>$recordCount)));
		} else {
			$this->paginate = Set::merge($this->paginate,array('Testimonial'=>array('order' => array('Testimonial.position' => 'ASC'),'limit'=>$recordCount)));
		}
		$this->set('testimonials', $this->paginate());
		$this->set('instructionText','You can drag and drop the items below to set the order.');
		$this->set('orderStatus', 'TESTIMONIALS Ordering Succesfully Saved!');
		$this->set('sortable',$sortable);
		$pageLimit = 10;
		$this->set('pageLimit',$pageLimit);
		$this->set('helpURL','testimonials');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid testimonial', true), array('action' => 'index'));
		}
		$this->set('testimonial', $this->Testimonial->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = 'testimonials';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','testimonials');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Testimonial->create();
			if ($this->Testimonial->save($this->data)) {
				$this->flash(__('Testimonial saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$this->layout='add-edit';
		$moduleHeading = 'testimonials';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('maxPosition',$this->Testimonial->find('count'));
		$this->set('helpURL','testimonials');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Testimonial',
			$this->Testimonial->validate,
			__('Save failed, fix the following errors:', true),
			'TestimonialAddForm'
		);		
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid testimonial', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Testimonial->save($this->data)) {
				$this->flash(__('The testimonial has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Testimonial->read(null, $id);
		}
		$this->layout='add-edit';
		$moduleHeading = 'testimonials';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','testimonials');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Testimonial',
			$this->Testimonial->validate,
			__('Save failed, fix the following errors:', true),
			'TestimonialEditForm'
		);
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid testimonial', true)), array('action' => 'index'));
		}
		if ($this->Testimonial->delete($id)) {
			$this->flash(__('Testimonial deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Testimonial was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid testimonial', true)), array('action' => 'index'));
		}
		if ($this->Testimonial->saveField('live',1,false)) {
			$this->flash(__('Testimonial published', true), array('action' => 'index'));
		}
		$this->flash(__('Testimonial was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid testimonial', true)), array('action' => 'index'));
		}
		if ($this->Testimonial->saveField('live',0,false)) {
			$this->flash(__('Testimonial unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Testimonial was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	/** Receives ajax request from index **/
	function order(){
	//loop through the data sent via the ajax call
		foreach ($this->params['form']['testimonials'] as $order => $id){
			$data['Testimonial']['position'] = $order;
			$this->Testimonial->id = $id;
			if($this->Testimonial->saveField('position',$order)) {
				//we have success!
			} else {
				//deal with possible errors!
			}
		}
		$this->autoRender=false;
	}
	
	function deletefile($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($this->Testimonial->saveField('photo','')){
			//we have successfully deleted file from DB
			$this->redirect(array('action' => 'edit/'.$id));
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
}
