<?php
/* ProjectsLocations Test cases generated on: 2011-09-09 04:16:12 : 1315541772*/
App::import('Controller', 'ProjectsLocations');

class TestProjectsLocationsController extends ProjectsLocationsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ProjectsLocationsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.projects_location');

	function startTest() {
		$this->ProjectsLocations =& new TestProjectsLocationsController();
		$this->ProjectsLocations->constructClasses();
	}

	function endTest() {
		unset($this->ProjectsLocations);
		ClassRegistry::flush();
	}

}
