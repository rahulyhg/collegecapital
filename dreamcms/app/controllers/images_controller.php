<?php
class ImagesController extends AppController {

	var $name = 'Images';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 
	
	function index() {
		$this->Image->recursive = 0;
		$this->paginate = Set::merge($this->paginate,array('Image'=>array('order' => array('Image.id' => 'ASC'),'limit'=>'25')));
		if(isset($_GET['sel'])){
			if(trim($_GET['sel']=='all')){	
				$this->paginate = Set::merge($this->paginate,array('Image'=>array('order' => array('Image.id' => 'ASC'),'limit'=>'50')));
			} else {
				$this->paginate = Set::merge($this->paginate,array('Image'=>array('conditions' => array('Image.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'25')));
			}
		}
		if(isset($_GET['cat'])){
			if((int)trim($_GET['cat'])>0){
				$this->paginate = Set::merge($this->paginate,array('Image'=>array('conditions' => array('Image.categorie_id =' => (int)trim($_GET['cat'])),'limit'=>'25')));
			}
		}
		if(isset($_GET['search'])){			
			$this->paginate = Set::merge($this->paginate,array('Image'=>array('conditions' => array('Image.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'25')));
		}
		$this->set('images', $this->paginate());
		$this->loadModel('Category'); //if it's not already loaded
		$options = $this->Category->find('all'); //or whatever conditions you want
		$this->set('options',$options);
		$this->set('helpURL','gallery');
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid image', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('image', $this->Image->read(null, $id));
		$this->layout='front-end-website';
		$moduleHeading = "image gallery";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','gallery');
	}

	function add() {		
		if(!empty($this->data)) {
			$this->Image->create();
			
			// how to ensure unique file names?
			// TODO: Code to warn user about duplicate files
			$newName = $this->Image->saveImage($this->params['data']['Image']['location'],100,"ht",80);
			if(isset($newName))
			{
				$this->params['data']['Image']['location'] = $newName;
			}
			else
			{
				$this->params['data']['Image']['location'] = null;
				// TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
				//die("I am sorry to fail you my master but I could not save your photo");
			}
			
			if ($this->Image->save($this->data)) {
				$this->flash(__('The image has been saved', true), array('action' => 'index'));
				//$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
			}
		}
		$categories = $this->Image->Categorie->find('list');
		$tags = $this->Image->Tag->find('list');
		$this->set(compact('categories', 'tags'));
		$this->layout='add-edit';
		$moduleHeading = 'image gallery';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','gallery');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Image',
			$this->Image->validate,
			__('Save failed, fix the following errors:', true),
			'ImageAddForm'
		);
	}

	function edit($id = null) {
		$imageData = $this->Image->read();
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid image', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Invalid image', true));
			//$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			// Is there a new picture?
			if($this->params['data']['Image']['location'] != $imageData['Image']['location']){
				if ($this->params['data']['Image']['location']['error'] == 0)
				{
					// Delete the picture
					$this->Image->delImage($imageData['Image']['location']);
					$newName = $this->Image->saveImage($this->params['data']['Image']['location'],100,"ht",80);
					if(isset($newName))
					{
						$this->params['data']['Image']['location'] = $newName;
					}
					else
					{
						$this->params['data']['Image']['location'] = null;
						// TODO: Write code to graciously exit if Photo::saveImage fails for now just die()
						die("I am sorry to fail you my master but I could not save your photo");
					}
				}
				else
				{
					// no new picture so keep the old link-location
					$this->params['data']['Image']['location'] = $imageData['Image']['location'];
				}
			}
			##
			if ($this->Image->save($this->data)) {
				$this->flash(__('The image has been saved', true), array('action' => 'index'));
				//$this->Session->setFlash(__('The image has been saved', true));
				//$this->redirect(array('action' => 'index'));
			} else {
			}
			##
		}
		if (empty($this->data)) {
			$this->data = $this->Image->read(null, $id);
		}
		$categories = $this->Image->Categorie->find('list');
		$tags = $this->Image->Tag->find('list');
		$this->set(compact('categories', 'tags'));
		$this->layout='add-edit';
		$moduleHeading = 'image gallery';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','gallery');		
		//javascript validations
		$this->JQValidator->addValidation
		(
			'Image',
			$this->Image->validate,
			__('Save failed, fix the following errors:', true),
			'ImageEditForm'
		);
	}

	function delete($id = null) {
		$imageData = $this->Image->read();
		if (!$id) {
			$this->flash(__('Invalid image', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Invalid id for image', true));
			//$this->redirect(array('action'=>'index'));
		}
		if ($this->Image->delete($id)) {
			$this->Image->delImage($imageData['Image']['location']);
			$this->flash(__('The image has been deleted', true), array('action' => 'index'));
			//$this->Session->setFlash(__('Image deleted', true));
			//$this->redirect(array('action'=>'index'));
		}
		$this->flash(__('The image was not deleted', true), array('action' => 'index'));
		//$this->Session->setFlash(__('Image was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function deletefile($id = null, $fldName = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($id > 0 && strlen($fldName)>0){
			if($this->Image->saveField($fldName,'')){
				//we have successfully deleted file from DB
				$this->redirect(array('action' => 'edit/'.$id));
			}
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
	
	function publish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid image', true)), array('action' => 'index'));
		}
		if ($this->Image->saveField('live',1,false)) {
			$this->flash(__('Image published', true), array('action' => 'index'));
		}
		$this->flash(__('Image was not published', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	function unpublish($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid image', true)), array('action' => 'index'));
		}
		if ($this->Image->saveField('live',0,false)) {
			$this->flash(__('Image unpublished', true), array('action' => 'index'));
		}
		$this->flash(__('Image was not unpublished', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
?>