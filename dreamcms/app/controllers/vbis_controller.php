<?php
class VbisController extends AppController {

	var $name = 'Vbis';
	var $components = array('JQValidator.JQValidator','RSS');
	var $helpers = array('Form', 'Html', 'Javascript', 'Time', 'FormatEpochToDate', 'CustomDisplayFunctions','JQValidator.JQValidator');
	
	function index() {		
		$this->loadModel('Users');
		$this->Vbi->recursive = 0;		

		// Define VBI Data Retrieval Conditions	  
		$conditions = array();
		if ((isset($this->params['named']['group'])) && ((int)trim($this->params['named']['group'])>0)) {
			// CHANGE REQUEST Nyree 06/07/2015
			// Combining of ANZ and ANZ Edge Transactions
		   if  (($this->params['named']['group'] == 1) || ($this->params['named']['group'] == 17))  {
			   $conditions[] =  array('(Vbi.lender_id = 1 OR Vbi.lender_id = 17)');
		   } else  {							
		      $conditions[] =  array('Vbi.lender_id =' => (int)trim($this->params['named']['group']));
		   }
		   // END CHAGE REQUEST
		}	
		
//		if (isset($this->params['named']['year']))  {
//		   $start_date = $this->params['named']['year'] . "-" . $this->params['named']['month'] . "-01 00:00:00";	
//		} else  {
//		   $start_date = date("Y-m") . "-01 00:00:00";
//		}
//		$conditions[] =  array('Vbi.start_date =' => $start_date);
			  			
		$recordCount = $this->Vbi->find('count',array('conditions' => $conditions));
		$this->paginate = Set::merge($this->paginate,array('Vbi'=>array('conditions' => $conditions,'limit'=>$recordCount)));
		
		$this->set('vbis', $this->paginate());	
		
		$this->loadModel('ClaimsLender');
		$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender'));
		$this->set('lenderOptions',$lenderOptions);		
			
		$pageLimit = 50;				
		$this->set('pageLimit',$pageLimit);
		
		$moduleHeading = "VBI";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('moduleAction','Manage Structure');
		$this->set('helpURL','Vbi');
		
		$reporting = true;
		$this->set('reportingVBIStructure', $reporting);
		$this->set('reportingVBISplit', $reporting);
		$this->set('reportingVBIBreakUp', $reporting);
		$this->set('reportingVBIGraph', $reporting);
			
		//layout options
		$this->set('manageVBIStructure', true);
		$this->set('manageVBISplit', true);
		$this->set('manageVBISetting', true);
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
	}

	function view($id = null) {	
	$this->flash(__('VBI saved.', true), '');
  	   $this->redirect(array('controller'=>'Vbis','action'=>'index'));	
	}

