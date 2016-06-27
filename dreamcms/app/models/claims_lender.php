<?php
class ClaimsLender extends AppModel {
	var $name = 'ClaimsLender';
	var $displayField = 'id';
	var $validate = array(
		'lender' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter lender\'s name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
