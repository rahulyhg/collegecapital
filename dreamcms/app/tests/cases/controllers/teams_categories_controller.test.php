<?php
/* TeamsCategories Test cases generated on: 2011-09-05 07:20:37 : 1315207237*/
App::import('Controller', 'TeamsCategories');

class TestTeamsCategoriesController extends TeamsCategoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TeamsCategoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.teams_category');

	function startTest() {
		$this->TeamsCategories =& new TestTeamsCategoriesController();
		$this->TeamsCategories->constructClasses();
	}

	function endTest() {
		unset($this->TeamsCategories);
		ClassRegistry::flush();
	}

}
