<?php
/* PagesCategory Test cases generated on: 2011-09-12 00:28:51 : 1315787331*/
App::import('Model', 'PagesCategory');

class PagesCategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.pages_category');

	function startTest() {
		$this->PagesCategory =& ClassRegistry::init('PagesCategory');
	}

	function endTest() {
		unset($this->PagesCategory);
		ClassRegistry::flush();
	}

}
