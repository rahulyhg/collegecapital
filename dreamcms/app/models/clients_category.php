<?php
class ClientsCategory extends AppModel {
	var $name = 'ClientsCategory';
	var $displayField = 'id';
	var $validate = array(
		'category' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter category.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'ClientsCategory' => array(
			'className' => 'Client',
			'foreignKey' => 'category_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
