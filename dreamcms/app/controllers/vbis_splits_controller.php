<?php
class VbisSplitsController extends AppController {

	var $name = 'VbisSplits';
	var $components = array('JQValidator.JQValidator','RSS');
	var $helpers = array('Form', 'Html', 'Javascript', 'Time', 'FormatEpochToDate', 'CustomDisplayFunctions','JQValidator.JQValidator');
	
	function index() {		
		$this->loadModel('Users');
		$this->Vbi->recursive = 0;		
        
		// Brokers List
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.name' => 'ASC'))); //shareholders only
		$this->set('brokerOptions',$brokerOptions);
		
		// Lender List
		$this->loadModel('ClaimsLender'); 
		$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender'));
		$this->set('lenderOptions',$lenderOptions);
				
		// Define VBI Data Retrieval Conditions		
		$conditions = array();
		if ((isset($this->params['named']['group'])) && ((int)trim($this->params['named']['group'])>0)) {
		   $conditions[] =  array('VbisSplit.broker_id =' => (int)trim($this->params['named']['group']));
		}
		
		if ((isset($this->params['named']['lender'])) && ((int)trim($this->params['named']['lender'])>0)) {
			// CHANGE REQUEST Nyree 06/07/2015
			// Combining of ANZ and ANZ Edge Transactions
		   if  (($this->params['named']['lender'] == 1) || ($this->params['named']['lender'] == 17))  {
			   $conditions[] =  array('(VbisSplit.lender_id = 1 OR VbisSplit.lender_id = 17)');
		   } else  {							
		      $conditions[] =  array('VbisSplit.lender_id =' => (int)trim($this->params['named']['lender']));
		   }
		   // END CHAGE REQUEST		   
		}	
		
		if (isset($this->params['named']['year']))  {
		   $start_date = $this->params['named']['year'] . "-" . $this->params['named']['month'] . "-01 00:00:00";	
		} else  {
		   $start_date = date("Y-m") . "-01 00:00:00";
		}
		$conditions[] =  array('VbisSplit.start_date =' => $start_date);
			  			
		$recordCount = $this->VbisSplit->find('count',array('conditions' => $conditions));
		$this->paginate = Set::merge($this->paginate,array('VbisSplit'=>array('conditions' => $conditions,'limit'=>$recordCount)));
		
		$this->set('vbis', $this->paginate());			
		
		$pageLimit = 50;				
		$this->set('pageLimit',$pageLimit);
		
		$moduleHeading = "VBI";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('moduleAction','Manage Split');
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
			  $this->VbisSplit->create();								
			
			  if ($this->VbisSplit->save($this->data)) {	
			     $url = array('action'=>'index/page:1/group:'. $this->data['VbisSplit']['broker_id'] . "/month:" . $this->data['VbisSplit']['period_month'] . "/year:" . $this->data['VbisSplit']['period_year']);  			
				 $this->flash(__('VBI Split saved.', true), $url);									
			  } else {								
			  }
			}
			
			// Broker Group Options
			$this->loadModel('Users');			
			$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.name' => 'ASC'))); //shareholders only
			$this->set('brokerOptions',$brokerOptions);
			
			$this->layout='add-edit';									           
			
