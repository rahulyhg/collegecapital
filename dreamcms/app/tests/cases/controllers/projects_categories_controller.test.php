<?php
/* ProjectsCategories Test cases generated on: 2011-09-09 04:15:57 : 1315541757*/
App::import('Controller', 'ProjectsCategories');

class TestProjectsCategoriesController extends ProjectsCategoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ProjectsCategoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.projects_category');

	function startTest() {
		$this->ProjectsCategories =& new TestProjectsCategoriesController();
		$this->ProjectsCategories->constructClasses();
	}

	function endTest() {
		unset($this->ProjectsCategories);
		ClassRegistry::flush();
	}

}
