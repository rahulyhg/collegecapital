<?php
class ClaimsController extends AppController {

	var $name = 'Claims';
	var $components = array('JQValidator.JQValidator','RSS');
	var $helpers = array('Form', 'Html', 'Javascript', 'Time', 'FormatEpochToDate', 'CustomDisplayFunctions','JQValidator.JQValidator');
		
	function homedisplay() {
		$this->loadModel('Users'); //if it's not already loaded
		if($_SESSION['Auth']['User']['group_id']==1){
			$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3), 'order' => array('Users.name' => 'ASC')));
		} else {
			$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3, 'Users.parent_user_id' => $_SESSION['Auth']['User']['id']), 'order' => array('Users.name' => 'ASC'))); //brokers only
		}
              
		$this->set('brokerOptions',$brokerOptions);

		//$this->set('queryString',((strlen($_SERVER['QUERY_STRING'])>0))?"?".$_SERVER['QUERY_STRING']:"");
//echo "<!-- ";var_dump($this->params['named']); echo " -->";
		
		$this->Claim->recursive = 0;		
		if(isset($_GET['sel'])){
echo "<!-- 0.1 -->\n";
			if(trim($_GET['sel']=='all')){
				if($_SESSION['Auth']['User']['group_id']==1){		
					$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0')));	
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
				} elseif($_SESSION['Auth']['User']['group_id']==2) {
					$brokerList = "";
					foreach($brokerOptions as $brokers):
						$brokerList .= $brokers['Users']['id'].",";
					endforeach;
					$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
					$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')')));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
				} else {
					$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'])));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id']),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					
				}
			} else {
echo "<!-- 0.2 -->\n";
				if($_SESSION['Auth']['User']['group_id']==1){
					//find total count of records
					$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0','Claim.clientName LIKE' => ''.trim($_GET['sel']).'%')));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.clientName LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
				}  elseif($_SESSION['Auth']['User']['group_id']==2) {
					$brokerList = "";
					foreach($brokerOptions as $brokers):
						$brokerList .= $brokers['Users']['id'].",";
					endforeach;
					$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
					$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')','Claim.clientName LIKE' => ''.trim($_GET['sel']).'%')));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')', 'Claim.clientName LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
				} else {
					//find total count of records
					$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'],'Claim.clientName LIKE' => ''.trim($_GET['sel']).'%')));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.clientName LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					
				}
			}
		} elseif(isset($this->params['named']['group']) && !(int)trim($this->params['named']['group'])==0){
echo "<!-- 1 -->\n";
			if((int)trim($this->params['named']['group'])>0){
echo "<!-- 2 -->\n";
				//add broker filter when admin and shareholdersa re logged in
				if(($_SESSION['Auth']['User']['group_id']==1 || $_SESSION['Auth']['User']['group_id']==2) && !isset($this->params['named']['lender'])){
					//find total count of records
echo "<!-- 2.1 -->\n";
					$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker =' => (int)trim($this->params['named']['group']))));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker =' => (int)trim($this->params['named']['group'])),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
				} else { //add lender filter when broker is logged in
				    // CHANGE REQUEST Nyree 06/07/2015
					// Combining of ANZ and ANZ Edge Transactions
				    if (($this->params['named']['group'] == 1) || ($this->params['named']['group'] == 17)) {
			           $condLender = '(Claim.lender_id = 1 OR Claim.lender_id = 17)';
			        } else  {
					   $condLender = '(Claim.lender_id = ' . $this->params['named']['group'] . ')';
			        }
			        // END CHAGE REQUEST
						
					//find total count of records
echo "<!-- 2.2 -->\n";
					if($_SESSION['Auth']['User']['group_id']==1) {
						$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0','Claim.lender_id =' => (int)trim($this->params['named']['group']))));
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0',$condLender),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
echo "<!-- 2.2.1 -->\n";
					} else {
						$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.lender_id =' => (int)trim($this->params['named']['group']))));
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], $condLender),'order' => array('Claim.settlementDate' => 'DESC'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
echo "<!-- 2.2.2 -->\n";
					}
				}
			} else {
echo "<!-- 0.3 -->\n";
				if($_SESSION['Auth']['User']['group_id']==1){
					$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0')));	
					//$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0'), 'order' => array('Claim.settlementDate' => 'DESC'), 'limit'=>$recordCount)));	
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));	
echo "<!-- 0.3.1 -->\n";
				} elseif($_SESSION['Auth']['User']['group_id']==2) {
					$brokerList = "";
					foreach($brokerOptions as $brokers):
						$brokerList .= $brokers['Users']['id'].",";
					endforeach;
					$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
					$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')')));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
