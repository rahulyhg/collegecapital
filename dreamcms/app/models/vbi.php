<?php
class Vbi extends AppModel {
	var $name = 'Vbi';
	var $displayField = 'id';
			
	function beforeValidate() {		
	}
	
	function beforeSave($options) { 
	 	if (!isset($this->data['Vbi']['status']) || ($this->data['Vbi']['status'] != 1))  {
// 	 	   $this->data['Vbi']['start_date'] = $this->data['Vbi']['period_year'] . "-" . $this->data['Vbi']['period_month'] . "-01 00:00:00";
//		   $this->data['Vbi']['end_date'] =  $this->data['Vbi']['period_year'] . "-" . $this->data['Vbi']['period_month'] . "-" . cal_days_in_month(CAL_GREGORIAN, $this->data['Vbi']['period_month'], $this->data['Vbi']['period_year']) . " 00:00:00";		
		   $this->data['Vbi']['status'] = 0;
		   $this->data['Vbi']['created'] = date("Y-m-d H:i:s");
		}		
		$this->data['Vbi']['modified'] = date("Y-m-d H:i:s");
		
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
		'lender_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select the lender.',			
			),
		),
//		'period_month' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				'message' => 'Please select period month.',			
//			),
//		),	
//		'period_year' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				'message' => 'Please select period year.',			
//			),
//		),	
		'range_start' => array(
			'number' => array(
				'rule' => array('range', -1 ),
				'message' => 'Please select range start.',			
			),
		),
		'rate' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				'message' => 'Please enter rate amount.',			
			),
		),	
	);	
}