<?php
/* Testimonial Test cases generated on: 2011-09-04 23:48:47 : 1315180127*/
App::import('Model', 'Testimonial');

class TestimonialTestCase extends CakeTestCase {
	var $fixtures = array('app.testimonial');

	function startTest() {
		$this->Testimonial =& ClassRegistry::init('Testimonial');
	}

	function endTest() {
		unset($this->Testimonial);
		ClassRegistry::flush();
	}

}
