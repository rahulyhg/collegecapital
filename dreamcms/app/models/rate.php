<?php

class Rate extends AppModel {
	var $name = 'Rate';
	var $displayField = 'title';
	
	function beforeSave($options) {    
		if (!empty($this->data['Rate']['documentDate'])) {            
			$this->data['Rate']['documentDate'] = $this->formatDateToEpoch($this->data['Rate']['documentDate']);   
		}
		if(!empty($this->data['Rate']['live'])){
			$this->data['Rate']['live'] = (int)$this->data['Rate']['live'];    
		}
		if(!empty($this->data['Rate']['notify'])){
			$this->data['Rate']['notify'] = (int)$this->data['Rate']['notify'];    
		}
		$this->data['Rate']['category'] = $this->query("select category from rates_categories where id=".$this->data['Rate']['category_id'].";");
		return true;
	}
	
	function afterSave($created) {
		// no action
	}
	
	// date formatting for calendar converts 01/06/1980 to epoch
	function formatDateToEpoch($dt) 
	{
		$splitDate = split("/", $dt); //specify split character space or hifen/dash or a forward slash
		/*for($m=1;($m<=12 && !is_numeric($splitDate[1]));$m++)
			if(date("m",mktime(0,0,0,$m,1,2000))==$splitDate[1]) $splitDate[1] = $m;*/
		return mktime(0,0,0,$splitDate[1], $splitDate[0], $splitDate[2]);
	}
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter Title of the Rate.',
			),
		),		
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a Rate category.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'documentDate' => array(
			'date' => array(
				'rule' => array('date', 'dmy'),
				'message' => 'Enter valid Rate date. E.g. 01/01/1999',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),		
		'documentFile' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please select a Rate.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'live' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}