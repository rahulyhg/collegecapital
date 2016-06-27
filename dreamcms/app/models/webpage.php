<?php
class WebPage extends AppModel {
	var $name = 'Page';
	var $displayField = 'title';
	
	function beforeSave($options) {    
		if (!empty($this->data['Webpage']['pageType']) && $this->data['Webpage']['pageType'] == 'Child') {
			$this->data['Webpage']['parent_page_id'] = $this->data['Webpage']['parentPage'];
			$this->data['Webpage']['category_id'] = $this->getCategoryIDFromParent((int)$this->data['Webpage']['parentPage']);
		} else {
			$this->data['Webpage']['parent_page_id'] = 0; 
		}
		return true;
	}
	
	//retrieve the category id from the parent page on the fly
	function getCategoryIDFromParent($pID){
		$categoryIDs = $this->find('first', array( 
		  'conditions' => array('Webpage.id' => $pID), 
		  'fields' => array('Webpage.category_id') 
		)); 
		foreach	($categoryIDs as $categoryID) {
			return (int)$categoryID['category_id'];
		}
	}
	
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter title of the page.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Category must be numeric.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'metaKeywords' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter meta keywords for the page',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'metaDescription' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter meta description of the page',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'shortDescription' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter some text in the short description.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'body' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter some text in the body.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'live' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please check if the page is published/unpublished.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
