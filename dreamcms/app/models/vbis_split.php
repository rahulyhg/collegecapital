<?php
class VbisSplit extends AppModel {
	var $name = 'VbisSplit';
	var $displayField = 'id';
			
	function beforeValidate() {		
	}
	
	function beforeSave($options) { 
	 	if (!isset($this->data['VbisSplit']['status']) || ($this->data['VbisSplit']['status'] != 1))  {
  	 	   $this->data['VbisSplit']['start_date'] = $this->data['VbisSplit']['period_year'] . "-" . $this->data['VbisSplit']['period_month'] . "-01 00:00:00";
		   $this->data['VbisSplit']['end_date'] =  $this->data['VbisSplit']['period_year'] . "-" . $this->data['VbisSplit']['period_month'] . "-" . cal_days_in_month(CAL_GREGORIAN, $this->data['VbisSplit']['period_month'], $this->data['VbisSplit']['period_year']) . " 00:00:00";		
		   $this->data['VbisSplit']['status'] = 0;
		   $this->data['VbisSplit']['created'] = date("Y-m-d H:i:s");
		}		
		$this->data['VbisSplit']['modified'] = date("Y-m-d H:i:s");
		
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
		'broker_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select the broker.',			
			),
		),
		'period_month' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select period month.',			
			),
		),	
		'period_year' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select period year.',			
			),
		),	
		'payout_rate' => array(
			'number' => array(
				'rule' => array('range', -1 ),
				'message' => 'Please select payout rate.',			
			),
		),
		'cba_doc_fee_incentive' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				'message' => 'Please enter CBA doc fee incentive amount.',			
			),
		),
		'clawback' => array(
			'number' => array(
				'rule' => array('range', -1 ),
				'message' => 'Please select clawback.',			
			),
		),	
	);	
}