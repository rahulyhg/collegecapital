<?php
/* PagesCategories Test cases generated on: 2011-09-12 00:31:06 : 1315787466*/
App::import('Controller', 'PagesCategories');

class TestPagesCategoriesController extends PagesCategoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PagesCategoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.pages_category');

	function startTest() {
		$this->PagesCategories =& new TestPagesCategoriesController();
		$this->PagesCategories->constructClasses();
	}

	function endTest() {
		unset($this->PagesCategories);
		ClassRegistry::flush();
	}

}
