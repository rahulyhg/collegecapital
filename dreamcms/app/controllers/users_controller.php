<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('JQValidator.JQValidator','Email');
	var $helpers = array('Form', 'Html', 'Javascript', 'CustomDisplayFunctions','JQValidator.JQValidator');   
		
	function beforeFilter() {        
		parent::beforeFilter();        
		$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'display', 'home');    
	}
	
	//set the page limit. note: this is the total maximum records that you want to pull out of the DB
	public $paginate = array(
		'limit' => 10000,
		'order' => array(            
			'User.id' => 'asc'        
		)    
	);
	
        function getLatLongFromPostcodeOrSuburb($postcodeOrSuburb, $country = 'AU', $gmapApiKey = 'AIzaSyA5papzfh_eu6xDIvk4CLmyQ_0pDcKYJA8')
        {
            /* remove spaces from postcode */
            $postcodeOrSuburb = urlencode(trim($postcodeOrSuburb));

            /* connect to the google geocode service */    
            $file = "https://maps.google.com/maps/api/geocode/xml?address=$postcodeOrSuburb,+AU&key=AIzaSyA5papzfh_eu6xDIvk4CLmyQ_0pDcKYJA8";
            //echo $file;
            $xml = simplexml_load_file($file) or die("url not loading");

            return ($xml);
        }
        
        function updateUserLatAndLnginDB(){
            if( !empty($this->data)){
                $stAddress = trim($this->data['User']['streetAddress']);
                $suburb = trim($this->data['User']['streetSuburb']);
                $latitude = @$this->data['User']['latitude'];
                $longitude = @$this->data['User']['longitude'];
                if( !empty($suburb) && !empty($stAddress) ){
                    $fulladdress = $stAddress . ',' . $suburb;
                    $xml = $this->getLatLongFromPostcodeOrSuburb($fulladdress);
                    $latitude = (double)@$xml->result->geometry->location->lat;
                    $longitude = (double)@$xml->result->geometry->location->lng;
                    $uID = $_SESSION['Auth']['User']['id'];                    
                    $this->loadModel('Group'); //if it's not already loaded
                    $sql = "UPDATE `users` set longitude= $longitude, latitude = $latitude WHERE id=$uID";
                    $this->Group->query($sql);
                }
            }
        }
        
	function findTotalRecords(){
		return $this->User->find('count'); 
	}
	
	/****
	*  The AuthComponent provides the needed functionality
	*  for login, so you can leave this function blank.
	***/
	function login() {
		if(isset($_SESSION['Auth']['User'])){
			//redirect if already logged in			
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->set('title_for_layout', 'Login to access Website Content Management System');
			$this->layout = 'admin';	
			$this->set('page','Login');
		}
	}
	
	function logout() {
		$this->redirect($this->Auth->logout());
	}
	
	function index() {
		if($_SESSION['Auth']['User']['group_id']==2 && $_SESSION['Auth']['User']['group_id']==4){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} elseif($_SESSION['Auth']['User']['group_id']==3){
			$this->redirect(array('controller'=>'users','action'=>'view'));
		}else {
			$this->set('title_for_layout', 'Active Users'); 
			$recordCount = $this->User->find('count');
			$this->User->recursive = 0;
			
			if(isset($_GET['sel'])){
				if(trim($_GET['sel']=='all')){	
					$this->paginate = Set::merge($this->paginate,array('User'=>array('order' => array('User.id' => 'ASC'),'limit'=>$recordCount)));
				} else {
					//find total count of records
					$recordCount = $this->User->find('count',array('conditions' => array('User.name LIKE' => ''.trim($_GET['sel']).'%')));
					$this->paginate = Set::merge($this->paginate,array('User'=>array('conditions' => array('User.name LIKE' => ''.trim($_GET['sel']).'%'),'limit'=>$recordCount)));
				}
			} elseif(isset($_GET['group'])){
				if((int)trim($_GET['group'])>0){
					$recordCount = $this->User->find('count',array('conditions' => array('User.group_id =' => (int)trim($_GET['group']))));
					$this->paginate = Set::merge($this->paginate,array('User'=>array('conditions' => array('User.group_id =' => (int)trim($_GET['group'])),'limit'=>$recordCount)));
				}
			} elseif(isset($_GET['search'])){
				//find total count of records
				$recordCount = $this->User->find('count',array('conditions' => array('User.name LIKE' => '%'.trim($_GET['search']).'%')));
				$this->paginate = Set::merge($this->paginate,array('User'=>array('conditions' => array('User.name LIKE' => '%'.trim($_GET['search']).'%'),'limit'=>$recordCount)));
			} else {
				$this->paginate = Set::merge($this->paginate,array('User'=>array('order' => array('User.id' => 'ASC'),'limit'=>$recordCount)));
			}
			$this->set('users', $this->paginate());
			$pageLimit = 20;
			$this->set('pageLimit',$pageLimit);
			
			$this->loadModel('Groups'); //if it's not already loaded
			$options = $this->Groups->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$this->set('helpURL','users');
			$moduleHeading = 'Network';
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Manage');
			$this->set('helpURL','users');
					
			//layout options
			$this->set('page','network');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function view($id = null) {
//		echo "<!-- "; var_dump($_SESSION); echo " -->";		
//		echo "<!-- "; var_dump($this); echo " -->";		
		echo "<!-- ".$_SESSION["Auth"]["User"]["group_id"]." -->";		
		if (!$id) {
			if(isset($_GET['group']) && (int)trim($_GET['group'])>0){
				$this->set('user', $this->User->find('all',array('conditions' => array('User.group_id > 1','User.group_id =' => (int)trim($_GET['group'])),'order' => 'User.companyName, User.name')));
			} else {
				$this->set('user', $this->User->find('all',array('conditions' => array('User.group_id > 1'),'order' => 'User.companyName, User.name')));
			}
			
			$this->set('userList', true);
			$pageLimit = 50; //no. of News items to display
			$this->set('pageLimit',$pageLimit);	
			
			//for links category drop down with values that has associated links
			$fields = array('DISTINCT Group.group', 'User.id');
			$conditions = 'User.group_id > 1'.(($_SESSION["Auth"]["User"]["group_id"]==4)?' AND NOT User.group_id='.$_SESSION["Auth"]["User"]["group_id"]:'');
			$joins = array(
				array(
					'table' => 'users', 
					'alias' => 'User', 
					'type' => 'RIGHT', 
					'conditions' => array('User.group_id = Group.id', 'User.group_id > 1')
				)
			);                                                                                                        
			$joinUserArray = array('fields' => $fields, 'conditions' => $conditions, 'joins' => $joins);            
			$this->loadModel('Group'); //if it's not already loaded
			$options = $this->Group->find('all', $joinUserArray);
			$this->set('options', $options);		
		} else {
			$userDetails = $this->User->read(null, $id);
			$this->set('user', $userDetails);
			$this->loadModel('Tblstate'); //if it's not already loaded
			$streetState = $this->Tblstate->find('first', array('fields' => array('State'), 'conditions' => array('Tblstate.id' => $userDetails['User']['street_state_id']))); //or whatever conditions you want
			$this->set('streetState', $streetState);
			$postalState = $this->Tblstate->find('first', array('fields' => array('State'), 'conditions' => array('Tblstate.id' => $userDetails['User']['postal_state_id']))); //or whatever conditions you want
			$this->set('postalState', $postalState);
			
			$this->set('userList', false);
		}
		$moduleHeading = 'Network';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('moduleAction','View');
		$this->set('helpURL','users');
				
		//layout options
		$this->set('page','network');
		$this->set('overview', true);
		if($_SESSION['Auth']['User']['group_id']==1){
			$this->set('manage', true);
		}
		if($_SESSION['Auth']['User']['group_id']==3){
			$this->set('profile', true);
		}
		//$this->set('editProfile', true); yet to flesh out brief on this functionality
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
	}
	
	function preview($id = null) {
		if (!$id) {
			$this->flash(__('Invalid User', true), array('action' => 'index'));	
		} 
		$this->set('user', $this->User->read(null, $id));
		$moduleHeading = 'Network';
		$this->set('moduleHeading',$moduleHeading);
		$this->set('moduleAction','Preview');
		$this->set('helpURL','users');
				
		//layout options
		$this->set('page','network');
		$this->set('overview', true);
		$this->set('manage', true);
		$this->set('removeBanner', false);
		$this->set('removeSideMenu', false);
		$this->set('fullWidth', false);
	}

	function add() {		
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$this->set('title_for_layout', 'Add New Users');
			if (!empty($this->data)) {
				$this->User->create();
				if ($this->User->save($this->data)) {
					$this->flash(__('User saved.', true), array('action' => 'index'));
				} else {
				}
			}
			$this->layout='add-edit';
			$ckeditorClass = '';
			$this->set('ckeditorClass', $ckeditorClass);
			$ckfinderPath = Configure::read('Company.url').'app/webroot/js/ckfinder/';
			$this->set('ckfinderPath', $ckfinderPath);
			$this->loadModel('Groups'); //if it's not already loaded
			$options = $this->Groups->find('all'); //or whatever conditions you want
			$this->set('options',$options);
			$this->loadModel('UserStatuses'); //if it's not already loaded
			$us_options = $this->UserStatuses->find('all'); //or whatever conditions you want
			$this->set('us_options',$us_options);
			$this->loadModel('Tblstate'); //if it's not already loaded
			$stateOptions = $this->Tblstate->find('all'); //or whatever conditions you want
			$this->set('stateOptions',$stateOptions);
			//for shareholder drop down list
			$this->set('shareholders', $this->User->find('all',array('conditions' => array('User.parent_user_id = 0', 'User.group_id = 2'), 'order' => array('User.name' => 'DESC'))));
			
			$moduleHeading = 'Network';			
			$this->set('moduleHeading',$moduleHeading);
			$this->set('moduleAction','Add');
			$this->set('helpURL','users');		
			//javascript validations
			$this->JQValidator->addValidation
			(
				'User',
				$this->User->validate,
				__('Save failed, fix the following errors:', true),
				'UserAddForm'
			);
					
			//layout options
			$this->set('page','network');
			$this->set('overview', true);
			$this->set('manage', true);
			$this->set('removeBanner', false);
			$this->set('removeSideMenu', false);
			$this->set('fullWidth', false);
		}
	}

	function edit($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1 && $_SESSION['Auth']['User']['group_id']!=3){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if($_SESSION['Auth']['User']['group_id']==1 || ($_SESSION['Auth']['User']['group_id']==3 && $_SESSION['Auth']['User']['id']==$id)){
                            $this->set('title_for_layout', 'Edit Users');
				if (!$id && empty($this->data)) {
					$this->flash(sprintf(__('Invalid user', true)), array('action' => 'index'));
				}
				if (!empty($this->data)) {
					if(isset($this->data['User']['checkPwd']) && $this->data['User']['checkPwd']==1){
						$pwd = mysql_real_escape_string($this->data['User']['npassword']);
						$this->data['User']['password'] = $this->Auth->password($pwd);
					}
					if ($this->User->save($this->data)) {
						if(isset($this->data['User']['checkPwd']) && $this->data['User']['checkPwd']==1){
							$this->_userPasswordUpdateMail($id, $pwd); //send update password email
						}
						if($_SESSION['Auth']['User']['id']==$id){
							$this->flash(__('Your profile has been updated.', true), array('action' => 'view', $id ));
						} else {
							$this->flash(__('The user has been saved.', true), array('action' => 'index'));
						}
					} else {
					}
				}
				if (empty($this->data)) {
					$this->data = $this->User->read(null, $id);
				}
				$this->layout='add-edit';
				$ckeditorClass = '';
				$this->set('ckeditorClass', $ckeditorClass);
				$ckfinderPath = Configure::read('Company.url').'app/webroot/js/ckfinder/';
				$this->set('ckfinderPath', $ckfinderPath);
				$this->loadModel('Groups'); //if it's not already loaded
				$options = $this->Groups->find('all'); //or whatever conditions you want
				$this->set('options',$options);
				$this->loadModel('UserStatuses'); //if it's not already loaded
				$us_options = $this->UserStatuses->find('all'); //or whatever conditions you want
				$this->set('us_options',$us_options);
				$this->loadModel('Tblstate'); //if it's not already loaded
				$stateOptions = $this->Tblstate->find('all'); //or whatever conditions you want
				$this->set('stateOptions',$stateOptions);
				//for shareholder drop down list
				$this->set('shareholders', $this->User->find('all',array('conditions' => array('User.parent_user_id = 0', 'User.group_id = 2'), 'order' => array('User.name' => 'DESC'))));
				$moduleHeading = 'Network';
				$this->set('moduleHeading',$moduleHeading);
				$this->set('moduleAction','Edit');
				$this->set('helpURL','users');		
				//javascript validations
				$this->JQValidator->addValidation
				(
					'User',
					$this->User->validate,
					__('Save failed, fix the following errors:', true),
					'UserEditForm'
				);
				
				//layout options
				$this->set('page','network');
				$this->set('overview', true);
				if($_SESSION['Auth']['User']['group_id']==1){
					$this->set('manage', true);
				}
				$this->set('removeBanner', false);
				$this->set('removeSideMenu', false);
				$this->set('fullWidth', false);
			} else {
                            $this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
			}
		}
	}

	function delete($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid user', true)), array('action' => 'index'));
			}
			if ($this->User->delete($id)) {
				$this->flash(__('User deleted', true), array('action' => 'index'));
			}
			$this->flash(__('User was not deleted', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function deletefile($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid File Name', true)), array('action' => 'index'));
		}
		if($this->User->saveField('logo','')){
			//we have successfully deleted file from DB
			$this->redirect(array('action' => 'edit/'.$id));
		} else {
			//deal with possible errors!
		}
		$this->autoRender=false;
	}
	
	//send basic email
	function _userPasswordUpdateMail($id,$pwd) {    
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));
		} else {
			$User = $this->User->read(NULL,$id);    
			$this->Email->to = $User['User']['email'];    
			$this->Email->bcc = array('mayur@echo3.com.au');      
			$this->Email->subject = 'CCAP Password Reset';    
			$this->Email->replyTo = 'admin@collegecapital.com.au';  //change when Go Live  
			$this->Email->from = Configure::read('Company.corporateEmail');   //change when Go Live 
			$this->Email->template = 'password_reset'; // note no '.ctp' 
			//Send as 'html', 'text' or 'both' (default is 'text')    
			$this->Email->sendAs = 'html'; // because we like to send pretty mail    		
			$this->set('pwd', $pwd); //pass on the pwd value to be sent in an email
			//Set view variables as normal    
			$this->set('User', $User);    
			//Do not pass any args to send()    
			$this->Email->send(); 
		}
	}
	
	function publish($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid network', true)), array('action' => 'index'));
			}
			if ($this->User->saveField('status_id',1,false)) {
				$this->flash(__('Network now active', true), array('action' => 'index'));
			}
			$this->flash(__('There were some issues. Please try again.', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function unpublish($id = null) {
		if($_SESSION['Auth']['User']['group_id']!=1){
			$this->redirect(array('controller'=>'claims','action'=>'homedisplay','home'));	
		} else {
			if (!$id) {
				$this->flash(sprintf(__('Invalid network', true)), array('action' => 'index'));
			}
			if ($this->User->saveField('status_id',2,false)) {
				$this->flash(__('Network now inactive', true), array('action' => 'index'));
			}
			$this->flash(__('There were some issues. Please try again.', true), array('action' => 'index'));
			$this->redirect(array('action' => 'index'));
		}
	}
        
        function myprofile(){
                    $id = $_SESSION['Auth']['User']['id'];   
                    $userDetails = $this->User->read(null, $id);
                    $this->set('user', $userDetails);
                    $this->loadModel('Tblstate'); //if it's not already loaded
                    $streetState = $this->Tblstate->find('first', array('fields' => array('State'), 'conditions' => array('Tblstate.id' => $userDetails['User']['street_state_id']))); //or whatever conditions you want
                    $this->set('streetState', $streetState);
                    $postalState = $this->Tblstate->find('first', array('fields' => array('State'), 'conditions' => array('Tblstate.id' => $userDetails['User']['postal_state_id']))); //or whatever conditions you want
                    $this->set('postalState', $postalState);

                    $this->set('userList', false);

                    $moduleHeading = "{$_SESSION['Auth']['User']['name']} Details";
                    $this->set('moduleHeading', $moduleHeading);
                    $this->set('moduleAction', 'View');
                    //$this->set('helpURL', 'users');

                    //layout options
                    $this->set('page', 'myaccount');
                    $this->set('overview', false);
                    $this->set('profile', true);
                    $this->set('removeBanner', false);
                    $this->set('removeSideMenu', false);
                    $this->set('fullWidth', false);
        }
        
        function changedetails(){
            $id = $_SESSION['Auth']['User']['id'];                    
            $this->set('title_for_layout', 'Edit Users');
				if (!$id && empty($this->data)) {
					$this->flash(sprintf(__('Invalid user', true)), array('action' => 'myprofile'));
				}
				if (!empty($this->data)) {
                                    if(isset($this->data['User']['checkPwd']) && $this->data['User']['checkPwd']== 1){
						$pwd = mysql_real_escape_string($this->data['User']['npassword']);
						$this->data['User']['password'] = $this->Auth->password($pwd);
					}
                                    // update latitude and longitude for user
                                    $this->updateUserLatAndLnginDB();
					if ($this->User->save($this->data)) {
                                            if(isset($this->data['User']['checkPwd']) && $this->data['User']['checkPwd']== 1){
							$this->_userPasswordUpdateMail($id, $pwd); //send update password email
                                                        $this->flash(__('The user new details and password has been saved. Please login from new password.', true), array('action' => 'logout'));
						}
                                                else{
                                                    $this->flash(__('The user details has been saved.', true), array('action' => 'myprofile'));
                                                }
					} 
				}
				if (empty($this->data)) {
					$this->data = $this->User->read(null, $id);
				}
				//$this->layout='add-edit';
				$ckeditorClass = '';
				$this->set('ckeditorClass', $ckeditorClass);
				$ckfinderPath = Configure::read('Company.url').'app/webroot/js/ckfinder/';
				$this->set('ckfinderPath', $ckfinderPath);
				$this->loadModel('Groups'); //if it's not already loaded
				$options = $this->Groups->find('all'); //or whatever conditions you want
				$this->set('options', $options);
				$this->loadModel('UserStatuses'); //if it's not already loaded
				$us_options = $this->UserStatuses->find('all'); //or whatever conditions you want
				$this->set('us_options',$us_options);
				$this->loadModel('Tblstate'); //if it's not already loaded
				$stateOptions = $this->Tblstate->find('all'); //or whatever conditions you want
				$this->set('stateOptions',$stateOptions);
				//for shareholder drop down list
				//$this->set('shareholders', $this->User->find('all',array('conditions' => array('User.parent_user_id = 0', 'User.group_id = 2'), 'order' => array('User.name' => 'DESC'))));
				$moduleHeading = 'Change My Details';
				$this->set('moduleHeading', $moduleHeading);
				//$this->set('moduleAction', 'View');
				//$this->set('helpURL','users');		
				//javascript validations
				$this->JQValidator->addValidation
				(
					'User',
					$this->User->validate,
					__('Save failed, fix the following errors:', true),
					'UserEditForm'
				);
				
				//layout options
				$this->set('page', 'myprofile');
                                $this->set('overview', false);
                                $this->set('profile', true);
                                $this->set('removeBanner', false);
                                $this->set('removeSideMenu', false);
                                $this->set('fullWidth', false);
                               
        }
        
        function changepassword(){
            
        }
}
