<?php
class ClaimsIndustryprofilesController extends AppController {

	var $name = 'ClaimsIndustryprofiles';
	var $components = array('JQValidator.JQValidator');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator'); 

	function index() {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->ClaimsIndustryprofile->recursive = 0;
			$this->paginate = Set::merge($this->paginate,array('ClaimsIndustryprofile'=>array('order' => array('ClaimsIndustryprofile.id' => 'ASC'),'limit'=>'10')));
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('ClaimsIndustryprofile'=>array('order' => array('ClaimsIndustryprofile.id' => 'ASC'),'limit'=>'30')));
				} else {
					$this->paginate = Set::merge($this->paginate,array('ClaimsIndustryprofile'=>array('conditions' => array('ClaimsIndustryprofile.industryProfile LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>'10')));
				}
			}
			if(isset($_GET['search'])){			
				$this->paginate = Set::merge($this->paginate,array('ClaimsIndustryprofile'=>array('conditions' => array('ClaimsIndustryprofile.industryProfile LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>'10')));
			}
			$this->set('claimsIndustryprofiles', $this->paginate());
			$hasNoClaimIndustryProfileItems = $this->ClaimsIndustryprofile->find('all', array('conditions'=> 'ClaimsIndustryprofile.id NOT IN (SELECT Claims.industryprofile_id from claims AS Claims)'));
			$this->set('hasNoClaimIndustryProfileItems',$hasNoClaimIndustryProfileItems);
			$this->set('helpURL','claims');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Industry Profiles');
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
				$this->flash(__('Invalid transaction industry profile', true), array('action' => 'index'));
			}
			$this->set('ClaimsIndustryprofile', $this->ClaimsIndustryprofile->read(null, $id));
			$this->set('helpURL','claims');
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Industry Profiles');
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
				$this->ClaimsIndustryprofile->create();
				if ($this->ClaimsIndustryprofile->save($this->data)) {
					$this->flash(__('Transaction industry profile saved.', true), array('action' => 'index'));
				} else {
				}
			}		
			$this->layout='add-edit';
			$moduleHeading = 'transaction industry profiles';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','claims');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClaimsIndustryprofile',
				$this->ClaimsIndustryprofile->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimsIndustryprofileAddForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Industry Profiles');
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
				$this->flash(sprintf(__('Invalid transaction industry profile', true)), array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->ClaimsIndustryprofile->save($this->data)) {
					$this->flash(__('The transaction industry profile has been saved.', true), array('action' => 'index'));
				} else {
				}
			}
			if (empty($this->data)) {
				$this->data = $this->ClaimsIndustryprofile->read(null, $id);
			}		
			$this->layout='add-edit';
			$moduleHeading = 'transaction industry profiles';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('helpURL','claims');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'ClaimsIndustryprofile',
				$this->ClaimsIndustryprofile->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimsIndustryprofileEditForm'
			);
		}
		//layout options
		$this->set('page', 'claims');
		$this->set('moduleHeading','Transaction Industry Profiles');
		$this->set('moduleAction','Manage');
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
				$this->flash(sprintf(__('Invalid transaction industry profile', true)), array('action' => 'index'));
			}
			if ($this->ClaimsIndustryprofile->delete($id)) {
				$this->flash(__('Transaction industry profile deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Transaction industry profile was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
