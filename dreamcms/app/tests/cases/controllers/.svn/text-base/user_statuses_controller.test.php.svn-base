<?php
/* UserStatuses Test cases generated on: 2011-08-16 06:38:57 : 1313476737*/
App::import('Controller', 'UserStatuses');

class TestUserStatusesController extends UserStatusesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class UserStatusesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.user_status', 'app.users');

	function startTest() {
		$this->UserStatuses =& new TestUserStatusesController();
		$this->UserStatuses->constructClasses();
	}

	function endTest() {
		unset($this->UserStatuses);
		ClassRegistry::flush();
	}

}