	function add() {			
		if ($_SESSION['Auth']['User']['group_id'] < 4) { //all but banks			
		   if (!empty($this->data)) {								
			  $this->Vbi->create();								
			
			  if ($this->Vbi->save($this->data)) {	
			     $url = array('action'=>'index/page:1/group:'. $this->data['Vbi']['lender_id']); //. "/month:" . $this->data['Vbi']['period_month'] . "/year:" . $this->data['Vbi']['period_year']);  			
				 $this->flash(__('VBI saved.', true), $url);									
			  } else {								
			  }
			}
			
			$this->layout='add-edit';			
						
            $this->loadModel('ClaimsLender'); 
			$lenderOptions = $this->ClaimsLender->find('all'); 
			$this->set('lenderOptions',$lenderOptions);			
			
			$moduleHeading = 'VBI Structure';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Add');
			$this->set('helpURL','Vbi');	
			
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);	
			
			$this->JQValidator->addValidation
			(
				'Vbi',
				$this->Vbi->validate,
				__('Save failed, fix the following errors:', true),
				'VbiAddForm'
			);
		} else {
			//redirect shareholders and banks to home page
			$this->redirect(array('controller'=>'Vbis','action'=>'homedisplay','home'));	
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==4){ //admin and brokers only	
			//redirect banks to home page
			$this->redirect(array('controller'=>'Vbis','action'=>'homedisplay','home'));	
		} else {
			if (!$id && empty($this->data)) {			    
				$this->flash(sprintf(__('Invalid VBI', true)), array('action' => 'index'));			
			}
			if (!empty($this->data)) {
				if ($this->Vbi->save($this->data)) {
				   $url = array('action'=>'index/page:1/group:'. $this->data['Vbi']['lender_id']); // . "/month:" . $this->data['Vbi']['period_month'] . "/year:" . $this->data['Vbi']['period_year']);  					   										
				   $this->flash(__('The VBI has been saved.', true), $url);					
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Vbi->read(null, $id);
				//backend security for not allowing anyone to access a Vbi if it is marked as actioned
				if($this->data['Vbi']['status']==1){ 
					if($_SESSION['Auth']['Users']['group_id']!=1){
						$this->redirect(Controller::referer());	
					}
				}
			}
			$this->layout='add-edit';

            $this->loadModel('ClaimsLender'); 
			$lenderOptions = $this->ClaimsLender->find('all'); 
			$this->set('lenderOptions',$lenderOptions);	

			$this->loadModel('Users'); 
			if($_SESSION['Auth']['User']['group_id']==1){
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3), 'order' => array('Users.name' => 'ASC')));
			} elseif($_SESSION['Auth']['User']['group_id']==2) {
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3, 'Users.parent_user_id' => $_SESSION['Auth']['User']['id']), 'order' => array('Users.name' => 'ASC'))); //shareholders only
			} else {
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3, 'Users.id' => $_SESSION['Auth']['User']['id']), 'order' => array('Users.name' => 'ASC'))); //brokers only
			}
			$this->set('brokerOptions',$brokerOptions);
			
			$moduleHeading = 'VBI Structure';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Edit');
			$this->set('helpURL','Vbi');

			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);		

			$this->JQValidator->addValidation
			(
				'Vbi',
				$this->Vbi->validate,
				__('Save failed, fix the following errors:', true),
				'VbiEditForm'
			);	
		}
	}	
		
	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==1 || $_SESSION['Auth']['User']['group_id']==2) {
			if (!$id) {
				$this->flash(sprintf(__('Invalid VBI', true)), array('action' => 'index'));
			}
			if ($this->Vbi->delete($id)) {
				$this->flash(__('VBI deleted', true), array('action' => 'index'));
			}
			$this->flash(__('VBI was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->redirect(array('controller'=>'Vbis','action'=>'index'));	
		}
	}
	
	function publish($id = null) {
		if($_SESSION['Auth']['User']['group_id']==1) { //only super users can mark transactions/Vbis as actioned
			if (!$id) {
				$this->flash(sprintf(__('Invalid transaction', true)), array('action' => 'index'));
			}
			$id_array = explode(",", $id);
			$actioned = true;
			if(isset($id_array[0])) {
				$flash_text = "";
				foreach($id_array as $v) {
					// run sql to mark items as actioned individually
					$sql = "update Vbis set actioned=1 where id=".$v;
					$actioned = ($this->Vbi->query($sql))?$actioned:false;
					$flash_text.= "actioned: ".$sql."<br>";
				}
				if($actioned) {
					$this->flash(__('All transactions selected marked as \'actioned\'', true), array('action' => 'index'));
				} else {
					$this->flash(__('Not all transactions where actioned', true), array('action' => 'index'));
				}
			} else { // error
				$this->flash(__('No transactions actioned', true), array('action' => 'index'));
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$this->redirect(array('controller'=>'Vbis','action'=>'homedisplay','home'));	
		}
	}
	
	function lock($id = null) {
		if($_SESSION['Auth']['User']['group_id']==1) {
			if (!$id) {
				$this->flash(sprintf(__('Invalid VBI', true)), array('action' => 'index'));
			}
			if ($this->Vbi->saveField('status',1,false)) {
				$this->flash(__('VBI back in the unprocessed queue', true), array('action' => 'index'));
			}
			$this->flash(__('VBI needs to be updated', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->redirect(array('controller'=>'Vbis','action'=>'homedisplay','home'));	
		}
	}
	
	function extractreport(){
        $this->loadModel('ClaimsLender'); 
		$lenderOptions = $this->ClaimsLender->find('all'); 
		$this->set('lenderOptions',$lenderOptions);			
			
		$this->layout='ajax';
		$moduleHeading = 'Transaction Report';
		$this->set('moduleHeading',$moduleHeading);		
	}
	
	function reportOutput(){
		// Data Retrieval Conditions
		$conditions = array();
		if ((isset($this->params['named']['group'])) && ((int)trim($this->params['named']['group'])>0)) {
		   // CHANGE REQUEST Nyree 06/07/2015
		   // Combining of ANZ and ANZ Edge Transactions
		   if  (($this->params['named']['group'] == 1) || ($this->params['named']['group'] == 17))  {
			   $conditions[] =  array('(Vbi.lender_id = 1 OR Vbi.lender_id = 17)');
		   } else  {							
		     $conditions[] =  array('Vbi.lender_id =' => (int)trim($this->params['named']['group']));
		   }
		   // END CHAGE REQUEST			   
		}	
		
//		if (isset($this->params['named']['year']))  {
//		   $start_date = $this->params['named']['year'] . "-" . $this->params['named']['month'] . "-01 00:00:00";	
//		} else  {
//		   $start_date = date("Y-m") . "-01 00:00:00";
//		}
//		$conditions[] =  array('Vbi.start_date =' => $start_date);				    	
					
		$this->Vbi->recursive = 1;
		$vbi = $this->Vbi->find('all', array('order' => array('Vbi.lender_id' => 'ASC', 'Vbi.rate' => 'ASC'), 'conditions' => $conditions));
				
		// Lenders
		$this->loadModel('ClaimsLender'); 
		$lenderOptions = $this->ClaimsLender->find('all'); 
		$this->set('lenderOptions',$lenderOptions);		
		
//		$this->set('period', date('M', strtotime($start_date)) . " " . $this->params['named']['year']);
		
		$this->set('vbi',$vbi);
		$this->render('vbi-export_xls','vbi-export_xls');
	}
}
?>