			$moduleHeading = 'VBI Split';
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
				$this->VbisSplit->validate,
				__('Save failed, fix the following errors:', true),
				'VbiAddForm'
			);
		} else {
			//redirect shareholders and banks to home page
			$this->redirect(array('controller'=>'Vbis','action'=>'homedisplay','home'));	
		}
	}
	
		function add_lender() {			
		if ($_SESSION['Auth']['User']['group_id'] < 4) { //all but banks			
		   if (!empty($this->data)) {								
			  $this->VbisSplit->create();								
			
			  if ($this->VbisSplit->save($this->data)) {	
			     $url = array('action'=>'index/page:1/lender:'. $this->data['VbisSplit']['lender_id'] . "/month:" . $this->data['VbisSplit']['period_month'] . "/year:" . $this->data['VbisSplit']['period_year']);  			
				 $this->flash(__('VBI Split saved.', true), $url);									
			  } else {								
			  }
			}
			
			// Lender Options
			$this->loadModel('ClaimsLender'); 
			$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender'));
			$this->set('lenderOptions',$lenderOptions);
			
			$this->layout='add-edit';									           
			
			$moduleHeading = 'VBI Split';
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
				$this->VbisSplit->validate,
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
			$this->redirect(array('controller'=>'VbisSplit','action'=>'homedisplay','home'));	
		} else {
			if (!$id && empty($this->data)) {			    
				$this->flash(sprintf(__('Invalid VBI Split', true)), array('action' => 'index'));			
			}
			if (!empty($this->data)) {
				if ($this->VbisSplit->save($this->data)) {
				   $url = array('action'=>'index/page:1/group:'. $this->data['VbisSplit']['broker_id'] . "/month:" . $this->data['VbisSplit']['period_month'] . "/year:" . $this->data['VbisSplit']['period_year']);  					   										
				   $this->flash(__('The VBI  Split has been saved.', true), $url);					
				}
			}
			if (empty($this->data)) {
				$this->data = $this->VbisSplit->read(null, $id);
				//backend security for not allowing anyone to access a Vbi if it is marked as actioned
				if($this->data['VbisSplit']['status']==1){ 
					if($_SESSION['Auth']['Users']['group_id']!=1){
						$this->redirect(Controller::referer());	
					}
				}
			}
			$this->layout='add-edit';

            // Broker Group Options
			$this->loadModel('Users');			
			$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.name' => 'ASC'))); //shareholders only
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
				$this->VbisSplit->validate,
				__('Save failed, fix the following errors:', true),
				'VbiEditForm'
			);	
		}
	}	
	
	function edit_lender($id = null) {
		if($_SESSION['Auth']['User']['group_id']==4){ //admin and brokers only	
			//redirect banks to home page
			$this->redirect(array('controller'=>'VbisSplit','action'=>'homedisplay','home'));	
		} else {
			if (!$id && empty($this->data)) {			    
				$this->flash(sprintf(__('Invalid VBI Split', true)), array('action' => 'index'));			
			}
			if (!empty($this->data)) {
				if ($this->VbisSplit->save($this->data)) {
				   $url = array('action'=>'index/page:1/lender:'. $this->data['VbisSplit']['lender_id'] . "/month:" . $this->data['VbisSplit']['period_month'] . "/year:" . $this->data['VbisSplit']['period_year']);  					   										
				   $this->flash(__('The VBI  Split has been saved.', true), $url);					
				}
			}
			if (empty($this->data)) {
				$this->data = $this->VbisSplit->read(null, $id);
				//backend security for not allowing anyone to access a Vbi if it is marked as actioned
				if($this->data['VbisSplit']['status']==1){ 
					if($_SESSION['Auth']['Users']['group_id']!=1){
						$this->redirect(Controller::referer());	
					}
				}
			}
			$this->layout='add-edit';

            // Lender Options
			$this->loadModel('ClaimsLender'); 
			$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender'));
			$this->set('lenderOptions',$lenderOptions);	
			
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
				$this->VbisSplit->validate,
				__('Save failed, fix the following errors:', true),
				'VbiEditForm'
			);	
		}
	}	
		
	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==1 || $_SESSION['Auth']['User']['group_id']==2) {
			if (!$id) {
				$this->flash(sprintf(__('Invalid VBI Split', true)), array('action' => 'index'));
			}
			if ($this->VbisSplit->delete($id)) {
				$this->flash(__('VBI Split deleted', true), array('action' => 'index'));
			}
			$this->flash(__('VBI was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->redirect(array('controller'=>'VbisSplits','action'=>'index'));	
		}
	}
	
	function lock($id = null) {
		if($_SESSION['Auth']['User']['group_id']==1) {
			if (!$id) {
				$this->flash(sprintf(__('Invalid VBI Split', true)), array('action' => 'index'));
			}
			if ($this->VbisSplit->saveField('status',1,false)) {
				$this->flash(__('VBI Split back in the unprocessed queue', true), array('action' => 'index'));
			}
			$this->flash(__('VBI Split needs to be updated', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->redirect(array('controller'=>'VbisSplit','action'=>'homedisplay','home'));	
		}
	}
	
	function extractreport(){
		$this->loadModel('Users');
		
		// Lenders List
		$this->loadModel('ClaimsLender'); 
		$lenderOptions = $this->ClaimsLender->find('all', array('order' => array('ClaimsLender.lender' => 'ASC'))); 
		$this->set('lenderOptions',$lenderOptions);	
		
        // Brokers List
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.name' => 'ASC'))); //shareholders only
		$this->set('brokerOptions',$brokerOptions);	
			
		//$this->layout='ajax-large';
		//$moduleHeading = 'Transaction Report';
		$this->set('moduleHeading',$moduleHeading);	
		
		$moduleHeading = "VBI";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('moduleAction','Reports Split');
		$this->set('helpURL','Vbi');
		
		//layout options
		$this->set('manageVBIStructure', true);
		$this->set('manageVBISplit', true);
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);	
		
		$reporting = true;
		$this->set('reportingVBIStructure', $reporting);
		$this->set('reportingVBISplit', $reporting);
		$this->set('reportingVBIBreakUp', $reporting);
		$this->set('reportingVBIGraph', $reporting);
		$this->set('manageVBISetting', $reporting);
			
	}
	
	function reportClose()  {
		$this->set('page',"");
	}
	
	function reportOutput() {
		if (($this->params['named']['vbi'] != 1) || ($this->params['named']['vbiexception'] != 1) || ($this->params['named']['vbistructure'] != 1) || ($this->params['named']['vbisplit'] != 1))  {
		   $url = array('action'=>'reportClose');  			
		   $this->flash(__('Please update the variables before generating the VBI Split Report.', true), $url);   	
		   
		   $this->set('$vbiNotSet',"true");		
		   		  
		}  else {
		
		// Exclusions - Brokers
		$excludeBrokersSQLByBroker = "";
		$excludeBrokersSQLByLender = "";
		
		if ($this->params['named']['group'] != "")  {
		   $parBroker = $this->params['named']['group'];
		   $parBroker = substr($parBroker, 0, strlen($parBroker) - 1);
		  
		   $excludeBrokers = explode(",", $parBroker);
		   foreach ($excludeBrokers as $excludeBroker)  {
			  if ($excludeBrokersSQLByLender <> "")  {
			 	  $excludeBrokersSQLByBroker .= " AND ";
				  $excludeBrokersSQLByLender .= " AND ";
			  }
			 
			  $excludeBrokersSQLByBroker .= 'Users.parent_user_id <> ' . $excludeBroker . " ";
			  $excludeBrokersSQLByLender .= 'Users.parent_user_id <> ' . $excludeBroker . " ";	
		   }
		   
		   $this->set('excludeBrokers',$excludeBrokers);		
		}	
		
		// Exclusions - Lenders
		$excludeLendersSQLByBroker = "";
		$excludeLendersSQLByLender = "";
		
		if ($this->params['named']['lender'] != "")  {
		   $parLender = $this->params['named']['lender'];
		   $parLender = substr($parLender, 0, strlen($parLender) - 1);
		
		   $excludeLenders = explode(",", $parLender);
		   foreach ($excludeLenders as $excludeLender)  {
		      if ($excludeLendersSQLByLender <> "")  {
		   	      $excludeLendersSQLByBroker .= " AND ";
			      $excludeLendersSQLByLender .= " AND ";
		      }
		   
		      if ($excludeLender == 1)  {
			     $excludeLendersSQLByBroker .= 'Claims.lender_id <> ' . $excludeLender . ' AND Claims.lender_id <> 17';
		         $excludeLendersSQLByLender .= 'Lenders.id <> ' . $excludeLender . ' AND Lenders.id <> 17';				  
			  } else  {
		         $excludeLendersSQLByBroker .= 'Claims.lender_id <> ' . $excludeLender . " ";
		         $excludeLendersSQLByLender .= 'Lenders.id <> ' . $excludeLender . " ";	
			  }
		   }	
		   
		   $this->set('excludeLenders',$excludeLenders);		
		}
		
//		// Exclusions - Lender VBI
//		$excludeLenderVBI = "";
//		//$excludeBrokersSQLByLender = "";
//		
//		if ($this->params['named']['lenderVBI'] != "")  {
//		   $parLenderVBI = $this->params['named']['lenderVBI'];
//		   $parLenderVBI = substr($parLenderVBI, 0, strlen($parLenderVBI) - 1);
//		  
//		   $excludeLenderVBIs = explode(",", $parLenderVBI);
//		   foreach ($excludeLenderVBIs as $excludeLenderVBI)  {
//			  if ($excludeLenderVBI <> "")  {
//			 	  $excludeLenderVBI .= " AND ";
//				 // $excludeBrokersSQLByLender .= " AND ";
//			  }
//			 
//			  $excludeLenderVBI .= 'Users.parent_user_id <> ' . $excludeLenderVBIs . " ";
//			  //$excludeBrokersSQLByLender .= 'Users.parent_user_id <> ' . $excludeLenderVBIs . " ";	
//		   }
//		   
//		   $this->set('excludeLenderVBIs',$excludeLenderVBIs);		
//		}
				
		// Data Retrieval Conditions
		$conditions = array();
		
		if (isset($this->params['named']['year']))  {
		   $start_date = $this->params['named']['year'] . "-" . $this->params['named']['month'] . "-01 00:00:00";	
		} else  {
		   $start_date = date("Y-m") . "-01 00:00:00";
		}
		$conditions[] =  array('VbisSplit.start_date =' => $start_date);				    	
		
		// Brokers List
		$this->loadModel('Users');
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.CompanyName' => 'ASC'))); //shareholders only
		$this->set('brokerOptions',$brokerOptions);		
		
		// Lenders List
		$this->loadModel('ClaimsLender'); 
		$lenderOptions = $this->ClaimsLender->find('all'); 
		$this->set('lenderOptions',$lenderOptions);	
		
		// VBI Split Data			
		$this->VbisSplit->recursive = 1;
		$vbisSplits = $this->VbisSplit->find('all', array('order' => array('VbisSplit.broker_id' => 'ASC'), 'conditions' => $conditions));
		$this->set('vbisSplits',$vbisSplits);
		// ***************************************************************************************************************************	
		// Claim Data By Broker (VBI)
		// ***************************************************************************************************************************	
		$this->loadModel('Claims'); 
		if ($this->params['named']['status'] == '')  {		
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			  					 	      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],
									      'Claims.vbi = 1',
										  $excludeLendersSQLByBroker,
										  $excludeBrokersSQLByBroker
									      );
		} else  {
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			  					 	      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],
									      'Claims.vbi = 1',
										  'Claims.actioned = ' . $this->params['named']['status'],
										  $excludeLendersSQLByBroker,
										  $excludeBrokersSQLByBroker
									      );
		}
		
        $options['joins'] = array(
           array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
           )
        );
        $options['fields'] = array('Users.companyName', 'Users.parent_user_id', 'SUM(Claims.amount) AS amounts', 'Claims.*');
		$options['order'] = array('Users.companyName ASC, Claims.settlementDate DESC');		
        $options['group'] = array('Users.parent_user_id');
		
        $claimsBroker = $this->Claims->find('all', $options);		
		$this->set('claimsBroker',$claimsBroker);
		// ***************************************************************************************************************************	
		// Claim Data By Broker (Non-VBI)
		// ***************************************************************************************************************************	
		$this->loadModel('Claims'); 
		if ($this->params['named']['status'] == '')  {		
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			  					 	      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],
//									      'Claims.vbi <> 1',
										  '(Claims.vbi = "0" or Claims.vbi is null)',
										  $excludeLendersSQLByBroker,
										  $excludeBrokersSQLByBroker
									      );
		} else  {
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			  					 	      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],
									      //'Claims.vbi <> 1',
										  '(Claims.vbi = "0" or Claims.vbi is null)',
										  'Claims.actioned = ' . $this->params['named']['status'],
										  $excludeLendersSQLByBroker,
										  $excludeBrokersSQLByBroker
									      );
		}
		
        $options['joins'] = array(
           array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
           )
        );
        $options['fields'] = array('Users.companyName', 'Users.parent_user_id', 'SUM(Claims.amount) AS amounts', 'Claims.*');
		$options['order'] = array('Users.companyName ASC, Claims.settlementDate DESC');		
        $options['group'] = array('Users.parent_user_id');
		
        $claimsBrokerNonVBI = $this->Claims->find('all', $options);		
		$this->set('claimsBrokerNonVBI',$claimsBrokerNonVBI);
		// ***************************************************************************************************************************		
		// Claim Data By Lender
		// ***************************************************************************************************************************	
		$options = '';	
		if ($this->params['named']['status'] == '')  {			
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			 						      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],										  
									      'Claims.vbi = 1',
										  $excludeLendersSQLByLender,	
										  $excludeBrokersSQLByLender									  
									      );
		} else  {
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			 						      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],
									      'Claims.vbi = 1',
										  'Claims.actioned = ' . $this->params['named']['status'],
										  $excludeLendersSQLByLender,
										  $excludeBrokersSQLByLender										
									      );
		}
		
        $options['joins'] = array(
           array('table' => 'claims_lenders',
                'alias' => 'lenders',
                'type' => 'INNER',
                'conditions' => array('Claims.lender_id = lenders.id')
           ),
		    array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
           )
        );

        $options['fields'] = array('lenders.lender', 'lenders.id', 'SUM(Claims.amount) AS amounts', 'Claims.*', 'Users.parent_user_id');
		$options['order'] = array('lenders.lender ASC');		
        $options['group'] = array('lenders.id');
		
        $claimsLender = $this->Claims->find('all', $options);		
		$this->set('claimsLender',$claimsLender);
		// ***************************************************************************************************************************		
		// Claim Data By Non VBI
		// ***************************************************************************************************************************	
		$options = '';		
		if ($this->params['named']['status'] == '')  {		
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
									      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],
									      '(Claims.vbi = "0" or Claims.vbi is null)',
										  $excludeLendersSQLByBroker,
										  $excludeBrokersSQLByBroker
									      );
		} else  {
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
									      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],
									      '(Claims.vbi = "0" or Claims.vbi is null)',
										  'Claims.actioned = ' . $this->params['named']['status'],
										  $excludeLendersSQLByBroker,
										  $excludeBrokersSQLByBroker
									      );
		}
		
        $options['joins'] = array(
           array('table' => 'claims_lenders',
                'alias' => 'lenders',
                'type' => 'INNER',
                'conditions' => array('Claims.lender_id = lenders.id')
           ),
		   array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
           )
        );
        $options['fields'] = array('lenders.lender', 'lenders.id', 'SUM(Claims.amount) AS amounts', 'Claims.*');
		$options['order'] = array('Claims.settlementDate DESC');		
        $options['group'] = array('lenders.id');
		
        $claimsNonVbi = $this->Claims->find('all', $options);		
		$this->set('claimsNonVbi',$claimsNonVbi);
		// ***************************************************************************************************************************
		// VBI Structure
		// ***************************************************************************************************************************	
		$options = '';
		$this->loadModel('Vbis'); 				
		//$options['conditions'] = array('start_date = \'' . $start_date . '\'' );              
		
        $vbiStructures = $this->Vbis->find('all', $options);		
		$this->set('vbiStructures',$vbiStructures);
		// ***************************************************************************************************************************	
		// NAB Quarterly VBI Business
		// (Only get data for the first two months in given quarter).
		// ***************************************************************************************************************************	
