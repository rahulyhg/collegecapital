<?php
/* ProjectsCategory Test cases generated on: 2011-09-09 04:10:24 : 1315541424*/
App::import('Model', 'ProjectsCategory');

class ProjectsCategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.projects_category');

	function startTest() {
		$this->ProjectsCategory =& ClassRegistry::init('ProjectsCategory');
	}

	function endTest() {
		unset($this->ProjectsCategory);
		ClassRegistry::flush();
	}

}
