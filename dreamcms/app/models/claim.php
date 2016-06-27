<?php
class Claim extends AppModel {
	var $name = 'Claim';
	var $displayField = 'id';
	
	//logic to return report for claims	
	public function executeReport($data)
    {
		$curDate = mktime(0,0,0,date("n"),date("j"),date("Y"));
		if(isset($data["Claim"]["FromDate"]) && !empty($data["Claim"]["FromDate"])){
			$fromDate = strtotime(mysql_real_escape_string($data["Claim"]["FromDate"]));
		} else {
			$fromDate = "";
		}
		if(isset($data["Claim"]["ToDate"]) && !empty($data["Claim"]["ToDate"])){
			$toDate = strtotime(mysql_real_escape_string($data["Claim"]["ToDate"]));
		} else {
			$toDate = "";
		}
		if(isset($data["Claim"]["ClaimStatusID"]) && !empty($data["Claim"]["ClaimStatusID"])){
			$cStatusID = (int)$data["Claim"]["ClaimStatusID"];
		} else {
			$cStatusID = 0;
		}			
		
//        $sql = "SELECT c.id, c.clientName, c.netRate, c.amount, c.brokerageAmount, c.docFeeAmount, c.terms, c.created,
        $sql = "SELECT c.id, c.clientName, c.netRate, c.amount, c.brokerageAmount, c.docFeeAmount, c.terms, c.created, 
				CASE c.settlementDate WHEN 0 THEN '-NA-' Else FROM_UNIXTIME(c.settlementDate) 
				END AS ClaimSettlementDate, 
				CASE c.actioned WHEN 0 THEN 'No' Else 'Yes' End As actioned, 
				u.name, u.surname, u.companyName, ci.industryProfile, 
				cl.lender, cg.goodsDescription, cp.productType, uu.companyName As Shareholder,
				c.invoiceNumber, CASE c.newUsed WHEN 0 THEN 'Used' Else 'New' End As newUsed, c.notes as Notes
				FROM `claims` c, `users` u, `users` uu, `claims_industryprofiles` ci, `claims_lenders` cl, 
				`claims_goodsdescs` cg, `claims_producttypes` cp
				WHERE c.claims_user_broker = u.id AND c.industryprofile_id = ci.id 
				AND c.lender_id = cl.id AND c.goodsdesc_id = cg.id
				AND c.producttype_id = cp.id AND uu.id = u.parent_user_id";
				
		$sql .= ($cStatusID<2)?" AND c.actioned = ".mysql_real_escape_string($data["Claim"]["ClaimStatusID"]):"";
		
		//******************************************************
        // CHANGE REQUEST: Nyree 19/12/13
		if(isset($data["Claim"]["select_broker"]) && !empty($data["Claim"]["select_broker"])){
			$cBroker = (int)$data["Claim"]["select_broker"];
		} else {
			$cBroker = 0;
		}
		$sql .= ($cBroker>0)?" AND uu.id = ".mysql_real_escape_string($data["Claim"]["select_broker"]):"";
		//******************************************************
		//******************************************************
        // CHANGE REQUEST: Nyree 19/12/13
		if(isset($data["Claim"]["select_lender"]) && !empty($data["Claim"]["select_lender"])){
			$cLender = (int)$data["Claim"]["select_lender"];
		} else {
			$cLender = 0;
		}
		
		
		if (($cLender > 0) && ($data["Claim"]["select_lender"] == 1))  {
			$sql .= " AND (cl.id = ".mysql_real_escape_string($data["Claim"]["select_lender"]) . " OR cl.id = 17)"; 
		} else  {			
		   $sql .= ($cLender>0)?" AND cl.id = ".mysql_real_escape_string($data["Claim"]["select_lender"]):"";
		}
		//******************************************************
		if($_SESSION['Auth']['User']['group_id']==2){ //for share holders display report for their broker network
			//find broker list
			$sql .= " AND c.claims_user_broker IN (SELECT uu.id FROM `users` uu WHERE uu.parent_user_id = ".(int)$_SESSION['Auth']['User']['id'].")";
		} elseif($_SESSION['Auth']['User']['group_id']==3){ //for share holders display report for their broker network
			$sql .= " AND c.claims_user_broker = ".(int)$_SESSION['Auth']['User']['id'];
		} else {
			//do nothing
		}
		
		if(strlen($fromDate)>0 && strlen($toDate)>0){ //both dates present
			$sql .= " AND (c.settlementDate >= ".$fromDate." AND c.settlementDate <= ".$toDate.") ";
		} elseif (strlen($fromDate)<=0 && strlen($toDate)>0){ //to date given
			$sql .= " AND (c.settlementDate >= 0 AND c.settlementDate <= ".$toDate.") ";
		} elseif (strlen($fromDate)>0 && strlen($toDate)<=0){ //from date given
			$sql .= " AND (c.settlementDate >= ".$fromDate." AND c.settlementDate <= ".$curDate.") ";
		} else {//both dates not given
			//$sql .= " AND (c.settlementDate >= 0 AND c.settlementDate < ".$curDate.");";
		}
		
		//order by clause
		//******************************************************
        // CHANGE REQUEST: Nyree 29/11/13
		//$sql .= " ORDER BY c.id;";
		switch ($data["Claim"]["Sort"])  {
			case 'shareholder':  	$sql .= " ORDER BY uu.companyName"; break;	
			case 'lender': 			$sql .= " ORDER BY cl.lender"; break;						
			default:				$sql .= " ORDER BY c.id;";
		}
		//******************************************************
					
		//echo $sql;
        return $this->query($sql);
    }
	
