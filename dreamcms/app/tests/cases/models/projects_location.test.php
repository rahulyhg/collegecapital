<?php
/* ProjectsLocation Test cases generated on: 2011-09-09 04:10:43 : 1315541443*/
App::import('Model', 'ProjectsLocation');

class ProjectsLocationTestCase extends CakeTestCase {
	var $fixtures = array('app.projects_location');

	function startTest() {
		$this->ProjectsLocation =& ClassRegistry::init('ProjectsLocation');
	}

	function endTest() {
		unset($this->ProjectsLocation);
		ClassRegistry::flush();
	}

}
