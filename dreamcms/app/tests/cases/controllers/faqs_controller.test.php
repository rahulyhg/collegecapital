<?php
/* Faqs Test cases generated on: 2011-08-30 01:25:25 : 1314667525*/
App::import('Controller', 'Faqs');

class TestFaqsController extends FaqsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class FaqsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.faq');

	function startTest() {
		$this->Faqs =& new TestFaqsController();
		$this->Faqs->constructClasses();
	}

	function endTest() {
		unset($this->Faqs);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
