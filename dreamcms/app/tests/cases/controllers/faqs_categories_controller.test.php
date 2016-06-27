<?php
/* FaqsCategories Test cases generated on: 2011-08-31 02:56:22 : 1314759382*/
App::import('Controller', 'FaqsCategories');

class TestFaqsCategoriesController extends FaqsCategoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class FaqsCategoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.faqs_category');

	function startTest() {
		$this->FaqsCategories =& new TestFaqsCategoriesController();
		$this->FaqsCategories->constructClasses();
	}

	function endTest() {
		unset($this->FaqsCategories);
		ClassRegistry::flush();
	}

}
