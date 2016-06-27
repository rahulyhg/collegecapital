<?php
class ClaimsGoodsdescsController extends AppController {

	var $name = 'ClaimsGoodsdescs';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->ClaimsGoodsdesc->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('ClaimsGoodsdesc'=>array('order' => array('ClaimsGoodsdesc.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('ClaimsGoodsdesc'=>array('order' => array('ClaimsGoodsdesc.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('ClaimsGoodsdesc'=>array('conditions' => array('ClaimsGoodsdesc.goodsDescription LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('ClaimsGoodsdesc'=>array('conditions' => array('ClaimsGoodsdesc.goodsDescription LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('claimsGoodsdescs', $this->paginate());
			$hasNoClaimGoodsdescs = $this->ClaimsGoodsdesc->find('all', array('conditions'=> 'ClaimsGoodsdesc.id NOT IN (SELECT Claims.goodsdesc_id from claims AS Claims)'));
			$this->set('hasNoClaimGoodsdescs',$hasNoClaimGoodsdescs);
			$this->set('helpURL','claims');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Claims Goods Description');
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
				$this->flash(__('Invalid transaction goods description', true), array('action' => 'index'));
			}
			$this->set('ClaimsGoodsdesc', $this->ClaimsGoodsdesc->read(null, $id));
			$this->set('helpURL','claims');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Goods Description');
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
				$this->ClaimsGoodsdesc->create();
				if ($this->ClaimsGoodsdesc->save($this->data)) {
					$this->flash(__('Transaction goods description saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'transaction goods description';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','claims');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClaimsGoodsdesc',
				$this->ClaimsGoodsdesc->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimsGoodsdescAddForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Goods Description');
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
				$this->flash(sprintf(__('Invalid transaction goods description', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->ClaimsGoodsdesc->save($this->data)) {
					$this->flash(__('The transaction goods description has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->ClaimsGoodsdesc->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'transaction goods description';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','claims');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClaimsGoodsdesc',
				$this->ClaimsGoodsdesc->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimsGoodsdescEditForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Goods Description');
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
				$this->flash(sprintf(__('Invalid transaction goods description', true)), array('action' => 'index'));
			}
			if ($this->ClaimsGoodsdesc->delete($id)) {
				$this->flash(__('Transaction goods description deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Transaction goods description was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
