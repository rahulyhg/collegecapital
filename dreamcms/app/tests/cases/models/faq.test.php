<?php
/* Faq Test cases generated on: 2011-08-30 00:50:48 : 1314665448*/
App::import('Model', 'Faq');

class FaqTestCase extends CakeTestCase {
	var $fixtures = array('app.faq');

	function startTest() {
		$this->Faq =& ClassRegistry::init('Faq');
	}

	function endTest() {
		unset($this->Faq);
		ClassRegistry::flush();
	}

}
