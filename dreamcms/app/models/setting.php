<?php
class Setting extends AppModel {
	var $name = 'Setting';
	var $validate = array(
		'key' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
			),
		),
	);
}
?>