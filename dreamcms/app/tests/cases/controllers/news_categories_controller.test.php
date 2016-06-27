<?php
/* NewsCategories Test cases generated on: 2011-08-23 05:36:15 : 1314077775*/
App::import('Controller', 'NewsCategories');

class TestNewsCategoriesController extends NewsCategoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class NewsCategoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.news_category');

	function startTest() {
		$this->NewsCategories =& new TestNewsCategoriesController();
		$this->NewsCategories->constructClasses();
	}

	function endTest() {
		unset($this->NewsCategories);
		ClassRegistry::flush();
	}

}
