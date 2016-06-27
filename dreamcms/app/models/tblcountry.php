<?php
class Tblcountry extends AppModel {
	var $name = 'Tblcountry';
	var $useTable = 'tblCountry';
	var $primaryKey = 'ID';
	var $displayField = 'ID';
	var $validate = array(
		'Country' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
