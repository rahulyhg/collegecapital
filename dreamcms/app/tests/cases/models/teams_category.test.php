<?php
/* TeamsCategory Test cases generated on: 2011-09-05 07:19:55 : 1315207195*/
App::import('Model', 'TeamsCategory');

class TeamsCategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.teams_category');

	function startTest() {
		$this->TeamsCategory =& ClassRegistry::init('TeamsCategory');
	}

	function endTest() {
		unset($this->TeamsCategory);
		ClassRegistry::flush();
	}

}
