<?php

class Document extends AppModel {
	var $name = 'Document';
	var $displayField = 'title';
	
	function beforeSave($options) {    
		if (!empty($this->data['Document']['documentDate'])) {            
			$this->data['Document']['documentDate'] = $this->formatDateToEpoch($this->data['Document']['documentDate']);   
		}
		if(!empty($this->data['Document']['live'])){
			$this->data['Document']['live'] = (int)$this->data['Document']['live'];    
		}
		return true;
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
				'message' => 'Please enter Title of the Document.',
			),
		),		
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a Document category.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'documentDate' => array(
			'date' => array(
				'rule' => array('date', 'dmy'),
				'message' => 'Enter valid Document date. E.g. 01/01/1999',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),		
		'documentFile' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please select a Document.',
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