echo "<!-- 0.3.2 -->\n";
				} else {
					$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'])));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id']),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
echo "<!-- 0.3.3 -->\n";
				}
			}
		} elseif(isset($_GET['search'])){
echo "<!-- 0.4 -->\n";
			if($_SESSION['Auth']['User']['group_id']==1){
				//find total count of records for super user
				$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0','Claim.clientName LIKE' => '%'.trim($_GET['search']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.clientName LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
			} elseif ($_SESSION['Auth']['User']['group_id']==2) { //for share holders
				$brokerList = "";
				foreach($brokerOptions as $brokers):
					$brokerList .= $brokers['Users']['id'].",";
				endforeach;
				$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
				$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')', 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')', 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
			} else {
				//find total count of records for brokers
				$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%')));
				$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
			}
		} else {
echo "<!-- 0.5 -->\n";
			if($_SESSION['Auth']['User']['group_id']==1){
				$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.actioned = 0')));	
				$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));	
echo "<!-- 0.5.1 -->\n";
			} elseif($_SESSION['Auth']['User']['group_id']==2) {
				$brokerList = "";
				foreach($brokerOptions as $brokers):
					$brokerList .= $brokers['Users']['id'].",";
				endforeach;
				$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
				$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')')));
				$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker IN ('.$brokerList.')'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
