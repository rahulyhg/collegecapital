<?php
class Testimonial extends AppModel {
	var $name = 'Testimonial';
	var $displayField = 'title';
	var $validate = array(
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter some text in Description field.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