//		$q1 = array(1,2,3);
//		$q2 = array(4,5,6);
//		$q3 = array(7,8,9);
//		$q4 = array(10,11,12);
//		
//        if (in_array($this->params['named']['month'], $q1))  {
//		   $startMonth = $q1[0];	
//		   $endMonth = $q1[1]; 			 
//		}
//		
//		if (in_array($this->params['named']['month'], $q2))  {
//		   $startMonth = $q2[0];
//		   $endMonth = $q2[1]; 	 			 
//		}
//		
//		if (in_array($this->params['named']['month'], $q3))  {
//		   $startMonth = $q3[0];
//		   $endMonth = $q3[1]; 	 			 
//		}
//		
//		if (in_array($this->params['named']['month'], $q4))  {
//		   $startMonth = $q4[0];	
//		   $endMonth = $q4[1];  			 
//		}
//		
//		$options = '';	
//		if ($this->params['named']['status'] == '')  {			
//		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
//									      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) >= ' . $startMonth . ' AND MONTH(FROM_UNIXTIME(Claims.settlementDate)) <= ' . $endMonth ,
//									      'Claims.vbi = 1',
//									      'Claims.lender_id = 7'
//									      );
//		} else  {
//		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
//									      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) >= ' . $startMonth . ' AND MONTH(FROM_UNIXTIME(Claims.settlementDate)) <= ' . $endMonth ,
//									      'Claims.vbi = 1',
//									      'Claims.lender_id = 7',
//										  'Claims.actioned = ' . $this->params['named']['status']
//									      );
//		}
//		
//        $options['joins'] = array(
//           array('table' => 'users',
//                'alias' => 'users',
//                'type' => 'INNER',
//                'conditions' => array('Claims.claims_user_broker = users.id')
//           )
//        );
//        $options['fields'] = array('users.parent_user_id', 'Claims.claims_user_broker', 'SUM(Claims.amount) AS amounts', 'Claims.*');
//		$options['order'] = array('Claims.settlementDate DESC');		
//        $options['group'] = array('users.parent_user_id');
//		
//        $claimsNAB = $this->Claims->find('all', $options);		
//		$this->set('claimsNAB',$claimsNAB);
		// ***************************************************************************************************************************					
		// Claim Data with Overridden VBI
		// ***************************************************************************************************************************	
		$options = '';
		$this->loadModel('Claims'); 
		if ($this->params['named']['status'] == '')  {		
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			  					 	      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],									      
										  $excludeLendersSQLByBroker,
										  $excludeBrokersSQLByBroker,
										  'vbiOverrideUser <> ""'
									      );
		} else  {
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			  					 	      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],									      
										  'Claims.actioned = ' . $this->params['named']['status'],
										  $excludeLendersSQLByBroker,
										  $excludeBrokersSQLByBroker,
										  'vbiOverrideUser <> ""'
									      );
		}
		
        $options['joins'] = array(
           array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
           )
        );
        $options['fields'] = array('Users.companyName', 'Users.parent_user_id', 'Claims.*');		
		
        $claimsOverridden = $this->Claims->find('all', $options);		
		$this->set('claimsOverridden',$claimsOverridden);
		
		// ***************************************************************************************************************************		
		// All Claim Data
		// ***************************************************************************************************************************	
		$options = '';	
		if ($this->params['named']['status'] == '')  {			
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			 						      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],										  									      
										  $excludeLendersSQLByLender,	
										  $excludeBrokersSQLByLender									  
									      );
		} else  {
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			 						      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],									     
										  'Claims.actioned = ' . $this->params['named']['status'],
										  $excludeLendersSQLByLender,
										  $excludeBrokersSQLByLender										
									      );
		}
		
        $options['joins'] = array(
           array('table' => 'claims_lenders',
                'alias' => 'lenders',
                'type' => 'INNER',
                'conditions' => array('Claims.lender_id = lenders.id')
           ),
		    array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
           )
        );

        $options['fields'] = array('lenders.lender', 'lenders.id', 'Claims.*', 'Users.*');
		$options['order'] = array('Claims.settlementDate DESC');		       
		
        $claimsAll = $this->Claims->find('all', $options);		
		$this->set('claimsAll',$claimsAll);		
		// ***************************************************************************************************************************	
		// Claim Data By Broker
		// ***************************************************************************************************************************	
		$this->loadModel('Claims'); 				
		$options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
									   'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month']
									   //'Claims.vbi = 1',									    
									   //'Users.parent_user_id = ' .  $this->params['named']['group'] 
									   );
        $options['joins'] = array(
           array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
           ),
		   array('table' => 'claims_lenders',
                'alias' => 'Lenders',
                'type' => 'INNER',
                'conditions' => array('Claims.lender_id = Lenders.id')
           )
        );
				
        $options['fields'] = array('Users.*', 'Claims.*', "CASE Claims.settlementDate WHEN 0 THEN '-NA-' Else FROM_UNIXTIME(Claims.settlementDate) END AS ClaimSettlementDate", 'SUM(Claims.amount) AS amounts', 'Lenders.lender');				
  		$options['order'] = array('Users.parent_user_id', 'Lenders.lender', 'Users.name', 'Users.surname', 'Claims.settlementDate DESC');		     						   
		$options['group'] = array('Claims.id');
		
        $claimsByBroker = $this->Claims->find('all', $options);		
		$this->set('claimsByBroker',$claimsByBroker);					
		// ***************************************************************************************************************************
		// VBI Setting - Management Fee
		// ***************************************************************************************************************************	
		$options = '';
		$this->loadModel('VbisSetting'); 						      
		
		$settingMgtFee = $this->VbisSetting->find('first', array('conditions' => array("key" => 'Management Fee')));        		
		$this->set('settingMgtFee',$settingMgtFee);
		// ***************************************************************************************************************************		
		
		$this->set('period', date('F', strtotime($start_date)) . " " . $this->params['named']['year']);
		
	    $this->render('vbisSplit-export_xls','vbisSplit-export_xls');
		}
	}
	
	function extractreportBreakUp(){
		$this->loadModel('Users');
		
        // Brokers List
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.name' => 'ASC'))); //shareholders only
		$this->set('brokerOptions',$brokerOptions);	
			
		$this->layout='ajax';
		$moduleHeading = 'Transaction Report';
		$this->set('moduleHeading',$moduleHeading);		
	}
	
	function reportOutputBreakUp(){
		// Data Retrieval Conditions
		$conditions = array();
		//if ((isset($this->params['named']['group'])) && ((int)trim($this->params['named']['group'])>0)) {
//		   $conditions[] =  array('VbisSplit.dealer_id =' => (int)trim($this->params['named']['group']));
//		}	
		
		if (isset($this->params['named']['year']))  {
		   $start_date = $this->params['named']['year'] . "-" . $this->params['named']['month'] . "-01 00:00:00";	
		} else  {
		   $start_date = date("Y-m") . "-01 00:00:00";
		}
		$conditions[] =  array('VbisSplit.start_date =' => $start_date);				    	
		
		// Brokers List
		$this->loadModel('Users');
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.CompanyName' => 'ASC'))); //shareholders only
		$this->set('brokerOptions',$brokerOptions);		
		
		// Lenders List
		$this->loadModel('ClaimsLender'); 
		$lenderOptions = $this->ClaimsLender->find('all'); 
		$this->set('lenderOptions',$lenderOptions);	
		
		// ***************************************************************************************************************************	
		// Selected Broker Name
		// ***************************************************************************************************************************	
		$brokerName = $this->Users->find('all',array('conditions' => array('Users.id' => $this->params['named']['group'])));
		$this->set('brokerName', $brokerName);		
		// ***************************************************************************************************************************	
		// Broker Group Names
		// ***************************************************************************************************************************	
		$this->loadModel('Users'); 				
		$options['conditions'] = array('Users.id = ' .  $this->params['named']['group'] 
									   );        
        $options['fields'] = array('Users.*');			        
		
        $brokerGroups = $this->Users->find('all', $options);		
		$this->set('brokerGroups',$brokerGroups);		
		// ***************************************************************************************************************************	
		// Claim Data For Chosen Broker
		// ***************************************************************************************************************************	
		$this->loadModel('Claims'); 				
		$options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
									   'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],
									   //'Claims.vbi = 1',									    
									   'Users.parent_user_id = ' .  $this->params['named']['group'] 
									   );
        $options['joins'] = array(
           array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
           ),
		   array('table' => 'claims_lenders',
                'alias' => 'Lenders',
                'type' => 'INNER',
                'conditions' => array('Claims.lender_id = Lenders.id')
           )
        );
				
        $options['fields'] = array('Users.*', 'Claims.*', "CASE Claims.settlementDate WHEN 0 THEN '-NA-' Else FROM_UNIXTIME(Claims.settlementDate) END AS ClaimSettlementDate", 'SUM(Claims.amount) AS nyree', 'Lenders.lender');
		
		switch ($this->params['named']['sort'])  {
		   case "lender": $options['order'] = array('Lenders.lender', 'Users.name', 'Users.surname', 'Claims.settlementDate DESC'); break;		     		
		   case "broker": $options['order'] = array('Users.name', 'Users.surname', 'Lenders.lender', 'Claims.settlementDate DESC'); break;		
		   case "company": $options['order'] = array('Users.CompanyName', 'Lenders.lender', 'Claims.settlementDate DESC'); break;		     	
		}
		   
		$options['group'] = array('Claims.id');
		
        $claims = $this->Claims->find('all', $options);		
		$this->set('claims',$claims);				
		// ***************************************************************************************************************************
		// VBI Split
		// ***************************************************************************************************************************	
		if (isset($this->params['named']['year']))  {
		   $start_date = $this->params['named']['year'] . "-" . $this->params['named']['month'] . "-01 00:00:00";	
		} else  {
		   $start_date = date("Y-m") . "-01 00:00:00";
		}
		
  	    $options = "";
		$options['conditions'] = array('broker_id = ' .  $this->params['named']['group'],
		                               'start_date = \'' . $start_date . '\'' );
		$this->loadModel('VbisSplit'); 				
		//$options['conditions'] = array('start_date = \'' . $start_date . '\'' );              
		
        $vbiSplits = $this->VbisSplit->find('all', $options);		
		$this->set('vbiSplits',$vbiSplits);		
		// ***************************************************************************************************************************	
		
		// ***************************************************************************************************************************		
		// Claim Data By Lender
		// ***************************************************************************************************************************	
		$options = '';				
 	    $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
			 						      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],										  
									      'Claims.vbi = 1'										 						  
									      );		
        $options['joins'] = array(
           array('table' => 'claims_lenders',
                'alias' => 'lenders',
                'type' => 'INNER',
                'conditions' => array('Claims.lender_id = lenders.id')
           ),
		    array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
           )
        );

        $options['fields'] = array('lenders.lender', 'lenders.id', 'SUM(Claims.amount) AS amounts', 'Claims.*', 'Users.parent_user_id');
		$options['order'] = array('lenders.lender ASC');		
        $options['group'] = array('lenders.id');
		
        $claimsLender = $this->Claims->find('all', $options);		
		$this->set('claimsLender',$claimsLender);
		// ***************************************************************************************************************************	
		
		// ***************************************************************************************************************************
		// VBI Structure
		// ***************************************************************************************************************************	
		$options = '';
		$this->loadModel('Vbis'); 						      
		
        $vbiStructures = $this->Vbis->find('all', $options);		
		$this->set('vbiStructures',$vbiStructures);
		// ***************************************************************************************************************************	
		
		// ***************************************************************************************************************************
		// VBI Setting - Management Fee
		// ***************************************************************************************************************************	
		$options = '';
		$this->loadModel('VbisSetting'); 						      
		
		$settingMgtFee = $this->VbisSetting->find('first', array('conditions' => array("key" => 'Management Fee')));        		
		$this->set('settingMgtFee',$settingMgtFee);
		// ***************************************************************************************************************************	
				
		// ***************************************************************************************************************************	
		// Sort Order
		// ***************************************************************************************************************************	
		$this->set('reportSort',$this->params['named']['sort']);
		// ***************************************************************************************************************************	
		
		$this->set('period', date('F', strtotime($start_date)) . " " . $this->params['named']['year']);
		
		$this->render('vbisSplitBreakup-export_xls','vbisSplitBreakUp-export_xls');
	}	
	
	function extractreportVbigraph(){
		$this->loadModel('Users');
		
        // Brokers List
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.name' => 'ASC'))); //shareholders only
		$this->set('brokerOptions',$brokerOptions);	
			
		$this->layout='ajax';
		$moduleHeading = 'Transaction Report';
		$this->set('moduleHeading',$moduleHeading);		
	}	
	
	function reportOutputVbigraph(){
		date_default_timezone_set('Australia/Melbourne');
		
		// Data Retrieval Conditions
		$conditions = array();
		
		if (isset($this->params['named']['year']))  {
		   $start_date = $this->params['named']['year'] . "-" . $this->params['named']['month'] . "-01 00:00:00";	
		} else  {
		   $start_date = date("Y-m") . "-01 00:00:00";
		}
		$conditions[] =  array('VbisSplit.start_date =' => $start_date);				    	
		
		// Brokers List
		$this->loadModel('Users');
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.CompanyName' => 'ASC'))); //shareholders only
		$this->set('brokerOptions',$brokerOptions);		
		
		// Lenders List
		$this->loadModel('ClaimsLender'); 
		$lenderOptions = $this->ClaimsLender->find('all'); 
		$this->set('lenderOptions',$lenderOptions);	
		
		// ***************************************************************************************************************************	
		// Claim Data By Lender For Year to Date
		// ***************************************************************************************************************************	
//		$this->loadModel('Claims'); 				
//		$options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
//									   //'Claims.vbi = 1',									    									  
//									   );
//        $options['joins'] = array(
//           array('table' => 'claims_lenders',
//                'alias' => 'Lenders',
//                'type' => 'INNER',
//                'conditions' => array('Claims.lender_id = Lenders.id')
//           )
//        );
//        $options['fields'] = array('Lenders.*', 'Claims.*', "CASE Claims.settlementDate WHEN 0 THEN '-NA-' Else FROM_UNIXTIME(Claims.settlementDate) END AS ClaimSettlementDate", 'SUM(Claims.amount) AS amounts');
//		$options['order'] = array('Claims.lender_id', 'Claims.lender_id ASC');		        
//		$options['group'] = array('Claims.lender_id');
//		
//        $claimsYTD = $this->Claims->find('all', $options);		
//		$this->set('claimsYTD',$claimsYTD);				
		// ***************************************************************************************************************************	
		// Selection Criteria
		// ***************************************************************************************************************************	
		$options = "";
		
		// Report Data Selection By Month
		if ((isset($this->params['named']['year'])) && (isset($this->params['named']['month'])))  {
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['year'],
									      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['month'],									    									  
									     );
									   
		   $this->set('period', date('M', strtotime($start_date)) . " " . $this->params['named']['year']);	
		}
		
		// Report Data Selection By Quarter				
		if ((isset($this->params['named']['qtryear'])) && (isset($this->params['named']['qtrmonth'])))  {
		   if ($this->params['named']['qtrmonth'] == 0)  {
		      $startMonth = 1;	
			  $startMonthName = "Jan";
		      $endMonth = 3; 
			  $endMonthName = "Mar";			 
		   }
		
		   if ($this->params['named']['qtrmonth'] == 1)  {
		      $startMonth = 4;
			  $startMonthName = "Apr";
		      $endMonth = 6; 
			  $endMonthName = "Jun";	 			 
		   }
		
		   if ($this->params['named']['qtrmonth'] == 2)  {
		      $startMonth = 7;
			  $startMonthName = "Jul";
		      $endMonth = 9; 	
			  $endMonthName = "Sep"; 			 
		   }
		
		   if ($this->params['named']['qtrmonth'] == 3)  {
		      $startMonth = 10;	
			  $startMonthName = "Oct";
		      $endMonth = 12; 
			  $endMonthName = "Dec"; 			 
	      }
		
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['qtryear'],
									      'MONTH(FROM_UNIXTIME(Claims.settlementDate)) >= ' . $startMonth . ' AND MONTH(FROM_UNIXTIME(Claims.settlementDate)) <= ' . $endMonth ,									    									  
									     );
									   
		   $this->set('period', $startMonthName . " - " . $endMonthName  . " " . $this->params['named']['qtryear']);	
		}
		
		// Report Data Selection By Year To Date			
		if (isset($this->params['named']['ytd'])) {
		   $options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . $this->params['named']['ytd'],									      								    									  
									     );
									   
		   $this->set('period', "YTD " . $this->params['named']['ytd']);
		}
		
		// Report Data Selection By Date Range			
		if ((isset($this->params['named']['todate'])) && (isset($this->params['named']['fromdate'])))  {		  
		   $toDate = strtotime(mysql_real_escape_string($this->params['named']['todate']));
		   $fromDate = strtotime(mysql_real_escape_string($this->params['named']['fromdate']));
		   
		   $options['conditions'] = array('Claims.settlementDate >= ' . $fromDate . ' AND Claims.settlementDate <= ' . $toDate									      								    									  
									     );
									   
		   $this->set('period', $this->params['named']['fromdate'] . " - " . $this->params['named']['todate']);
		}
		 	
		// ***************************************************************************************************************************						
		// Claim Data By Lender For Selection Criteria
		// ***************************************************************************************************************************	
		$this->loadModel('Claims'); 						
        $options['joins'] = array(
           array('table' => 'claims_lenders',
                'alias' => 'Lenders',
                'type' => 'INNER',
                'conditions' => array('Claims.lender_id = Lenders.id')
           )
        );
        $options['fields'] = array('Lenders.*', 'Claims.*', "CASE Claims.settlementDate WHEN 0 THEN '-NA-' Else FROM_UNIXTIME(Claims.settlementDate) END AS ClaimSettlementDate", 'SUM(Claims.amount) AS amounts');
		//$options['order'] = array('Claims.lender_id', 'Claims.lender_id ASC');	
		$options['order'] = array('Lenders.lender ASC');		        
		$options['group'] = array('Claims.lender_id');
		
        $claimsPeriod = $this->Claims->find('all', $options);		
		$this->set('claimsPeriod',$claimsPeriod);				
		// ***************************************************************************************************************************							
		// Claim Data By Broker Group For Selection Criteria
		// ***************************************************************************************************************************	
		$this->loadModel('Claims'); 						
        $options['joins'] = array(
           array('table' => 'claims_lenders',
                'alias' => 'Lenders',
                'type' => 'INNER',
                'conditions' => array('Claims.lender_id = Lenders.id')
           ),
		   array('table' => 'users',
                'alias' => 'Users',
                'type' => 'INNER',
                'conditions' => array('Claims.claims_user_broker = Users.id')
	       )
        );
        $options['fields'] = array('Lenders.*', 'Claims.*', 'Users.*', "CASE Claims.settlementDate WHEN 0 THEN '-NA-' Else FROM_UNIXTIME(Claims.settlementDate) END AS ClaimSettlementDate", 'SUM(Claims.amount) AS amounts');
		$options['order'] = array('Users.parent_user_id ASC', 'Claims.lender_id ASC');		        
		$options['group'] = array('Users.parent_user_id', 'Claims.lender_id');
		
        $claimByBrokerGroups = $this->Claims->find('all', $options);		
		$this->set('claimByBrokerGroups',$claimByBrokerGroups);				
		// ***************************************************************************************************************************	
		
		$this->render('vbisSplitVbigraph-export_xls','vbisSplitVbigraph-export_xls');
	}	
}
?>