<?php
/* UserStatus Test cases generated on: 2011-08-16 06:36:16 : 1313476576*/
App::import('Model', 'UserStatus');

class UserStatusTestCase extends CakeTestCase {
	var $fixtures = array('app.user_status', 'app.users');

	function startTest() {
		$this->UserStatus =& ClassRegistry::init('UserStatus');
	}

	function endTest() {
		unset($this->UserStatus);
		ClassRegistry::flush();
	}

}
