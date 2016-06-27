<?php
class ClaimsProducttype extends AppModel {
	var $name = 'ClaimsProducttype';
	var $displayField = 'id';
	var $validate = array(
		'productType' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter product type.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
