<?php
/* Teams Test cases generated on: 2011-09-06 00:17:38 : 1315268258*/
App::import('Controller', 'Teams');

class TestTeamsController extends TeamsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TeamsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.team');

	function startTest() {
		$this->Teams =& new TestTeamsController();
		$this->Teams->constructClasses();
	}

	function endTest() {
		unset($this->Teams);
		ClassRegistry::flush();
	}

}
