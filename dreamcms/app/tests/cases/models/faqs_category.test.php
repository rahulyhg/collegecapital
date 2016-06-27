<?php
/* FaqsCategory Test cases generated on: 2011-08-31 02:48:49 : 1314758929*/
App::import('Model', 'FaqsCategory');

class FaqsCategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.faqs_category');

	function startTest() {
		$this->FaqsCategory =& ClassRegistry::init('FaqsCategory');
	}

	function endTest() {
		unset($this->FaqsCategory);
		ClassRegistry::flush();
	}

}