	//return total report amount
	public function showReportTotalAmount($data)
    {
		$curDate = mktime(0,0,0,date("n"),date("j"),date("Y"));
		if(isset($data["Claim"]["FromDate"]) && !empty($data["Claim"]["FromDate"])){
			$fromDate = strtotime(mysql_real_escape_string($data["Claim"]["FromDate"]));
		} else {
			$fromDate = "";
		}
		if(isset($data["Claim"]["ToDate"]) && !empty($data["Claim"]["ToDate"])){
			$toDate = strtotime(mysql_real_escape_string($data["Claim"]["ToDate"]));
		} else {
			$toDate = "";
		}
		if(isset($data["Claim"]["ClaimStatusID"]) && !empty($data["Claim"]["ClaimStatusID"])){
			$cStatusID = (int)$data["Claim"]["ClaimStatusID"];
		} else {
			$cStatusID = 0;
		}
		
        $sql = "SELECT SUM(c.amount) AS TotalAmount
				FROM `claims` c
				WHERE 1=1 ";
				
		$sql .= ($cStatusID<2)?" AND c.actioned = ".mysql_real_escape_string($data["Claim"]["ClaimStatusID"]):"";				
		
		if($_SESSION['Auth']['User']['group_id']==2){ //for share holders display report for their broker network
			//find broker list
			$sql .= " AND c.claims_user_broker IN (SELECT uu.id FROM `users` uu WHERE uu.parent_user_id = ".(int)$_SESSION['Auth']['User']['id'].")";
		} elseif($_SESSION['Auth']['User']['group_id']==3){ //for share holders display report for their broker network
			$sql .= " AND c.claims_user_broker = ".(int)$_SESSION['Auth']['User']['id'];
		} else {
			//do nothing
		}
		
		//******************************************************
        // CHANGE REQUEST: Nyree 19/12/13
		if($_SESSION['Auth']['User']['group_id']==1){ //for super users		
		   if (isset($data["Claim"]["select_broker"]) && !empty($data["Claim"]["select_broker"])){
		      $sql .= " AND c.claims_user_broker IN (SELECT uu.id FROM `users` uu WHERE uu.parent_user_id = ".(int)$data["Claim"]["select_broker"].")";		
		   }
		}
		//******************************************************
		
		if(strlen($fromDate)>0 && strlen($toDate)>0){ //both dates present
			$sql .= " AND (c.settlementDate >= ".$fromDate." AND c.settlementDate <= ".$toDate.") ";
		} elseif (strlen($fromDate)<=0 && strlen($toDate)>0){ //to date given
			$sql .= " AND (c.settlementDate >= 0 AND c.settlementDate <= ".$toDate.") ";
		} elseif (strlen($fromDate)>0 && strlen($toDate)<=0){ //from date given
			$sql .= " AND (c.settlementDate >= ".$fromDate." AND c.settlementDate <= ".$curDate.") ";
		} else {//both dates not given
			//$sql .= " AND (c.settlementDate >= 0 AND c.settlementDate < ".$curDate.");";
		}				
				
		//echo $sql;
        $resultAmount = $this->query($sql);
		return $resultAmount[0][0]['TotalAmount'];
    }
	
