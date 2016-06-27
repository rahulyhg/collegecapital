<?php
/* Team Test cases generated on: 2011-09-06 00:17:00 : 1315268220*/
App::import('Model', 'Team');

class TeamTestCase extends CakeTestCase {
	var $fixtures = array('app.team');

	function startTest() {
		$this->Team =& ClassRegistry::init('Team');
	}

	function endTest() {
		unset($this->Team);
		ClassRegistry::flush();
	}

}
