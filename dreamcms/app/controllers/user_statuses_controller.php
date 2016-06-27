<?php
class UserStatusesController extends AppController {

	var $name = 'UserStatuses';

	function index() {
		$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
	}

	function view($id = null) {
		$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
	}

	function add() {
		$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
	}

	function edit($id = null) {
		$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
	}

	function delete($id = null) {
		$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
	}
}