	function & array_flatten(&$array) { 
		if (is_array($array)) { 
			$newarray = array(); 
			foreach ($array as $k=>$v) { 
				if (is_array($v)) { 
				  $newarray += $this->array_flatten($v); 
				} else {
				  	$newarray[$k] = $v; 
				}
			} 
			return $newarray; 
		} 
		return $array; 
	}
	function beforeValidate() {
		// convert net rate to 2 decimal points
		if(!empty($this->data['Claim']['netRate'])) {
			$this->data['Claim']['netRate'] = number_format((float)$this->data['Claim']['netRate'],2,'.','');
		}
		//convert amount to 2 decimal points
		if(!empty($this->data['Claim']['amount'])) {
			$this->data['Claim']['amount'] = number_format((float)$this->data['Claim']['amount'],2,'.','');
		}
		if(!empty($this->data['Claim']['brokerageAmount']) && is_numeric($this->data['Claim']['brokerageAmount'])){
			$this->data['Claim']['brokerageAmount'] = number_format($this->data['Claim']['brokerageAmount'],2,'.','');    
		}
		if(!empty($this->data['Claim']['docFeeAmount']) && is_numeric($this->data['Claim']['docFeeAmount'])){
			$this->data['Claim']['docFeeAmount'] = number_format($this->data['Claim']['docFeeAmount'],2,'.','');    
		}
			
		return true;
	}
	function beforeSave($options) {    
		if (!empty($this->data['Claim']['settlementDate'])) {            
			$this->data['Claim']['settlementDate'] = $this->formatDateToEpoch($this->data['Claim']['settlementDate']);  
		} 
		if(!empty($this->data['Claim']['actioned'])){
			$this->data['Claim']['actioned'] = (int)$this->data['Claim']['actioned'];   
		}
		
		if(strlen($this->data['Claim']['netRate'])==0) 		$this->data['Claim']['netRate'] = 0;					// default numeric value
		if(strlen($this->data['Claim']['docFeeAmount'])==0)	$this->data['Claim']['docFeeAmount'] = 0;				// default numeric value
		$this->data['Claim']['amount'] 			= str_replace(",", "", $this->data['Claim']['amount']);				// no commas in numeric value
		$this->data['Claim']['brokerageAmount']	= str_replace(",", "", $this->data['Claim']['brokerageAmount']);	// no commas in numeric value
		$this->data['Claim']['docFeeAmount']	= str_replace(",", "", $this->data['Claim']['docFeeAmount']);		// no commas in numeric value
		
		//******************************************************
        // CHANGE REQUEST: Nyree 24/2/14 - VBI Business Rules
		// CHANGE REQUEST: Nyree 10/6/14 - Allow a Super User to override Lender Business Rules.
		//******************************************************
		if ((!isset($this->data['Claim']['vbiOverrideUser'])) || ($this->data['Claim']['vbiOverrideUser'] == ""))  { 
		   $sql = "SELECT * FROM claims_lenders WHERE id=" . $this->data['Claim']['lender_id'];
		   $result = $this->query($sql);		
						
		   $this->data['Claim']['vbi'] = $result[0]["claims_lenders"]["vbi"];
		   if ($result[0]["claims_lenders"]['vbi'] == 1)  {
              if ((($result[0]["claims_lenders"]['amount'] > 0) && ($this->data['Claim']['amount'] < $result[0]["claims_lenders"]['amount']))   ||   (($result[0]["claims_lenders"]['term'] != "") && ($this->data['Claim']['terms'] < $result[0]["claims_lenders"]['term']))) {
		   	     $this->data['Claim']['vbi'] = 0; 		   
		      }			
		   }		   
		} else  {
		   	
		}
		//******************************************************
		return true;
	}
	function formatDateToEpoch($dt) 
	{
		$splitDate = split("/", $dt); //specify split character space or hifen/dash or a forward slash
		/*for($m=1;($m<=12 && !is_numeric($splitDate[1]));$m++)
			if(date("m",mktime(0,0,0,$m,1,2000))==$splitDate[1]) $splitDate[1] = $m;*/
		return mktime(0,0,0,$splitDate[1], $splitDate[0], $splitDate[2]);
	}
	var $validate = array(
		'clientName' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter client name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'claims_user_broker' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select the broker.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'industryprofile_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select industry profile.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lender_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select the lender.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'goodsdesc_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select goods description.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'producttype_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select the product type.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'amount' => array(
			'decimal' => array(
				'rule' => array('decimal', 2),
				'message' => 'Please enter correct amount.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'brokerageAmount' => array(
			'decimal' => array(
				'rule' => array('decimal', 2),
				'message' => 'Please enter correct Brokerage Amount.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
//		'docFeeAmount' => array(
//			'decimal' => array(
//				'rule' => array('decimal', 2),
//				'message' => 'Please enter correct Document Fee Amount.',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
		'terms' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please enter numeric term period.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
//		'netRate' => array(
//			'decimal' => array(
//				//'rule' => array('decimal', 2),
//				'rule' => array('decimal', 2),
//				'message' => 'Please enter correct Net Rate.',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
	);	
}