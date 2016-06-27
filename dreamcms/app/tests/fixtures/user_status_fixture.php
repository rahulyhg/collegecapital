<?php
/* UserStatus Fixture generated on: 2011-08-16 06:36:16 : 1313476576 */
class UserStatusFixture extends CakeTestFixture {
	var $name = 'UserStatus';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'status' => array('type' => 'string', 'null' => false, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'status' => 'Lorem ipsum dolor sit amet'
		),
	);
}