echo "<!-- 0.5.2 -->\n";
			} else {
				$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'])));
				$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.actioned = 0','Claim.claims_user_broker' => $_SESSION['Auth']['User']['id']),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));	
echo "<!-- 0.5.3 -->\n";
			}
		}
		$this->set('claims', $this->paginate());		
		
		$this->loadModel('ClaimsGoodsdesc'); //if it's not already loaded		
		$goodsDescOptions = $this->ClaimsGoodsdesc->find('all'); //or whatever conditions you want
		$this->set('goodsDescOptions',$goodsDescOptions);
		
		$this->loadModel('ClaimsIndustryprofile'); //if it's not already loaded
		$industryProfileOptions = $this->ClaimsIndustryprofile->find('all'); //or whatever conditions you want
		$this->set('industryProfileOptions',$industryProfileOptions);
		
		$this->loadModel('ClaimsLender'); //if it's not already loaded
		$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender')); //or whatever conditions you want
		$this->set('lenderOptions',$lenderOptions);
		
		$this->loadModel('ClaimsProducttype'); //if it's not already loaded
		$productTypeOptions = $this->ClaimsProducttype->find('all'); //or whatever conditions you want
		$this->set('productTypeOptions',$productTypeOptions);
		
		//display Interest Rate Documents
		//first get all dictinct cms_user_ids
		$this->loadModel('Rate');
		$bankIDs = $this->Rate->find('all', array('fields' => 'Rate.cms_user_id','group' => 'Rate.cms_user_id'));
		//now iterate through each id to find the top interest rate ids
		$implodedIDs = ""; $count = 0;
		foreach($bankIDs as $bankID):
			$rateIDs[$count] = $this->Rate->find('first', array(
				'fields' => array('Rate.id'),
				'conditions' => array('Rate.cms_user_id = '.$bankID['Rate']['cms_user_id']),
				'order' => array('Rate.documentDate' => 'DESC')
			));
			$count++;
		endforeach;
		
		for($i=0; $i<$count; $i++){				
			$implodedIDs .= $rateIDs[$i]['Rate']['id'].',';
		}
		
		//remove last comma
		$implodedIDs = substr($implodedIDs, 0, -1);
		
		$this->set('iRateDocuments', $this->Rate->find('all', array(
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'UserJoin',
					'type' => 'INNER',
					'conditions' => array(
						'UserJoin.id = Rate.cms_user_id'
					)
				)
			),
			'conditions' => array(
				'Rate.live' => 1,
				'Rate.id IN ('.$implodedIDs.')'
			),
			'fields' => array('UserJoin.*', 'Rate.*'),
			'order' => array('Rate.documentDate' => 'DESC'),
			'limit' => 4					
		)));
		
		//display News
		$this->loadModel('News'); //if it's not already loaded
		$news = $this->News->find('all',array('conditions' => array('live = 1', 'archiveDate > '.mktime(date('H'),date("i"),date('s'),date('n'),date('j'),date('Y'))),'order' => array('startDate' => 'DESC'), 'limit' => 4)); //or whatever conditions you want
		$this->set('news',$news);
		
		$pageLimit = 50;				
		$this->set('pageLimit',$pageLimit);
		
		$moduleHeading = "Transactions";
		$this->set('moduleHeading',$moduleHeading);
		$this->set('helpURL','claim');
		
		//layout options
		$this->set('manage', true);
		$this->set('removeBanner', true);
		$this->set('removeSideMenu', true);
		$this->set('fullWidth', true);
		
	    // ***************************************************************************************************************************		
		// MTD Performance - Claim Data By Lender
		// Change Request - Nyree 29/8/2014
		// ***************************************************************************************************************************	
		// VBI Transactions By Lender
		$options = '';				
		$options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . date('Y'),
		 						       'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . date('m'),										  
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
		
		$this->loadModel('Claims');
        $claimsLenderVBI = $this->Claims->find('all', $options);		
		$this->set('claimsLenderVBI',$claimsLenderVBI);
		
		// Non-VBI Transactions By Lender
		$options = '';				
		$options['conditions'] = array('YEAR(FROM_UNIXTIME(Claims.settlementDate)) = ' . date('Y'),
		 						       'MONTH(FROM_UNIXTIME(Claims.settlementDate)) = ' . date('m'),										  
								       '(Claims.vbi = "0" or Claims.vbi is null)'																	  
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
		
		$this->loadModel('Claims');
        $claimsLenderNonVBI = $this->Claims->find('all', $options);		
		$this->set('claimsLenderNonVBI',$claimsLenderNonVBI);
	}
	
	function index() {		
		// *******************************
		// Change Request - Nyree 4/4/2014
		// *******************************		
		if (isset($this->params['named']['year']))  {
			$strYear = $this->params['named']['year'];
		} else  {
			$strYear = date("Y");			
		}
				
		if (isset($this->params['named']['month']))  {
			$strMonth = $this->params['named']['month'];
		} else  {			
			$strMonth = date("m");
		}		
		// *******************************
		if($_SESSION['Auth']['User']['group_id']!=4){
			$this->loadModel('Users'); //if it's not already loaded
			if($_SESSION['Auth']['User']['group_id']==1){
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3), 'order' => array('Users.name' => 'ASC')));
			} else {
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3, 'Users.parent_user_id' => $_SESSION['Auth']['User']['id']), 'order' => array('Users.name' => 'ASC'))); //brokers only
			}
			$this->set('brokerOptions',$brokerOptions);
			
			
			$this->Claim->recursive = 0;
			if(isset($_GET['sel'])){
echo "<!-- 1.0.0 -->";
				if(trim($_GET['sel']=='all')){
					if($_SESSION['Auth']['User']['group_id']==1){		
						$recordCount = $this->Claim->find('count');						
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					} elseif($_SESSION['Auth']['User']['group_id']==2) {
						$brokerList = "";
						foreach($brokerOptions as $brokers):
							$brokerList .= $brokers['Users']['id'].",";
						endforeach;
						$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
						$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')')));				
//						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')'),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					} else {
						$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'])));					
//						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id']),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id']),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						
					}
				} else {
					if($_SESSION['Auth']['User']['group_id']==1){
						//find total count of records
						$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.clientName LIKE' => ''.trim($_GET['sel']).'%')));		
//						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.clientName LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.clientName LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					}  elseif($_SESSION['Auth']['User']['group_id']==2) {
						$brokerList = "";
						foreach($brokerOptions as $brokers):
							$brokerList .= $brokers['Users']['id'].",";
						endforeach;
						$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
						$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')','Claim.clientName LIKE' => ''.trim($_GET['sel']).'%')));				
//						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')', 'Claim.clientName LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')', 'Claim.clientName LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					} else {
						//find total count of records
						$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'],'Claim.clientName LIKE' => ''.trim($_GET['sel']).'%')));					
