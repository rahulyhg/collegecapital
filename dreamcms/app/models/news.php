<?php
class News extends AppModel {
	var $name = 'News';
	var $displayField = 'title';
	
	function beforeSave($options) {    
		if (!empty($this->data['News']['startDate']) && !empty($this->data['News']['archiveDate'])) {            
			$this->data['News']['startDate'] = $this->formatDateToEpoch($this->data['News']['startDate']);            
			$this->data['News']['archiveDate'] = $this->formatDateToEpoch($this->data['News']['archiveDate']);    
		} 
		if(!empty($this->data['News']['unpublishDate'])){
			$this->data['News']['unpublishDate'] = $this->formatDateToEpoch($this->data['News']['unpublishDate']);    
		}
		if(!empty($this->data['News']['live'])){
			$this->data['News']['live'] = (int)$this->data['News']['live'];    
		}
		return true;
	}
	
	function beforeValidate() {
		// join teams into csv
		/*f(!empty($this->data['News']['teams'])) {
			$this->data['News']['teams'] = join(',', $this->data['News']['teams']);
		}
		//join branches into csv
		if(!empty($this->data['News']['branches'])) {
			$this->data['News']['branches'] = join(',', $this->data['News']['branches']);
		}*/
	
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
				'message' => 'Please enter title.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'seo_page_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'This cannot be empty.Please manually enter title above.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'shortDescription' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter some text for Short Description.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'body' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter some text for News body.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'startDate' => array(
			'date' => array(
				'rule' => array('date', 'dmy'),
				'message' => 'Enter valid start date. E.g. 01/01/1999',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'archiveDate' => array(
			'date' => array(
				'rule' => array('date', 'dmy'),
				'message' => 'Enter valid archive date. E.g. 01/01/1999',
				'allowEmpty' => false,
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
				'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);
}
?>