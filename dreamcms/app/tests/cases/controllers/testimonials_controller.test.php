<?php
/* Testimonials Test cases generated on: 2011-09-04 23:50:23 : 1315180223*/
App::import('Controller', 'Testimonials');

class TestTestimonialsController extends TestimonialsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TestimonialsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.testimonial');

	function startTest() {
		$this->Testimonials =& new TestTestimonialsController();
		$this->Testimonials->constructClasses();
	}

	function endTest() {
		unset($this->Testimonials);
		ClassRegistry::flush();
	}

}
