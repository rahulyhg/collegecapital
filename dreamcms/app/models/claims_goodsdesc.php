<?php
class ClaimsGoodsdesc extends AppModel {
	var $name = 'ClaimsGoodsdesc';
	var $displayField = 'id';
	var $validate = array(
		'goodsDescription' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter goods description.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
