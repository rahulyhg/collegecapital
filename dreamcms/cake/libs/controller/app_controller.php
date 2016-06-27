<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {
	var $components = array('Auth');
	function beforeFilter() {
		$this->Auth->userModel = 'User';
		$this->Auth->fields = array('username' => 'username', 'password' => 'password');
		$this->Auth->loginAction = array('admin' => false, 'controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'claims', 'action' => 'homedisplay', 'home');
		$this->Auth->loginError = 'Invalid Username or Password.';
		$this->Auth->authError = 'You are not authorized to access.';
		//Restrict access to only users with an active account
		$this->Auth->userScope = array('User.status_id = 1');		
		
		//pic flow settings
		//$this->pfSettings = $this->getSettings();
		//$this->fillLayout();
	}
	
	function fillLayout()
	{
		$this->set('site_name', $this->pfSettings['name']);
		$this->set('site_title', $this->pfSettings['name']);
		$this->set('site_description', $this->pfSettings['description']);		 
	}
	
	function getSettings()
	{		
		//check to see if they are in the cache.
		if (!$cachedSettings = Cache::read('settings')) {
			//load settings model
			$this->loadModel('Setting');
			//find all in the settings database
			if($settings = $this->Setting->find('all')) {
				$configurations = array();
				foreach ($settings as $setting):
					$configurations[$setting['Setting']['key']] = $setting['Setting']['value'];
				endforeach;
				Cache::write('settings', $configurations);
				return $configurations;
			}
			else
			{
				//TODO: set error that settings failed
				exit();
			}
		} else {
			//return the cached settings.
			return $cachedSettings;
		}
	}
}
