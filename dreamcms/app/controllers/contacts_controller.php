<?php
class ContactsController extends AppController {
 
 	var $name = 'Contacts';
	var $components = array('JQValidator.JQValidator','Email');
	var $helpers = array('Form', 'Html', 'Javascript', 'Time', 'FormatEpochToDate', 'CustomDisplayFunctions','JQValidator.JQValidator');
 
    function send() {
		if(!empty($this->data)) {
            $this->Contact->set($this->data);
			//layout options
			$this->set('page', 'Contact Us');
			$this->set('moduleHeading','Contact Us');
			$this->set('moduleAction','Form');
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
	 
			//javascript validations
			$this->JQValidator->addValidation
			(
				'Contact',
				$this->Contact->validate,
				__('Save failed, fix the following errors:', true),
				'ContactSendForm'
			);
			
            if($this->Contact->validates()) {
                $this->Email->from = $this->data['Contact']['name'] . ' <' . $this->data['Contact']['email'] . '>';
                $this->Email->to = Configure::read('Company.corporateEmail');
                $this->Email->subject = 'CCAP Contact Form - '.$this->data['Contact']['subject'];
                $this->Email->sendAs = 'html';
				$this->Email->template = 'contact_form';
				$this->Email->send();
                //$this->Session->setFlash('Your message has been sent.');
                // Display the success.ctp page instead of the form again
                $this->render('success');
            } else {
                $this->render('index');
			}
        }
    }
 
    function index() {
        // Placeholder for index. No actual action here, everything is submitted to the send function.
		
		//layout options
		$this->set('page', 'Contact Us');
		$this->set('moduleHeading','Contact Us');
		$this->set('moduleAction','Form');
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
    }
 
}