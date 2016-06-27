<?php
/* NewsCategory Test cases generated on: 2011-08-23 05:33:41 : 1314077621*/
App::import('Model', 'NewsCategory');

class NewsCategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.news_category');

	function startTest() {
		$this->NewsCategory =& ClassRegistry::init('NewsCategory');
	}

	function endTest() {
		unset($this->NewsCategory);
		ClassRegistry::flush();
	}

}