//						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.clientName LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.clientName LIKE' => ''.trim($_GET['sel']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						
					}
				}
			} elseif(isset($this->params['named']['group'])){
echo "<!-- 2.0.0 -->";
				if((int)trim($this->params['named']['group'])>0){
echo "<!-- 2.1.0 -->";
					//add broker filter when admin and shareholdersa re logged in
					if(($_SESSION['Auth']['User']['group_id']==1 || $_SESSION['Auth']['User']['group_id']==2) && !isset($this->params['named']['lender'])){
echo "<!-- 2.1.1 -->";
						//find total count of records
						$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.claims_user_broker =' => (int)trim($this->params['named']['group']))));				
//						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker =' => (int)trim($this->params['named']['group'])),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						//$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker =' => (int)trim($this->params['named']['group'])),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('YEAR(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strYear, 'MONTH(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strMonth, 'Claim.claims_user_broker =' => (int)trim($this->params['named']['group'])),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));												
echo "<!-- A ";var_dump($this->paginate); echo " -->";
					} else { //add lender filter when broker is logged in
echo "<!-- 2.1.2 -->";
                        // CHANGE REQUEST Nyree 06/07/2015
						// Combining of ANZ and ANZ Edge Transactions
				        if (($this->params['named']['group'] == 1) || ($this->params['named']['group'] == 17))  {
			               $condLender = '(Claim.lender_id = 1 OR Claim.lender_id = 17)';
			            } else  {
						   $condLender = '(Claim.lender_id = ' . $this->params['named']['group'] . ')';
			            }
			            // END CHAGE REQUEST
				
						//find total count of records
						if($_SESSION['Auth']['User']['group_id']==1) {
echo "<!-- 2.1.2.1 -->";
							$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.lender_id =' => (int)trim($this->params['named']['group']))));						
//							$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.lender_id =' => (int)trim($this->params['named']['group'])),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
							$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('YEAR(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strYear, 'MONTH(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strMonth, $condLender),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						} else {
echo "<!-- 2.1.2.2 -->";
							$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.lender_id =' => (int)trim($this->params['named']['group']))));				
//							$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.lender_id =' => (int)trim($this->params['named']['group'])),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
							$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], $condLender),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						}
					}
				} else {
echo "<!-- 2.2.0 -->";
					if($_SESSION['Auth']['User']['group_id']==1){
echo "<!-- 2.2.1 -->";
						$recordCount = $this->Claim->find('count');							
						//$this->paginate = Set::merge($this->paginate,array('Claim'=>array('order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));	
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('YEAR(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strYear, 'MONTH(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strMonth))), array('Claim'=>array('order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));							
					} elseif($_SESSION['Auth']['User']['group_id']==2) {
echo "<!-- 2.2.2 -->";
						$brokerList = "";
						foreach($brokerOptions as $brokers):
							$brokerList .= $brokers['Users']['id'].",";
						endforeach;
						$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
						$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')')));					
//						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')'),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
						$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('YEAR(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strYear, 'MONTH(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strMonth, 'Claim.claims_user_broker IN ('.$brokerList.')'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					} else {
echo "<!-- 2.3.0 -->";
						$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'])));					
//							$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id']),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
							$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id']),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					}
				}
			} elseif(isset($_GET['search'])){
echo "<!-- 3.0.0 -->";
				if($_SESSION['Auth']['User']['group_id']==1){
					//find total count of records for super user
					$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.clientName LIKE' => '%'.trim($_GET['search']).'%')));			
//					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.clientName LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.clientName LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
				} elseif ($_SESSION['Auth']['User']['group_id']==2) { //for share holders
					$brokerList = "";
					foreach($brokerOptions as $brokers):
						$brokerList .= $brokers['Users']['id'].",";
					endforeach;
					$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
					$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')', 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%')));			
//					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')', 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')', 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
				} else {
					//find total count of records for brokers
					$recordCount = $this->Claim->find('count',array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%')));			
//					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'], 'Claim.clientName LIKE' => '%'.trim($_GET['search']).'%'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
				}
			} else {
echo "<!-- 4.0.0 -->";
				if($_SESSION['Auth']['User']['group_id']==1){
					$recordCount = $this->Claim->find('count');			
//					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));	
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('YEAR(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strYear, 'MONTH(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strMonth))), array('Claim'=>array('order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));						
				} elseif($_SESSION['Auth']['User']['group_id']==2) {
					$brokerList = "";
					foreach($brokerOptions as $brokers):
						$brokerList .= $brokers['Users']['id'].",";
					endforeach;
					$brokerList = substr($brokerList, 0, -1); //get rid of the last comma
					$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')')));		
//					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker IN ('.$brokerList.')'),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('YEAR(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strYear, 'MONTH(FROM_UNIXTIME(Claim.settlementDate)) = ' => $strMonth, 'Claim.claims_user_broker IN ('.$brokerList.')'),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));
				} else {
					$recordCount = $this->Claim->find('count', array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id'])));			
//					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id']),'order' => array('Claim.actioned' => 'ASC', 'Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));	
					$this->paginate = Set::merge($this->paginate,array('Claim'=>array('conditions' => array('Claim.claims_user_broker' => $_SESSION['Auth']['User']['id']),'order' => array('Claim.settlementDate' => 'DESC'),'limit'=>$recordCount)));	
				}
			}
