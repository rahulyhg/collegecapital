<?php
class ClaimsIndustryprofile extends AppModel {
	var $name = 'ClaimsIndustryprofile';
	var $displayField = 'id';
	var $validate = array(
		'industryProfile' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter industry profile.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