//echo "<!-- B ";var_dump($this->paginate); echo " -->";
			$this->set('claims', $this->paginate());		
//echo "<!-- C ";var_dump($this->paginate); echo " -->";
			
			$this->loadModel('ClaimsGoodsdesc'); //if it's not already loaded
			$goodsDescOptions = $this->ClaimsGoodsdesc->find('all'); //or whatever conditions you want
			$this->set('goodsDescOptions',$goodsDescOptions);
			
			$this->loadModel('ClaimsIndustryprofile'); //if it's not already loaded
			$industryProfileOptions = $this->ClaimsIndustryprofile->find('all'); //or whatever conditions you want
			$this->set('industryProfileOptions',$industryProfileOptions);
			
			$this->loadModel('ClaimsLender'); //if it's not already loaded
			$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender')); //or whatever conditions you want
			$this->set('lenderOptions',$lenderOptions);
			
			$this->loadModel('ClaimsProducttype'); //if it's not already loaded
			$productTypeOptions = $this->ClaimsProducttype->find('all'); //or whatever conditions you want
			$this->set('productTypeOptions',$productTypeOptions);
			
			
			//has report attached?
			$reporting = true;
			$this->set('reportingTransaction', $reporting);
			
			//$reporting = true;
			//$this->set('reporting', $reporting);
			
			$pageLimit = 50;
			$this->set('pageLimit',$pageLimit);
			
			$moduleHeading = 'Transactions';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Manage');
			
			$this->set('helpURL','claim');
			
			//layout options
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
echo "<!-- D ";var_dump($this->paginate); echo " -->";
		} else {
			$this->redirect(array('controller'=>'pages','action'=>'display','home'));	
		}
	}

	function view($id = null) {
		if($_SESSION['Auth']['User']['group_id']==1 || $_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'claims','action'=>'index'));				
		} else {
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay'));	
		}
	}

	function add() {		
		if($_SESSION['Auth']['User']['group_id']<4){ //all but banks			
			if (!empty($this->data)) {
				$this->Claim->create();
				if ($this->Claim->save($this->data)) {
					//******************************************************					
                    // CHANGE REQUEST: Nyree 29/11/13				
					if ($_SESSION['lender'] == "")  {
					   $url = array('action'=>'index/page:1/group:'. $_SESSION['group']);					   
					} else  {
					   $url = array('action'=>'index/page:1/lender:1/group:'. $_SESSION['group']);  					   
					}
					//$this->flash(__('Transaction saved.', true), array('action' => 'index'));
					$this->flash(__('Transaction saved.', true), $url);
					//******************************************************					
				} else {
				}
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			
			$this->loadModel('ClaimsGoodsdesc'); //if it's not already loaded
			$goodsDescOptions = $this->ClaimsGoodsdesc->find('all'); //or whatever conditions you want
			$this->set('goodsDescOptions',$goodsDescOptions);
			$this->loadModel('ClaimsIndustryprofile'); //if it's not already loaded
			$industryProfileOptions = $this->ClaimsIndustryprofile->find('all'); //or whatever conditions you want
			$this->set('industryProfileOptions',$industryProfileOptions);
			$this->loadModel('ClaimsLender'); //if it's not already loaded
			$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender')); //or whatever conditions you want
			$this->set('lenderOptions',$lenderOptions);
			$this->loadModel('ClaimsProducttype'); //if it's not already loaded
			$productTypeOptions = $this->ClaimsProducttype->find('all'); //or whatever conditions you want
			$this->set('productTypeOptions',$productTypeOptions);
			$this->loadModel('ClaimsProducttype'); //if it's not already loaded
			$productTypeOptions = $this->ClaimsProducttype->find('all'); //or whatever conditions you want
			$this->set('productTypeOptions',$productTypeOptions);
			$this->loadModel('Users'); //if it's not already loaded
			if($_SESSION['Auth']['User']['group_id']==1){
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3, 'Users.status_id <> 2'), 'order' => array('Users.name' => 'ASC')));
			} elseif($_SESSION['Auth']['User']['group_id']==2) {
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3, 'Users.status_id <> 2', 'Users.parent_user_id' => $_SESSION['Auth']['User']['id']), 'order' => array('Users.name' => 'ASC'))); //shareholders only
			} else {
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3, 'Users.status_id <> 2', 'Users.id' => $_SESSION['Auth']['User']['id']), 'order' => array('Users.name' => 'ASC'))); //brokers only
			}
			$this->set('brokerOptions',$brokerOptions);
			//******************************************************					
            // CHANGE REQUEST: Nyree 29/11/13		
			$this->set('pages', $this->paginate());
			//******************************************************					
			//has report attached?
			$reporting = true;
			$this->set('reportingTransaction', $reporting);
			
			$moduleHeading = 'Transactions';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Add');
			$this->set('helpURL','claim');	
			//layout options
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);	
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Claim',
				$this->Claim->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimAddForm'
			);
		} else {
			//redirect shareholders and banks to home page
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']==4){ //admin and brokers only	
			//redirect banks to home page
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
		} else {
			if (!$id && empty($this->data)) {
			    //******************************************************					
                // CHANGE REQUEST: Nyree 29/11/13				
			    if ($_SESSION['lender'] == "")  {
			 	  $url = array('action'=>'index/page:1/group:'. $_SESSION['group'] . "/month:" . $_SESSION['month'] . "/year:" . $_SESSION['year']);					   
			    } else  {
				   $url = array('action'=>'index/page:1/lender:1/group:'. $_SESSION['group'] . "/month:" . $_SESSION['month'] . "/year:" . $_SESSION['year']);  					   
			    }
				//$this->flash(sprintf(__('Invalid transaction', true)), array('action' => 'index'));
				$this->flash(sprintf(__('Invalid transaction', true)), $url);
				//******************************************************					
			}
			if (!empty($this->data)) {
				if ($this->data["Claim"]["vbiOverrideDate"] == "")  {
				   $this->data["Claim"]["vbiOverrideDate"] = null;				  
				}
				if ($this->Claim->save($this->data)) {
					//******************************************************					
                    // CHANGE REQUEST: Nyree 29/11/13				
					if ($_SESSION['lender'] == "")  {
					   $url = array('action'=>'index/page:1/group:'. $_SESSION['group'] . "/month:" . $_SESSION['month'] . "/year:" . $_SESSION['year']);					   
					} else  {
					   $url = array('action'=>'index/page:1/lender:1/group:'. $_SESSION['group'] . "/month:" . $_SESSION['month'] . "/year:" . $_SESSION['year']);  					   
					}
					//$this->flash(__('The transaction has been saved.', true), array('action' => 'index'));
					$this->flash(__('The transaction has been saved.', true), $url);
					//******************************************************						
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Claim->read(null, $id);
				//backend security for not allowing anyone to access a claim if it is marked as actioned
				if($this->data['Claim']['actioned']==1){ 
					if($_SESSION['Auth']['User']['group_id']!=1){
						$this->redirect(Controller::referer());	
					}
				}
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.wysiwyg').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			
			//******************************************************					
            // CHANGE REQUEST: Nyree 29/11/13		
			$this->set('pages', $this->paginate());
			//******************************************************
			$this->loadModel('ClaimsGoodsdesc'); //if it's not already loaded
			$goodsDescOptions = $this->ClaimsGoodsdesc->find('all'); //or whatever conditions you want
			$this->set('goodsDescOptions',$goodsDescOptions);
			$this->loadModel('ClaimsIndustryprofile'); //if it's not already loaded
			$industryProfileOptions = $this->ClaimsIndustryprofile->find('all'); //or whatever conditions you want
			$this->set('industryProfileOptions',$industryProfileOptions);
			$this->loadModel('ClaimsLender'); //if it's not already loaded
			$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender')); //or whatever conditions you want
			$this->set('lenderOptions',$lenderOptions);
			$this->loadModel('ClaimsProducttype'); //if it's not already loaded
			$productTypeOptions = $this->ClaimsProducttype->find('all'); //or whatever conditions you want
			$this->set('productTypeOptions',$productTypeOptions);
			$this->loadModel('ClaimsProducttype'); //if it's not already loaded
			$productTypeOptions = $this->ClaimsProducttype->find('all'); //or whatever conditions you want
			$this->set('productTypeOptions',$productTypeOptions);
			$this->loadModel('Users'); //if it's not already loaded
			if($_SESSION['Auth']['User']['group_id']==1){
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3), 'order' => array('Users.name' => 'ASC')));
			} elseif($_SESSION['Auth']['User']['group_id']==2) {
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3, 'Users.parent_user_id' => $_SESSION['Auth']['User']['id']), 'order' => array('Users.name' => 'ASC'))); //shareholders only
			} else {
				$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 3, 'Users.id' => $_SESSION['Auth']['User']['id']), 'order' => array('Users.name' => 'ASC'))); //brokers only
			}
			$this->set('brokerOptions',$brokerOptions);
			
			//has report attached?
			$reporting = true;
			$this->set('reportingTransaction', $reporting);
			
			$moduleHeading = "Transactions";
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Edit');
			$this->set('helpURL','claim');
			//layout options
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);

		    //******************************************************			
			// CHANGE REQUEST: Nyree 10/6/14 - Allow a Super User to override Lender Business Rules.
		    //******************************************************
			// VBI - Override User Name
			if ($this->data['Claim']['vbiOverrideUser'] != "")  {
			   $vbiOverrideUserName = $this->Users->find('all',array('conditions' => array('Users.id' => $this->data['Claim']['vbiOverrideUser'])));
			   $this->set('vbiOverrideUserName',$vbiOverrideUserName);
			}
		    //******************************************************
						
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Claim',
				$this->Claim->validate,
				__('Save failed, fix the following errors:', true),
				'ClaimEditForm'
			);	
		}
	}

	function extractreport(){
        //ini_set('memory_limit', '256M');
		
		$this->loadModel('Users'); //if it's not already loaded		
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.companyName' => 'ASC')));
		
		$this->set('brokerOptions',$brokerOptions);
		
		$this->loadModel('ClaimsLender'); //if it's not already loaded
		$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender')); //or whatever conditions you want
		$this->set('lenderOptions',$lenderOptions);
		
		if(empty($this->data)){
			$this->set('claim', $this->Claim->read(null, null));
		} else {
			$results = $this->Claim->executeReport($this->data);
			$report = array(); 
			foreach ($results as $v) { 
			  $report[] = $this->Claim->array_flatten($v); 
			}
			$this->set('report',$report);
			
			$resultsReportAmount = $this->Claim->showReportTotalAmount($this->data);
			$this->set('reportTotalAmount',$resultsReportAmount);
		}
		$this->layout='ajax';
		$moduleHeading = 'Transaction Report';
		$this->set('moduleHeading',$moduleHeading);
	}
	
	function extractreportExpiring(){
        $this->loadModel('Users');
		
        // Brokers List
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.name' => 'ASC'))); //shareholders only
		$this->set('brokerOptions',$brokerOptions);	
		
		// Lenders List
		$this->loadModel('ClaimsLender'); //if it's not already loaded
		$lenderOptions = $this->ClaimsLender->find('all', array('order'=>'lender')); //or whatever conditions you want
		$this->set('lenderOptions',$lenderOptions);
			
		$this->layout='ajax';
		$moduleHeading = 'Transaction Report';
		$this->set('moduleHeading',$moduleHeading);		
	}
	
	function reportOutputExpiring(){
		// Data Retrieval Conditions
		$conditions = array();
				
		// Brokers List
		$this->loadModel('Users');
		$brokerOptions = $this->Users->find('all',array('conditions' => array('Users.group_id' => 2), 'order' => array('Users.CompanyName' => 'ASC'))); //shareholders only
		$this->set('brokerOptions',$brokerOptions);						
		
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
		
		if ($_SESSION['Auth']['User']['group_id'] == 3)  {
		   $condBrokerTransactions = 'Claims.claims_user_broker = ' .  $_SESSION['Auth']['User']['id'];
		} else  { 
		   $condBrokerTransactions = "";
	    }
		
		$condBroker = "";
		if (($this->params['named']['group'] != "") && ($this->params['named']['group'] != "0"))  {
			$condBroker = 'Users.parent_user_id = ' .  $this->params['named']['group'];
		}
		
		$condLender = "";
		$lender = "All";
		if (($this->params['named']['lender'] != "") && ($this->params['named']['lender'] != "0"))  {
			
			if ($this->params['named']['lender'] == 1)  {
			   $condLender = '(Claims.lender_id = ' . $this->params['named']['lender'] . ' OR Claims.lender_id = 17)';
			} else  {
			   $condLender = 'Claims.lender_id = ' . $this->params['named']['lender'];
			}
			$lender = "";
		}				
		$this->set('lender',$lender);	
		
		//'DATEDIFF(DATE_ADD(FROM_UNIXTIME(Claims.settlementDate), INTERVAL Claims.terms MONTH), CURDATE()) <= 0'
		$options['conditions'] = array($condBroker, 
									   $condLender,
									   $condBrokerTransactions, 
									   "DATE_ADD(FROM_UNIXTIME(Claims.settlementDate), INTERVAL Claims.terms MONTH) >= '" . $this->params['named']['startDate'] . "'",
									   "DATE_ADD(FROM_UNIXTIME(Claims.settlementDate), INTERVAL Claims.terms MONTH) <= '" . $this->params['named']['endDate'] . "'"									   
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
           ),
		   array('table' => 'claims_producttypes',
                'alias' => 'ProductTypes',
                'type' => 'INNER',
                'conditions' => array('Claims.producttype_id = ProductTypes.id')
           ),
		   array('table' => 'claims_goodsdescs',
                'alias' => 'GoodsDescs',
                'type' => 'INNER',
                'conditions' => array('Claims.goodsdesc_id = GoodsDescs.id')
           )
        );
				
        $options['fields'] = array('Users.*', 'Claims.*', "CASE Claims.settlementDate WHEN 0 THEN '-NA-' Else FROM_UNIXTIME(Claims.settlementDate) END AS ClaimSettlementDate", 'Lenders.lender', 'ProductTypes.productType', 'GoodsDescs.goodsDescription');
				
		$options['group'] = array('Claims.id');
		$options['order'] = array('Users.companyName, Lenders.lender, Claims.clientName');		     		
		
        $claims = $this->Claims->find('all', $options);		
		$this->set('claims',$claims);								
		// ***************************************************************************************************************************	
				
		$this->set('startDate',$this->params['named']['startDate']);	
		$this->set('endDate',$this->params['named']['endDate']);	
				
		
		$this->render('claimExpiring-export_xls','claimExpiring-export_xls');
	}		
			
	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']==1 || $_SESSION['Auth']['User']['group_id']==2) {
			if (!$id) {
				$this->flash(sprintf(__('Invalid transaction', true)), array('action' => 'index'));
			}
			if ($this->Claim->delete($id)) {
				$this->flash(__('Transaction deleted', true), array('action' => 'index'));
			}
			$this->flash(__('Transaction was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
		}
	}
	
	function publish($id = null) {
//		if ($_SESSION['Auth']['User']['id']==1) {
		if($_SESSION['Auth']['User']['group_id']==1) { //only super users can mark transactions/claims as actioned
			if (!$id) {
				$this->flash(sprintf(__('Invalid transaction', true)), array('action' => 'index'));
			}
			$id_array = explode(",", $id);
			$actioned = true;
			if(isset($id_array[0])) {
				$flash_text = "";
				foreach($id_array as $v) {
					// run sql to mark items as actioned individually
					$sql = "update claims set actioned=1 where id=".$v;
					$actioned = ($this->Claim->query($sql))?$actioned:false;
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
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
		}
//		} else {
//			if($_SESSION['Auth']['User']['group_id']==1) { //only super users can mark transactions/claims as actioned
//				if (!$id) {
//					$this->flash(sprintf(__('Invalid transaction', true)), array('action' => 'index'));
//				}
//				if ($this->Claim->saveField('actioned',1,false)) {
//					$this->flash(__('Transaction marked as \'actioned\'', true), array('action' => 'index'));
//				}
//				$this->flash(__('Transaction not actioned', true), array('action' => 'index'));
//				$this->redirect(array('action' => 'index'));
//			} else {
//				$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
//			}
//		}
	}
	
	function unpublish($id = null) {
		if($_SESSION['Auth']['User']['group_id']==1) {
			if (!$id) {
				$this->flash(sprintf(__('Invalid transaction', true)), array('action' => 'index'));
			}
			if ($this->Claim->saveField('actioned',0,false)) {
				$this->flash(__('Transaction back in the unprocessed queue', true), array('action' => 'index'));
			}
			$this->flash(__('Transaction needs to be updated', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
		}
	}
}
?>